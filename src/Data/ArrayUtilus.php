<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:40 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Data;

/**
 * Class ArrayUtilus
 * @package camilord\utilus\Data
 */
class ArrayUtilus
{
    /**
     * @param $array_data array
     * @return bool
     */
    public static function haveData($array_data) {
        return (is_array($array_data) && count($array_data) > 0);
    }

    /**
     * @param $data array
     * @return array
     */
    public static function removeArrayNumericKeys($data)
    {
        if (self::haveData($data))
        {
            foreach ($data as $key => $item)
            {
                if (is_numeric($key))
                {
                    unset($data[$key]);
                }
            }
        }

        return $data;
    }

    /**
     * @param $array_data
     * @return array|mixed|string
     */
    public static function cleanse($array_data) {
        if (is_array($array_data)) {
            foreach ($array_data as $i => $array_item) {
                $array_data[$i] = ArrayUtilus::cleanse($array_item);
            }
        } else if (is_object($array_data) || is_null($array_data)) {
            // do nothing...
        } else {
            $array_data = ArrayUtilus::cleanse_string($array_data);
        }

        return $array_data;
    }

    /**
     * @param array $array
     * @param string $colon
     * @return array
     * @description this will remove redundant array base on parameter colon set
     */
    public static function filter_array($array, $colon = '')
    {
        $ret_array = array();
        $has_array = array();
        foreach($array as $item)
        {
            $item_array = (array)$item;
            if(!in_array($item_array[$colon], $has_array))
            {
                array_push($ret_array, $item);
                array_push($has_array, $item_array[$colon]);
            }
        }
        return $ret_array;
    }

    /**
     * Original Code: https://gist.github.com/gcoop/701814
     * @param $string
     * @param array $allowedTags
     * @return mixed|string
     */
    public static function cleanse_string($string, $allowedTags = array('<br>','<b>','<i>','<p>','<span>','<strong>'))
    {
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }

        $string = strip_tags($string, implode('', $allowedTags));

        // ============
        // Remove MS Word Special Characters
        // ============

        $search  = array('&acirc;€“','&acirc;€œ','&acirc;€˜','&acirc;€™','&Acirc;&pound;','&Acirc;&not;','&acirc;„&cent;');
        $replace = array('-','&ldquo;','&lsquo;','&rsquo;','&pound;','&not;','&#8482;');

        $string = str_replace($search, $replace, $string);
        $string = str_replace('&acirc;€', '&rdquo;', $string);

        $search = array("&#39;", "\xc3\xa2\xc2\x80\xc2\x99", "\xc3\xa2\xc2\x80\xc2\x93", "\xc3\xa2\xc2\x80\xc2\x9d", "\xc3\xa2\x3f\x3f");
        $replace = array("'", "'", ' - ', '"', "'");

        $string = str_replace($search, $replace, $string);

        $quotes = array(
            "\xC2\xAB"     => '"',
            "\xC2\xBB"     => '"',
            "\xE2\x80\x98" => "'",
            "\xE2\x80\x99" => "'",
            "\xE2\x80\x9A" => "'",
            "\xE2\x80\x9B" => "'",
            "\xE2\x80\x9C" => '"',
            "\xE2\x80\x9D" => '"',
            "\xE2\x80\x9E" => '"',
            "\xE2\x80\x9F" => '"',
            "\xE2\x80\xB9" => "'",
            "\xE2\x80\xBA" => "'",
            "\xe2\x80\x93" => "-",
            "\xc2\xb0"	   => "°",
            "\xc2\xba"     => "°",
            "\xc3\xb1"	   => "&#241;",
            "\x96"		   => "&#241;",
            "\xe2\x81\x83" => '&bull;'
        );
        $string = strtr($string, $quotes);

        // ============
        // END
        // ============

        return $string;
    }
}