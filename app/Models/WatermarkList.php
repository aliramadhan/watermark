<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatermarkList extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'file_size',
        'width',
        'height',
        'total_page',
    ];
}
