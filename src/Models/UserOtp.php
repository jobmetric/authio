<?php

namespace JobMetric\Authio\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * JobMetric\Authio\Models\UserOtp
 *
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $source
 * @property string $secret
 * @property string $otp
 * @property string $ip_address
 * @property int $try_count
 * @property Carbon $used_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ofUser(int $user_id)
 * @method static ofSecretNotUsed(string $secret)
 * @method static create(array $array)
 */
class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source',
        'secret',
        'otp',
        'ip_address',
        'try_count',
        'used_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'source' => 'string',
        'secret' => 'string',
        'otp' => 'string',
        'ip_address' => 'string',
        'try_count' => 'integer',
        'used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getTable()
    {
        return config('authio.tables.user_otp', parent::getTable());
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
     * Scope a query to only include user otps of a given user id.
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

    /**
     * Scope a query to only include user otp of a given secret not used.
     *
     * @param Builder $query
     * @param string $secret
     *
     * @return Builder
     */
    public function scopeOfSecretNotUsed(Builder $query, string $secret): Builder
    {
        return $query->where('secret', $secret)->whereNull('used_at');
    }

    /**
     * now used secret
     *
     * @return bool
     */
    public function nowUsed(): bool
    {
        return $this->update(['used_at' => now()]);
    }

    /**
     * increment try count for log
     *
     * @return int
     */
    public function nowTry(): int
    {
        return $this->increment('try_count');
    }
}
