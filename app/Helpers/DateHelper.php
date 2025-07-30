<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Indonesian month names
     */
    private static $indonesianMonths = [
        1 => 'Januari',
        2 => 'Februari', 
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    /**
     * Indonesian day names
     */
    private static $indonesianDays = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    /**
     * Format date in Indonesian format
     */
    public static function formatIndonesian($date, $format = 'd F Y')
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        
        // Convert to Jakarta timezone
        $carbon = $carbon->setTimezone('Asia/Jakarta');
        
        $day = $carbon->day;
        $month = self::$indonesianMonths[$carbon->month];
        $year = $carbon->year;
        $hour = $carbon->format('H');
        $minute = $carbon->format('i');
        $dayName = self::$indonesianDays[$carbon->format('l')];
        
        switch ($format) {
            case 'd F Y':
                return "{$day} {$month} {$year}";
            case 'd F Y H:i':
                return "{$day} {$month} {$year} {$hour}:{$minute}";
            case 'l, d F Y':
                return "{$dayName}, {$day} {$month} {$year}";
            case 'l, d F Y H:i':
                return "{$dayName}, {$day} {$month} {$year} {$hour}:{$minute}";
            case 'd/m/Y':
                return $carbon->format('d/m/Y');
            case 'd-m-Y':
                return $carbon->format('d-m-Y');
            case 'H:i':
                return "{$hour}:{$minute}";
            default:
                return "{$day} {$month} {$year}";
        }
    }

    /**
     * Format date for humans in Indonesian
     */
    public static function diffForHumansIndonesian($date)
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        $carbon = $carbon->setTimezone('Asia/Jakarta');
        $now = Carbon::now('Asia/Jakarta');
        
        $diffInSeconds = $now->diffInSeconds($carbon);
        $diffInMinutes = $now->diffInMinutes($carbon);
        $diffInHours = $now->diffInHours($carbon);
        $diffInDays = $now->diffInDays($carbon);
        $diffInWeeks = $now->diffInWeeks($carbon);
        $diffInMonths = $now->diffInMonths($carbon);
        $diffInYears = $now->diffInYears($carbon);
        
        $isFuture = $carbon->isFuture();
        
        if ($diffInSeconds < 60) {
            return $isFuture ? 'dalam beberapa detik' : 'beberapa detik yang lalu';
        } elseif ($diffInMinutes < 60) {
            return $isFuture ? "dalam {$diffInMinutes} menit" : "{$diffInMinutes} menit yang lalu";
        } elseif ($diffInHours < 24) {
            return $isFuture ? "dalam {$diffInHours} jam" : "{$diffInHours} jam yang lalu";
        } elseif ($diffInDays < 7) {
            return $isFuture ? "dalam {$diffInDays} hari" : "{$diffInDays} hari yang lalu";
        } elseif ($diffInWeeks < 4) {
            return $isFuture ? "dalam {$diffInWeeks} minggu" : "{$diffInWeeks} minggu yang lalu";
        } elseif ($diffInMonths < 12) {
            return $isFuture ? "dalam {$diffInMonths} bulan" : "{$diffInMonths} bulan yang lalu";
        } else {
            return $isFuture ? "dalam {$diffInYears} tahun" : "{$diffInYears} tahun yang lalu";
        }
    }

    /**
     * Get days remaining in Indonesian
     */
    public static function daysRemainingIndonesian($date)
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        $carbon = $carbon->setTimezone('Asia/Jakarta');
        $now = Carbon::now('Asia/Jakarta');
        
        // Use floor to get integer days and check if it's past or future
        if ($carbon->isPast()) {
            $diffInDays = floor($now->diffInDays($carbon));
            return $diffInDays . ' hari telah lewat';
        } elseif ($carbon->isToday()) {
            return 'hari ini';
        } elseif ($carbon->isTomorrow()) {
            return 'besok';
        } else {
            $diffInDays = floor($now->diffInDays($carbon));
            return $diffInDays . ' hari tersisa';
        }
    }
}
