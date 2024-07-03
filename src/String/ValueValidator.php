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

/**
 * Class ValueValidator
 * @package camilord\utilus\String
 */
class ValueValidator
{
    /**
     * @param mixed $var
     * @return bool
     */
    static function is_value_true($var) {
        if (!is_null($var) && in_array(strtolower($var), array('y','yes','true','1'))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $date_value
     * @param string $date_format
     * @return bool
     */
    static function is_date_valid($date_value, $date_format = 'Y-m-d')
    {
        $original_date_value = $date_value;
        if (stripos($date_value, '/') !== false) {
            $date_value = str_replace('/', '-', $date_value);
        }
        
        $epoch_time = strtotime($date_value);
        if (date($date_format, $epoch_time) == $original_date_value) {
            return true;
        }
        return false;
    }
}
