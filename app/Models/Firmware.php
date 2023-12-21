<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firmware extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'size',
        'date',
        'extension',
        'platform',
        'crc32',
        'data'
    ];

    public function path()
    {
        return $this->belongsTo(Path::class);
    }
}
