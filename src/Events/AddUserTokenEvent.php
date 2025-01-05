<?php

namespace JobMetric\Authio\Events;

use JobMetric\Authio\Models\UserToken;

class AddUserTokenEvent
{
    public UserToken $userToken;

    /**
     * Create a new event instance.
     *
     * @param UserToken $userToken
     *
     * @return void
     */
    public function __construct(UserToken $userToken)
    {
        $this->userToken = $userToken;
    }
}
