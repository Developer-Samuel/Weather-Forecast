<?php

namespace App\Services;

use Carbon\Carbon;

class DateService
{
    public static function formatDate(?string $date): ?string
    {
        if (!$date) return null;
        return Carbon::createFromFormat('d.m.Y', $date)->format('Y-m-d');
    }

    public static function formatTime(?string $time): ?string
    {
        if (!$time) return null;
        return Carbon::createFromFormat('H:i:s', str_replace('-', ':', $time))->format('H:i:s');
    }

    public static function getLabelForDate(string $date): string
    {
        $dateObj = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        $today = now()->startOfDay();
        $tomorrow = now()->addDay()->startOfDay();

        if ($dateObj->equalTo($today)) {
            return 'Today';
        }

        if ($dateObj->equalTo($tomorrow)) {
            return 'Tomorrow';
        }

        $diff = $today->diffInDays($dateObj, false);
        return ($diff >= 2 && $diff <= 6) ? "In {$diff} days" : '';
    }

    public static function getDateTimeParts(string $dt): array
    {
        return explode(' ', $dt);
    }
}
