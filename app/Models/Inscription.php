<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'formation_id',
        'rentree_id',  
        'valide_admin',
        'valide_pedagogique',
        'admin_validator_id',
        'pedagogique_validator_id',
        'date_validation_admin',
        'date_validation_pedagogique',
        'nom_diplome',
        'moyenne',
        'carte_identite',
        'diplome',
        'paiement_effectue',
 
    ];

    protected $casts = [
        'valide_admin' => 'boolean',
        'valide_pedagogique' => 'boolean',
        'date_validation_admin' => 'datetime',
        'date_validation_pedagogique' => 'datetime',
    ];

    public function rentree()
    {
    return $this->belongsTo(\App\Models\Rentree::class);
    }

    /**
     * Étudiant (relation avec User)
     */
    public function etudiant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Formation associée
     */
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    /**
     * Admin qui a validé
     */
    public function adminValidator()
    {
        return $this->belongsTo(User::class, 'admin_validator_id');
    }

    /**
     * Responsable pédagogique qui a validé
     */
    public function pedagogiqueValidator()
    {
        return $this->belongsTo(User::class, 'pedagogique_validator_id');
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}