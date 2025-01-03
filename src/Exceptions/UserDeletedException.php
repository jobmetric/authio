<?php

namespace JobMetric\Authio\Exceptions;

use Exception;
use Throwable;

class UserDeletedException extends Exception
{
    public function __construct(string $name, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(trans('authio::base.exceptions.user_deleted', [
            'name' => $name,
        ]), $code, $previous);
    }
}
