<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'start_date', 'duration'];

    const STATUS_ACTIF = 'Actif';
    const STATUS_INACTIF = 'Inactif';


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


}
