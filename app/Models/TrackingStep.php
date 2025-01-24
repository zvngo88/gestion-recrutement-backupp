<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStep extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'name', 'status', 'reason'];

    /**
     * Relation avec les affectations.
     */
    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_tracking_step')
                    ->withPivot('status', 'reason')
                    ->withTimestamps();
    }
}
