<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'name',
        'email',
        'status',
        'skills', // Ajoutez des compétences ou d'autres champs selon vos besoins
    ];

    // Méthode pour définir le statut du candidat
    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
    }
}
