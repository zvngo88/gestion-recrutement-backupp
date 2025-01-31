<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'start_date', 'duration', 'client_id'];

    const STATUS_ACTIF = 'Actif';
    const STATUS_INACTIF = 'Inactif';

    protected $dates = ['start_date'];

   

    public function isActif()
    {
        return $this->status === self::STATUS_ACTIF;
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    // Relation many-to-many entre Post et Candidate
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function interviews() {
        return $this->hasMany(Interview::class);
    }

}
