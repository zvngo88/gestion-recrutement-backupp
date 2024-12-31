<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'name', 'email', 'status', 'skills', 'resume',
        'first_name', 'last_name', 'phone', 'address',
        'current_position', 'current_company', 'domains',
        'diploma', 'school', 'nationality'
    ];


    // Méthode pour définir le statut du candidat
    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
