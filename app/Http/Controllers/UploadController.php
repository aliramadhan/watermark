<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File; 
use Session;

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
        return view('Upload.upload2');
    }
    public function editWatermarkPDF(Request $request)
    {
        $mpdf = new Mpdf();
        $pagecount = $mpdf->setSourceFile('temp/pdf_'.auth()->user()->id.'.pdf');
        if (strlen($request->pages) > 0) {
            $pageWatermarked = explode(",", $request->pages);
        }
        if ($request->opacity) {
            $request->opacity = $request->opacity/100;
        }
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
        $mpdf->Output('temp/output_pdf'.auth()->user()->id.'.pdf','F');
        $embedPDF = "<embed id='embedPDF' src='../temp/output_pdf".auth()->user()->id.".pdf' width='100%' height='1100px' type='application/pdf'>";
        return response()->json(['embedPDF'=> $embedPDF]);
    }
    public function imageFileUpload2(Request $request)
    {
        $this->validate($request, [
            'pdf' => 'required|mimes:pdf|max:10000',
            'watermark' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:4096',
        ]);
        $pdf = $request->file('pdf');
        $watermark = $request->file('watermark');

        #move uploaded file to temp dir
        $pdf->move(public_path('temp/'), 'pdf_'.auth()->user()->id.'.pdf');
        $watermark->move(public_path('temp/'), 'watermark_'.auth()->user()->id.'.png');

        return back()->withInput()
            ->with('success','File successfully uploaded.');
    }
}
