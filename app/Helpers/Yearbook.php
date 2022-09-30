<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;


class Yearbook {
    public static function bytesToHuman($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public static function displayElapsedTime($date) {
        return sprintf('%s %s %s',
            self::formatDateInterval('%Y', 'year', $date),
            self::formatDateInterval('%m', 'month', $date),
            self::formatDateInterval('%d', 'day', $date)
//            self::formatDateInterval('%h', 'hour', $date),
//            self::formatDateInterval('%i', 'minute', $date),
//            self::formatDateInterval('%s', 'second', $date)
        );
    }

    protected static function formatDateInterval($format, $interval, $date) {
        $count = $date->diff(new \DateTime)->format($format);
        return sprintf('%s %s', $count, Str::plural($interval, $count));
    }

    public static $states = [
        'AL'=>"Alabama",
        'AK'=>"Alaska",
        'AZ'=>"Arizona",
        'AR'=>"Arkansas",
        'CA'=>"California",
        'CO'=>"Colorado",
        'CT'=>"Connecticut",
        'DE'=>"Delaware",
        'DC'=>"District  Of Columbia",
        'FL'=>"Florida",
        'GA'=>"Georgia",
        'HI'=>"Hawaii",
        'ID'=>"Idaho",
        'IL'=>"Illinois",
        'IN'=>"Indiana",
        'IA'=>"Iowa",
        'KS'=>"Kansas",
        'KY'=>"Kentucky",
        'LA'=>"Louisiana",
        'ME'=>"Maine",
        'MD'=>"Maryland",
        'MA'=>"Massachusetts",
        'MI'=>"Michigan",
        'MN'=>"Minnesota",
        'MT'=>"Montana",
        'NE'=>"Nebraska",
        'NV'=>"Nevada",
        'NH'=>"New  Hampshire",
        'NJ'=>"New Jersey",
        'NM'=>"New Mexico",
        'NY'=>"New  York",
        'NC'=>"North Carolina",
        'ND'=>"North Dakota",
        'OH'=>"Ohio",
        'OK'=>"Oklahoma",
        'OR'=>"Oregon",
        'PA'=>"Pennsylvania",
        'RI'=>"Rhode  Island",
        'SC'=>"South Carolina",
        'SD'=>"South Dakota",
        'TN'=>"Tennessee",
        'TX'=>"Texas",
        'UT'=>"Utah",
        'VT'=>"Vermont",
        'VA'=>"Virginia",
        'WA'=>"Washington",
        'WV'=>"West  Virginia",
        'WI'=>"Wisconsin",
        'WY'=>"Wyoming"
    ];
    public static $grades = ['Pre-Kindergarten','Kindergarten','1','2','3','4','5','6','7','8','9','10','11','12'];

    public static $gradesFilter = [
        'PK-5',
	    'PK-8',
	    'PK-12',
	    '6-8',
	    '6-12',
	    '9-12'
    ];
}
