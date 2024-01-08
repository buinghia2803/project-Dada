<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Common Helper.
 *
 * @author
 */
class DateHelper
{
    /**
     * Convert date string to timestamp.
     *
     * @param string $dateTimeString
     * @param string $format
     * @param string $timezone
     *
     * @return int
     */
    public static function convertDateToTimestamp($dateTimeString, $format = 'Y/m/d H:i', $timezone = 'Asia/Tokyo')
    {
        try {
            return Carbon::createFromFormat($format, $dateTimeString)->setTimezone($timezone)->timestamp;
        } catch (\Exception $e) {
            Log::error('[DateHelper->convertDateToTimestamp:' . __LINE__ . '] ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Convert timestamp to datetime.
     *
     * @param int $timestamp
     * @param string $format
     * @param string $timezone
     *
     * @return string
     */
    public static function convertTimestampToDate($timestamp, $format = 'Y-m-d H:i', $timezone = 'Asia/Tokyo')
    {
        try {
            return Carbon::createFromTimestamp($timestamp, $timezone)->format($format);
        } catch (\Exception $e) {
            Log::error('[DateHelper->convertTimestampToDate:' . __LINE__ . '] ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get current date time with timezone and format.
     *
     * @param String $format
     * @param String $timezone
     *
     * @return Int|String|Object
     */
    public static function getNow($format = 'Y-m-d H:i', $timezone = 'Asia/Tokyo')
    {
        if ($format == 'timestamp') {
            return Carbon::now()->timezone($timezone)->timestamp;
        } elseif (!empty($format)) {
            return Carbon::now()->timezone($timezone)->format($format);
        } else {
            return Carbon::now()->timezone($timezone);
        }
    }
}
