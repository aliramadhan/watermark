<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Mpdf\Mpdf;

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
        return view('Upload.upload2');
    }
 
    public function imageFileUpload2(Request $request)
    {
        $this->validate($request, [
            'pdf' => 'required|mimes:pdf|max:10000',
            'watermark' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:4096',
        ]);
        #move uploaded file to temp dir
        $pdf = $request->file('pdf');
        $watermark = $request->file('watermark');
        $pdf->move(public_path(), 'asd.pdf');
        $watermark->move(public_path(), 'icon.png');

        $mpdf = new Mpdf();
        $pagecount = $mpdf->setSourceFile('asd.pdf');
        for ($i=1; $i<=$pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            $mpdf->SetWatermarkImage(
                'icon.png',
                0.9,
                array($request->widthWatermark,$request->heightWatermark),
                array($request->x,$request->y),
            );
            $mpdf->showWatermarkImage = true;

            if ($i < $pagecount)
                $mpdf->AddPage();
        }
        $mpdf->Output('filename.pdf','F');
        return back()->withInput()
            ->with('success','File successfully uploaded.');
    }
}
