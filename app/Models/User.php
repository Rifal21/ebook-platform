<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'role', 'user_code', 'phone_number', 'address'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids;

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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function purchasedEbooks()
    {
        return $this->hasMany(Order::class)->where('status', 'completed');
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->user_code) {
                do {
                    $code = 'USR-' . strtoupper(Str::random(8));
                } while (static::where('user_code', $code)->exists());
                $user->user_code = $code;
            }
        });
    }

    public function sendEmailVerificationNotification()
    {
        try {
            $this->notify(new \App\Notifications\QueuedVerifyEmail);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim verifikasi email (queue error): ' . $e->getMessage());
        }
    }

    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }
}
