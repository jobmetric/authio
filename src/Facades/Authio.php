<?php

namespace JobMetric\Authio\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JobMetric\Authio\Authio
 *
 * @method static array request(array $params = [])
 * @method static array loginOtp(array $params = [])
 * @method static array loginPassword(array $params = [])
 * @method static array resend(array $params = [])
 */
class Authio extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \JobMetric\Authio\Authio::class;
    }
}
