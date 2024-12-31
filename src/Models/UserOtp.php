<?php

namespace JobMetric\Authio\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOtp extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

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
        'used_at' => 'datetime',
        'created_at' => 'datetime'
    ];

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
