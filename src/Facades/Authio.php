<?php

namespace JobMetric\Authio\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JobMetric\Authio\Authio
 *
 * @method static \JobMetric\Authio\Http\Resources\RequestResource request(array $data)
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
