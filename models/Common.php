<?php

namespace app\models;
use Yii;

class Common
{

    const STATUS_INACTIVE = '0';
    const STATUS_ACTIVE = '1';
    const STATUS_DELETED = '2';
    

    public function __construct()
    {
        //
    }

    public static function getStatusArray()
    {
        return ['1' => 'Active', '0' => 'Inactive'];
    }

    public static function getIpAddress()
    {
        $ipaddress = "";
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != "") {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && trim(getenv('HTTP_X_FORWARDED_FOR')) != "") {
            $ipaddress = getenv('HTTP_X_FORWARD_FOR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipaddress;
    }

    public static function getTimeStamp($date = "", $format = "Y-m-d")
    {
        if ($date != "" && !is_numeric($date)) {
            $date = str_replace("-", DIRECTORY_SEPARATOR, $date);
            if (strpos($date, "am") != "" || strpos($date, "pm") != "") {
                $date = str_replace("am", "", $date);
                $date = str_replace("pm", "", $date);
            }
            @list($day, $month, $year) = explode(DIRECTORY_SEPARATOR, $date);
            $date = @$day . DIRECTORY_SEPARATOR . @$month . DIRECTORY_SEPARATOR . @$year;
            $date = str_replace('/', '-', $date);
            return strtotime("$date");
        } else {
            return strtotime(date($format));
        }
    }
}
