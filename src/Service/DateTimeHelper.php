<?php

declare(strict_types=1);

namespace App\Service;

use DateInterval;
use DateTime;
use DateTimeInterface;

class DateTimeHelper
{
    public static function getInterval(int $interval, DateTime $currentDate): DateTimeInterface
    {
        return $currentDate->add(new DateInterval('PT'.$interval.'S'));
    }
}