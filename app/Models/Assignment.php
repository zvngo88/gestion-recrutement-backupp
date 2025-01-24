<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'post_id',
        'assigned_at',
    ];

    /**
     * Relation avec le candidat.
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Relation avec le poste.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function trackingSteps()
    {
        return $this->belongsToMany(TrackingStep::class, 'assignment_tracking_step')
                    ->withPivot('status', 'reason')
                    ->withTimestamps();
    }

}
