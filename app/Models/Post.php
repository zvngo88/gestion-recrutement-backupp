<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    const STATUS_ACTIF = 'Actif';
    const STATUS_INACTIF = 'Inactif';


    public function isActif()
    {
        return $this->status === self::STATUS_ACTIF;
    }
}
