<?php
namespace JobMetric\Authio\Enums;

use JobMetric\PackageCore\Enums\EnumToArray;

enum OtpTypeEnum : string {
    use EnumToArray;

    case NEW = "new";
    case UPDATE = "update";
    case LOCKED = "locked";
    case LOCKED_SECURITY = "locked_security";
    case LOCKED_BLOCK = "locked_block";
}
