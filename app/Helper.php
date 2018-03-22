<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    public static function dateCount($dataHired)
    {
        $from = strtotime($dataHired);
        $today = time();
        $difference = $today - $from;
        $years = floor($difference / 86400) / 365;
        $total = floor($years) + 6 - 1;

        if ($total > 10) {
            return '10';
        } elseif ($total < 6) {
            return '6';
        } else {
            return $total;
        }
    }

    public static function tenured($dateHired)
    {
        $from = strtotime($dateHired);
        $today = time();
        $difference = $today - $from;
        $years = floor($difference / 86400) / 365;
        $total = floor($years);

        return $total;
    }
}
