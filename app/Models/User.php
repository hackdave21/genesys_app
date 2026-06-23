<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'google_id',
        'google_token',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: A user (client) has many quotes.
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class, 'user_id');
    }

    /**
     * Relationship: A user (client) has many projects.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    /**
     * Helper to check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Helper to check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // ──────────────────────────────────────────────
    // Inspira / SaaS relationships
    // ──────────────────────────────────────────────

    public function contentProfile()
    {
        return $this->hasOne(ContentProfile::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function contentIdeas()
    {
        return $this->hasMany(ContentIdea::class);
    }

    /**
     * Retourne l'abonnement actif courant (status = active et expires_at > maintenant).
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->latest('expires_at')
            ->first();
    }

    /**
     * Vérifie si l'utilisateur possède un abonnement actif.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }
}
