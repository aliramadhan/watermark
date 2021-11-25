<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailQueue extends Model
{
    use HasFactory;
    protected $fillable = [
        'queue_signature_id',
        'file_path',
        'x',
        'y',
        'width',
        'height',
        'opacity',
        'is_watermarked',
    ];
}
