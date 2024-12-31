<?php

namespace JobMetric\Authio\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static ofName(string $name, bool $withTrashed = false)
 * @method static ofMobile(string $mobile_prefix, string $mobile, bool $withTrashed = false)
 * @method static ofEmail(string $email, bool $withTrashed = false)
 * @method static create(array $array)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasBlock;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_prefix',
        'mobile',
        'mobile_verified_at',
        'email',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mobile_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Scope a query to only include users of a given name.
     *
     * @param Builder $query
     * @param string $name
     * @param bool $withTrashed
     *
     * @return Builder
     */
    public function scopeOfName(Builder $query, string $name, bool $withTrashed = false): Builder
    {
        $q = $query->where('name', $name);

        if($withTrashed) {
            $q->withTrashed();
        }

        return $q;
    }

    /**
     * Scope a query to only include users of a given mobile.
     *
     * @param Builder $query
     * @param string $mobile_prefix
     * @param string $mobile
     * @param bool $withTrashed
     *
     * @return Builder
     */
    public function scopeOfMobile(Builder $query, string $mobile_prefix, string $mobile, bool $withTrashed = false): Builder
    {
        $q = $query->where([
            'mobile_prefix' => $mobile_prefix,
            'mobile' => $mobile,
        ]);

        if($withTrashed) {
            $q->withTrashed();
        }

        return $q;
    }

    /**
     * Scope a query to only include users of a given email.
     *
     * @param Builder $query
     * @param string $email
     * @param bool $withTrashed
     *
     * @return Builder
     */
    public function scopeOfEmail(Builder $query, string $email, bool $withTrashed = false): Builder
    {
        $q = $query->where('email', $email);

        if($withTrashed) {
            $q->withTrashed('deleted_at');
        }

        return $q;
    }

    /**
     * now verified mobile
     *
     * @return bool
     */
    public function nowVerifiedMobile(): bool
    {
        return $this->update(['mobile_verified_at' => now()]);
    }

    /**
     * now verified email
     *
     * @return bool
     */
    public function nowVerifiedEmail(): bool
    {
        return $this->update(['email_verified_at' => now()]);
    }
}
