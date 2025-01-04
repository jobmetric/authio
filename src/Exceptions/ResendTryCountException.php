<?php

namespace JobMetric\Authio\Exceptions;

use Exception;
use Throwable;

class ResendTryCountException extends Exception
{
    public function __construct(int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(trans('authio::base.exceptions.resend_try_count'), $code, $previous);
    }
}
