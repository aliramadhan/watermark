<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File; 
use Session;
use App\Models\QueueSignature;
use App\Models\DetailQueue;

class UploadController extends Controller
{
    public function index()
    {
        return view('Upload.upload');
    }
    
    public function imageFileUpload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:4096',
            'watermark' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:4096',
        ]);

        $fileName = time().'.'.$request->file('image')->getClientOriginalExtension();

        $image = Image::make($request->file('image')->getRealPath());
        $watermark = Image::make($request->file('watermark')->getRealPath())->resize(200,200);

        /* insert watermark at bottom-right corner with 10px offset */
        $image->insert($watermark, 'bottom-right', 10, 10);

        $image->save(public_path($fileName));

        return back()
            ->with('success','File successfully uploaded.')
            ->with('fileName',$fileName);         
    }
    public function index2()
    {
        #delete file if any at temp
        /*
        if (file_exists(public_path('temp/output_pdf'.auth()->user()->id.'.pdf')) && !Session::has('success')) {
            File::delete(public_path('temp/output_pdf'.auth()->user()->id.'.pdf'));
        }
        if (file_exists(public_path('temp/watermark_'.auth()->user()->id.'.png'))&& !Session::has('success')) {
            File::delete(public_path('temp/watermark_'.auth()->user()->id.'.png'));
        }*/
        $user = auth()->user();
        $queue = QueueSignature::where('user_id',$user->id)->first();
        if ($queue != null) {
            $queue->fileSize = $this->formatBytes($queue->file_size);
        }
        return view('Upload.upload2',compact('user','queue'));
    }
    public function editWatermarkPDF(Request $request)
    {
        #get page
        if (strlen($request->pages) > 0) {
            $pageWatermarked = explode(",", $request->pages);
        }
        #get opacity
        if ($request->opacity) {
            $request->opacity = $request->opacity/100;
        }
        $user = auth()->user();
        $queue = QueueSignature::where('user_id',$user->id)->first();
        $details = DetailQueue::where('queue_signature_id',$queue->id)->whereIn('page',$pageWatermarked)->get();
        #applied watermark to page 
        foreach ($details as $detail) {
            $mpdf = new Mpdf();
            $mpdf->setSourceFile($detail->file_path);
            $import_page = $mpdf->ImportPage(1);
            $mpdf->UseTemplate($import_page);
            $mpdf->SetWatermarkImage(
                'temp/watermark_'.auth()->user()->id.'.png',
                $request->opacity,
                array($request->width,$request->height),
                array($request->x,$request->y),
            );
            $mpdf->showWatermarkImage = true;
            $mpdf->Output($detail->file_path,'F');
        }
        /*
        for ($i=1; $i<=$pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            $mpdf->SetWatermarkImage(
                'temp/watermark_'.auth()->user()->id.'.png',
                $request->opacity,
                array($request->width,$request->height),
                array($request->x,$request->y),
            );
            if (strlen($request->pages) > 0) {
                if (in_array($i, $pageWatermarked)) {
                    $mpdf->showWatermarkImage = true;
                }
                else{
                    $mpdf->showWatermarkImage = false;
                }
            }
            if ($i < $pagecount)
                $mpdf->AddPage();
        }
        */
        //$mpdf->Output('temp/output_pdf'.auth()->user()->id.'.pdf','F');
        $embedPDF = "";
        foreach ($queue->details as $detail) {
            $embedPDF .= "<embed id='embedPDF' src='../".$detail->file_path."' width='100%' height='600px' type='application/pdf'>";
        }
        return response()->json(['embedPDF'=> $embedPDF]);
    }
    public function resetWatermarkPDF(Request $request)
    {
        $mpdf = new Mpdf();
        $user = auth()->user();
        $queue = QueueSignature::where('user_id',$user->id)->first();
        $pagecount = $mpdf->setSourceFile('temp/pdf_'.$user->id.'.pdf');

        //applied from uploaded file
        for ($i=1; $i<=$pagecount; $i++) {
            /*
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            if ($i < $pagecount)
                $mpdf->AddPage();
                */
            $new_mpdf = new Mpdf();
            $new_mpdf->setSourceFile('temp/pdf_'.$user->id.'.pdf');
            $import_page = $new_mpdf->ImportPage($i);
            $new_mpdf->UseTemplate($import_page);
            $new_mpdf->Output('temp/detail_pdf_'.$i.'.pdf','F');
        }
        //$mpdf->Output('temp/output_pdf'.auth()->user()->id.'.pdf','F');
        //$embedPDF = "<embed id='embedPDF' src='../temp/output_pdf".auth()->user()->id.".pdf' width='100%' height='600px' type='application/pdf'>";
        $embedPDF = "";
        foreach ($queue->details as $detail) {
            $embedPDF .= "<embed id='embedPDF' src='../".$detail->file_path."' width='100%' height='600px' type='application/pdf'>";
        }
        return response()->json(['embedPDF'=> $embedPDF]);
    }
    public function imageFileUpload2(Request $request)
    {
        $this->validate($request, [
            'pdf' => 'required|mimes:pdf|max:10000',
            'watermark' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:4096',
        ]);
        $user = auth()->user();
        $pdf = $request->file('pdf');
        $watermark = $request->file('watermark');
        $getSize = $pdf->getSize();

        #move uploaded file to temp dir
        $pdf->move(public_path('temp/'), 'pdf_'.$user->id.'.pdf');
        $watermark->move(public_path('temp/'), 'watermark_'.$user->id.'.png');
        #get total page
        $mpdf = new Mpdf();
        $pagecount = $mpdf->setSourceFile('temp/pdf_'.auth()->user()->id.'.pdf');

        #inser to database
        $queue = QueueSignature::updateOrCreate([
            'user_id' => $user->id
        ],[
            'file_path' => 'temp/pdf_'.$user->id.'.pdf',
            'file_name' => $pdf->getClientOriginalName(),
            'file_size' => $getSize,
            'total_page' => $pagecount,
        ]);

        #convert per page to new pdf file
        for ($i=1; $i<=$pagecount; $i++) {
            $new_mpdf = new Mpdf();
            $new_mpdf->setSourceFile('temp/pdf_'.$user->id.'.pdf');
            $import_page = $new_mpdf->ImportPage($i);
            $new_mpdf->UseTemplate($import_page);
            $new_mpdf->Output('temp/detail_pdf_'.$i.'.pdf','F');
            $detail_queue = DetailQueue::create([
                'queue_signature_id' => $queue->id,
                'page' => $i,
                'file_path' => 'temp/detail_pdf_'.$i.'.pdf',
                'x' => 0,
                'y' => 0,
                'width' => 0,
                'height' => 0,
                'opacity' => 0,
                'is_watermarked' => false,
            ]);
        }

        return back()->withInput()
            ->with('success','File successfully uploaded.');
    }
    public function deleteQueueSignature(QueueSignature $queue)
    {
        $user = auth()->user();
        $queue = QueueSignature::where('user_id',$user->id)->first();
        $watermark = public_path('temp/watermark_'.$user->id.'.png');
        if ($queue != null) {
            foreach ($queue->details as $detail) {
                unlink($detail->file_path);
                $detail->delete();
            }
            //File::delete($image_path);
            unlink($queue->file_path);
            unlink($watermark);
            $queue->delete();
        }
        return redirect()->back()->with('success','Delete berhasil.');
    }
    public function exportSignature()
    {
        $user = auth()->user();
        $queue = QueueSignature::where('user_id',$user->id)->first();
        $mpdf = new Mpdf();
        $pagecount = $mpdf->setSourceFile($queue->file_path);
        foreach ($queue->details as $detail) {
            $new_mpdf = new Mpdf();
            $new_mpdf->setSourceFile($detail->file_path);
            $import_page = $new_mpdf->ImportPage(1);
            $mpdf->UseTemplate($import_page);
            $mpdf->AddPage();
        }
        $mpdf->Output('temp/download'.$user->id.'.pdf','F');
    }
    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}
