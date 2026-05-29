<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rentree extends Model
{
    protected $table = 'rentrees';

    protected $fillable = [
        'annee',
        'date_debut',
        'date_fin',
    ];

    protected $dates = [
        'date_debut',
        'date_fin',
    ];

    public function inscriptions()
    {
        return $this->hasMany(\App\Models\Inscription::class);
    }
}