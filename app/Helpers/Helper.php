<?php


namespace App\Helpers;


class Helper
{
    public static function makeTimeStampReadable($timestamp)
    {
        return date('M d, Y @ H:i a', strtotime($timestamp));
    }


    public function makeDateReadable($date)
    {
        return date('M d, Y', strtotime($date));
    }
}
