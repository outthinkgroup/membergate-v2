<?php

namespace Membergate\Common;
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


final class Time extends Enum {
	private const MINUTE = MINUTE_IN_SECONDS;
	private const QUARTERHR = 15 * MINUTE_IN_SECONDS;
	private const HALFHR = 30 * MINUTE_IN_SECONDS;
	private const HOUR = HOUR_IN_SECONDS;
	private const DAY = DAY_IN_SECONDS;
	private const WEEK = WEEK_IN_SECONDS;
	private const MONTH = MONTH_IN_SECONDS;
	private const YEAR = YEAR_IN_SECONDS;

	static public function Minute(){
		return new Time(self::MINUTE);
	}
	static public function QuarterHr(){
		return new Time(self::QUARTERHR);
	}
	static public function HalfHr(){
		return new Time(self::HALFHR);
	}
	static public function Hour(){
		return new Time(self::HOUR);
	}

	static public function Day(){
		return new Time(self::DAY);
	}

	static public function Week(){
		return new Time(self::WEEK);
	}
	static public function Month(){
		return new Time(self::MONTH);
	}
	static public function Year(){
		return new Time(self::YEAR);
	}
}
