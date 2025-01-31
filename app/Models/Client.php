<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 
        'email',
        'phone',
        'address', 
        'activity',
        'contact_name',
        'contact_position', 
        'contact_email', 
        'contact_phone'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function interviews() {
        return $this->hasMany(Interview::class);
    }
    
}
