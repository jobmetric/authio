<?php

namespace JobMetric\Authio\Exceptions;

use Exception;
use Throwable;

class PasswordNotFoundException extends Exception
{
    public function __construct(int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(trans('authio::base.exceptions.password_not_found'), $code, $previous);
    }
}
