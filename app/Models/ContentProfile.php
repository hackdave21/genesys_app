<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'niche',
        'target_audience',
        'tone',
        'platform',
        'frequency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
