<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:05 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Numeric;

/**
 * Class NumericUtilus
 * @package camilord\utilus\Numeric
 */
class NumericUtilus
{

    /**
     * @param mixed $val
     * @param int $lead_count
     * @return string
     */
    public static function leading_zeroes($val, $lead_count = 6)
    {
        $format = '%0'.$lead_count.'d';
        return sprintf($format, $val);
    }

    /**
     * Returns clean number, no comma no trailing zero, e.g.: '1000.77' instead of '1,000.7700'
     *
     * @return string
     */
    public static function getCleanNumber($val)
    {
        $num = preg_replace("/[^0-9.]/", '', $val);
        //remove zeros from end of number ie. 140.00000 becomes 140.
        if (stripos($num, '.') !== FALSE) $num = rtrim($num, '0');
        //remove decimal point if an integer ie. 140. becomes 140
        $num = rtrim($num, '.');

        /**
         * if too many decimals, remove it...
         */
        if (preg_match("/\\./", $num)) {
            $tmp = explode('.', $num);
            $num = $tmp[0].'.'.(int)@$tmp[1];
        }

        /**
         * if leading zero, then remove the zeroes...
         */
        while (substr($num, 0, 1) == '0') {
            $num = substr($num, 1, strlen($num));
        }

        return $num;
    }

    /**
     * Returns clean number with at least .00 precision, e.g. '1000.00' instead of '1000'
     *
     * @return string
     */
    public static function getCleanNumberCurrency($val)
    {
        $num = self::getCleanNumber($val);

        // does it have a .
        if (!stripos($num, '.'))
        {
            return $num.'.00';
        }
        // it does have a . but how many digits?
        else
        {
            $decimals = strlen(substr(strrchr($num, "."), 1));
            if ($decimals === 1) {
                $num .= '0';
            }

            return $num;
        }
    }
}