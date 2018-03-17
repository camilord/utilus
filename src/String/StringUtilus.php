<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:03 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\String;


class StringUtilus
{
    /**
     * Shorten a string and add ... if more than specified length
     *
     * @param $text
     * @param $length
     * @param string $appendix
     * @return string
     */
    public static function substring($text, $length, $appendix = '...')
    {
        if (strlen($text) > $length)
        {
            return substr($text, 0, $length).$appendix;
        }
        else
        {
            return $text;
        }
    }

    public static function truncate_middle($string, $limit = 50) {
        if ($limit >= 50 && strlen($string) >= $limit) {
            $total = strlen($string);
            return substr($string, 0, ($total / 8)) . '...' . substr($string, ($total - ($total / 2)), $total);
        }

        return $string;
    }

    public static function mergeString($path1, $path2) {
        $merged_path = $path1 . substr($path2, strpos($path2, basename($path1)) + strlen(basename($path1)));
        return $merged_path;
    }

    public static function truncate_long_words($notes) {

        $tmp = explode(" ", $notes);

        for ($j = 0; $j < count($tmp); $j++) {
            if (strlen($tmp[$j]) > 45) {
                $tmp[$j] = '<abbr title="'.strip_tags($tmp[$j]).'">'.substr($tmp[$j],0,45).'...</abbr>';
            }
        }
        $notes = implode(" ",$tmp);

        return $notes;
    }

    public static function adv_ucwords($txt) {
        $alphabet = 'qwertyuiopasdfghjklzxcvbnm';
        $aArray = array();
        $rArray = array();
        for ($i = 0; $i < strlen($alphabet); $i++) {
            $aArray[] = '"'.$alphabet[$i];
            $rArray[] = strtoupper('"'.$alphabet[$i]);
        }
        return str_replace($aArray, $rArray, $txt);
    }
}