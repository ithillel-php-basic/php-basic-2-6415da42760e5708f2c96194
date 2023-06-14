<?php
namespace helpers;

use Carbon\Carbon;

class DateHandler
{
    private const SECONDS_PER_DAY = 86400;

    public static function timeRemains(string $date): string
    {
        $now = Carbon::now();
        $diffInSeconds = $now->diffInSeconds(Carbon::parse($date), false);
        $diffInSeconds = max($diffInSeconds, 0);

        if ($diffInSeconds <= self::SECONDS_PER_DAY) {
            $diffInHours = $now->diffInHours(Carbon::parse($date), false);
            $diffInHours = max($diffInHours, 0);

            return self::formatBadge($date, $diffInHours.' год', 'badge-danger');
        }

        $diffInDays = $now->diffInDays(Carbon::parse($date), false);
        $diffInHours = $now->diffInHours(Carbon::parse($date), false) % 24;

        return self::formatBadge($date, $diffInDays.' дн : '.$diffInHours.' год', 'badge-success');
    }

    private static function formatBadge(string $date, string $value, string $badgeClass): string
    {
        return sprintf(
            '<small class="badge %s" title="%s"><i class="far fa-clock"></i> %s</small>',
            $badgeClass,
            $date,
            $value);
    }
}