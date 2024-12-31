<?php

namespace JobMetric\Authio\Models;

use Illuminate\Database\Eloquent\Builder;

trait HasBlock
{
    /**
     * Scope a query to only include users blocked.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOfBlock(Builder $query): Builder
    {
        return $query->whereNotNull('blocked_at');
    }

    /**
     * Scope a query to only include users unblocked.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOfFree(Builder $query): Builder
    {
        return $query->whereNull('blocked_at');
    }

    /**
     * now blocked
     *
     * @return bool
     */
    public function nowBlocked(): bool
    {
        return $this->update(['blocked_at' => now()]);
    }

    /**
     * now free
     *
     * @return bool
     */
    public function nowFree(): bool
    {
        return $this->update(['blocked_at' => null]);
    }
}
