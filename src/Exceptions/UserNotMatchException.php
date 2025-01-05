<?php

namespace JobMetric\Authio\Exceptions;

use Exception;
use Throwable;

class UserNotMatchException extends Exception
{
    public function __construct(int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(trans('authio::base.exceptions.user_not_match'), $code, $previous);
    }
}
