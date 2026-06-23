<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentIdea extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'prompt_used',
        'sent_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
