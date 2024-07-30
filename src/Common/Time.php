<?php

namespace Membergate\Common;

if (!defined('ABSPATH')) {
    exit;
}

use MyCLabs\Enum\Enum;

// enum Time: int {
// 	case Minute = MINUTE_IN_SECONDS;
// 	case QuarterHr = 15 * MINUTE_IN_SECONDS;
// 	case HalfHr = 30 * MINUTE_IN_SECONDS;
// 	case Hour = HOUR_IN_SECONDS;
// 	case Day = DAY_IN_SECONDS;
// 	case Week = WEEK_IN_SECONDS;
// 	case Month = MONTH_IN_SECONDS;
// 	case Year = YEAR_IN_SECONDS;
// }



/** @package Membergate\Common
 * @psalm-immutable
 * @psalm-suppress MissingTemplateParam */
final class Time extends Enum {
    /** @psalm-suppress UndefinedConstant */
    private const MINUTE = MINUTE_IN_SECONDS;

    /** @psalm-suppress UndefinedConstant */
    private const QUARTERHR = 15 * MINUTE_IN_SECONDS;

    /** @psalm-suppress UndefinedConstant */
    private const HALFHR = 30 * MINUTE_IN_SECONDS;

    /** @psalm-suppress UndefinedConstant */
    private const HOUR = HOUR_IN_SECONDS;

    /** @psalm-suppress UndefinedConstant */
    private const DAY = DAY_IN_SECONDS;

    /** @psalm-suppress UndefinedConstant */
    private const WEEK = WEEK_IN_SECONDS;

    /** @psalm-suppress UndefinedConstant */
    private const MONTH = MONTH_IN_SECONDS;

    /** @psalm-suppress UndefinedConstant */
    private const YEAR = YEAR_IN_SECONDS;

    public static function Minute(): Time {
        return new Time(self::MINUTE);
    }

    public static function QuarterHr(): Time {
        return new Time(self::QUARTERHR);
    }

    public static function HalfHr(): Time {
        return new Time(self::HALFHR);
    }

    public static function Hour(): Time {
        return new Time(self::HOUR);
    }

    public static function Day(): Time {
        return new Time(self::DAY);
    }

    public static function Week(): Time {
        return new Time(self::WEEK);
    }

    public static function Month(): Time {
        return new Time(self::MONTH);
    }

    public static function Year(): Time {
        return new Time(self::YEAR);
    }
}
