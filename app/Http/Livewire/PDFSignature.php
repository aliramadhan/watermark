<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Image;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File; 
use Session;
use App\Models\QueueSignature;
use App\Models\WatermarkList;
use App\Models\DetailQueue;

class PDFSignature extends Component
{
	public  $user, $queue, $signature, $watermark;

	protected $listeners = [
		'setWatermark' => 'setWatermark',
		'refreshComponent' => '$refresh',
	];

    public function render()
    {
    	$this->user = auth()->user();
        $this->queue = QueueSignature::where('user_id',$this->user->id)->first();
        $this->signature = WatermarkList::where('user_id',$this->user->id)->get();
        if ($this->queue != null) {
            $this->queue->fileSize = $this->formatBytes($this->queue->file_size);
        }
        return view('livewire.pdfsignature');
    }
    public function mount()
    {
    	$this->watermark = WatermarkList::where('user_id',auth()->user()->id)->orderBy('id', 'DESC')->first();
    }
    public function setWatermark($file_path)
    {
    	$this->watermark = WatermarkList::where('file_path',$file_path)->first();
    }
    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}
