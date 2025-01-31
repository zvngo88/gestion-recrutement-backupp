<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'post_id', 'candidate_id', 'interview_date'];

    protected $casts = [
        'interview_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id'); // 'post_id' est la colonne dans la table 'interviews' qui contient l'ID du poste
    }



    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
