<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'name', 
        'status', 
        'start_date', 
        'end_date'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
