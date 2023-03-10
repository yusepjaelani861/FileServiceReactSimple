<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resize extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'file_id',
        'name',
        'path',
        'extension',
        'mime_type',
        'size',
        'disk',
        'url',
    ];
}
