<?php

namespace JobMetric\Authio\Enums;

use JobMetric\PackageCore\Enums\EnumToArray;

/**
 * @method string MOBILE()
 * @method string EMAIL()
 */
enum LoginTypeEnum: string
{
    use EnumToArray;

    case MOBILE = 'mobile';
    case EMAIL = 'email';
}
