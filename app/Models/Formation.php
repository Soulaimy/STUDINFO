<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = ['titre', 'description', 'duree'];

    public function inscriptions()
    {
        return $this->hasMany(\App\Models\Inscription::class);
    }
}