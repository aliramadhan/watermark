<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

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
}
