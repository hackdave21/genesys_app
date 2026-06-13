<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'company',
        'email',
        'phone',
        'project_type',
        'budget',
        'description',
        'status',
        'user_id',
    ];

    /**
     * Relationship: A quote belongs to a user (optional client).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: A quote may have an associated Kanban project.
     */
    public function project()
    {
        return $this->hasOne(Project::class, 'quote_id');
    }
}
