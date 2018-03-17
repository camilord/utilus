<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:14 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\String;


class ValueValidator
{
    static function is_value_true($var) {
        if (!is_null($var) && in_array(strtolower($var), array('y','yes','true','1'))) {
            return true;
        } else {
            return false;
        }
    }

    static function is_date_valid($date_value, $date_format = 'Y-m-d')
    {
        $epoch_time = strtotime($date_value);
        if (date($date_format, $epoch_time) == $date_value) {
            return true;
        }
        return false;
    }
}