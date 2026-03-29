<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = ['path', 'caption', 'tautan', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
