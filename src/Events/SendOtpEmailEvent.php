<?php

namespace JobMetric\Authio\Events;

use JobMetric\Authio\Models\User;

class SendOtpEmailEvent
{
    public User $user;
    public string $otp;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }
}
