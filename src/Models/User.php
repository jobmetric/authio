<?php

namespace JobMetric\Authio\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * JobMetric\Authio\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $mobile_prefix
 * @property string $mobile
 * @property Carbon $mobile_verified_at
 * @property string $password
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ofName(string $name, bool $withTrashed = false)
 * @method static ofMobile(string $mobile_prefix, string $mobile, bool $withTrashed = false)
 * @method static ofEmail(string $email, bool $withTrashed = false)
 * @method static create(array $array)
 */
class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes,
        HasBlock;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'mobile_prefix',
        'mobile',
        'mobile_verified_at',
        'password',
        'remember_token',
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
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'mobile_prefix' => 'string',
        'mobile' => 'string',
        'mobile_verified_at' => 'datetime',
        'password' => 'hashed',
        'remember_token' => 'string',
    ];

    public function getTable()
    {
        return config('authio.tables.user', parent::getTable());
    }

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
        $query->where('name', $name);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query;
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
        $query->where('email', $email);

        if ($withTrashed) {
            $query->withTrashed('deleted_at');
        }

        return $query;
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
        $query->where([
            'mobile_prefix' => $mobile_prefix,
            'mobile' => $mobile,
        ]);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query;
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

    /**
     * now verified mobile
     *
     * @return bool
     */
    public function nowVerifiedMobile(): bool
    {
        return $this->update(['mobile_verified_at' => now()]);
    }
}
