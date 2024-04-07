<?php

namespace camilord\utilus\String;

use DateTime;

class DateTimeUtil 
{
    const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    public static function now(): string
    {
        return (new DateTime())->format(self::DEFAULT_FORMAT);
    }

    public static function microtime_as_float(string $s): float
    {
        $dt = new DateTime($s);
        return (float)$dt->format('U.u');
    }
}
