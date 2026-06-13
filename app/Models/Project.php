<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'quote_id',
        'client_id',
        'progress',
        'step',
        'priority',
        'team',
        'deadline',
    ];

    protected $casts = [
        'team' => 'array',
        'progress' => 'integer',
        'deadline' => 'date',
    ];

    /**
     * Relationship: A project belongs to a quote (devis).
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    /**
     * Relationship: A project belongs to a client.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
