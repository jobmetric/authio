<?php

namespace JobMetric\Authio\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * JobMetric\Authio\Models\UserToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $user_agent
 * @property string $ip_address
 * @property Carbon $logout_at
 * @property Carbon $expired_at
 * @property Carbon $created_at
 *
 * @method static ofUser(int $user_id)
 * @method static create(array $array)
 */
class UserToken extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'token',
        'user_agent',
        'ip_address',
        'logout_at',
        'expired_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'token' => 'string',
        'user_agent' => 'string',
        'logout_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function getTable()
    {
        return config('authio.tables.user_token', parent::getTable());
    }

    /**
     * relation user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include user tokens of a given user id.
     *
     * @param Builder $query
     * @param int $user_id
     *
     * @return Builder
     */
    public function scopeOfUser(Builder $query, int $user_id): Builder
    {
        return $query->where('user_id', $user_id);
    }
}
