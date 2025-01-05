<?php

namespace JobMetric\Authio\Exceptions;

use Exception;
use Throwable;

class UnauthorizedException extends Exception
{
    public function __construct(int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct(trans('authio::base.exceptions.unauthorized'), $code, $previous);
    }
}
