<?php

namespace JobMetric\Authio\Events;

use JobMetric\Authio\Models\User;

class SendOtpSmsEvent
{
    public User $user;
    public string $otp;
    public string|null $hash;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $otp, string $hash = null)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->hash = $hash;
    }
}
