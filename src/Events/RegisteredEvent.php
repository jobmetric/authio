<?php

namespace JobMetric\Authio\Events;

use JobMetric\Authio\Models\User;

class RegisteredEvent
{
    public User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
