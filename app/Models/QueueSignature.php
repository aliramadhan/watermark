<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueSignature extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'file_size',
        'total_page',
    ];
    public function details()
    {
        return $this->hasMany(DetailQueue::class, 'queue_signature_id', 'id');
    }
}
