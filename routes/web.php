<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Livewire\PDFSignature;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user', 'as' => 'user.'], function() {
	Route::get('upload', [UploadController::class, 'index'])->name('index.upload');
	Route::post('upload', [UploadController::class, 'imageFileUpload'])->name('store.upload');

	#route PDF
	Route::get('upload2', [UploadController::class, 'index2'])->name('index.upload2');
	Route::post('upload2', [UploadController::class, 'imageFileUpload2'])->name('store.upload2');
	Route::delete('upload2/{queue}/delete', [UploadController::class, 'deleteQueueSignature'])->name('delete.upload2');
	Route::post('edit-watermark-pdf', [UploadController::class, 'editWatermarkPDF'])->name('edit.watermark.pdf');
	Route::post('reset-watermark-pdf', [UploadController::class, 'resetWatermarkPDF'])->name('reset.watermark.pdf');
	Route::get('export', [UploadController::class, 'exportSignature'])->name('download.watermark.pdf');

	#upload Watermark
	Route::post('upload-watermark', [UploadController::class, 'uploadWatermark'])->name('upload.watermark');
	Route::get('pdf-signature', PDFSignature::class)->name('pdf.signature');

	#Manage Watermark
	Route::get('watermark', [UploadController::class, 'indexWatermark'])->name('index.watermark');
	Route::delete('watermark/{watermark}/delete', [UploadController::class, 'deleteWatermark'])->name('delete.watermark');
	#Manage PDF
	Route::get('pdf', [UploadController::class, 'indexPDF'])->name('index.pdf');
});