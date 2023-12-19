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

/**
 * Class StringUtilus
 * @package camilord\utilus\String
 */
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
    public static function substring($text, $length, $appendix = '...'): string
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

    /**
     * @param string $string
     * @param int $limit
     * @return string
     */
    public static function truncate_middle(string $string, int $limit = 50): string
    {
        if ($limit <= 5) {
            $limit = 5;
        }

        if (strlen($string) >= $limit)
        {
            $total = strlen($string);
            $half = floor($total / 2);
            return substr($string, 0, $half) . '...' . substr($string, ($half * -1));
        }

        return $string;
    }

    /**
     * @param string $path1
     * @param string $path2
     * @return string
     */
    public static function mergeString($path1, $path2): string
    {
        $merged_path = $path1 . substr($path2, strpos($path2, basename($path1)) + strlen(basename($path1)));
        return $merged_path;
    }

    /**
     * @param string $notes
     * @return string
     */
    public static function truncate_long_words($notes): string
    {
        $tmp = explode(" ", $notes);

        for ($j = 0; $j < count($tmp); $j++) {
            if (strlen($tmp[$j]) > 45) {
                $tmp[$j] = '<abbr title="'.strip_tags($tmp[$j]).'">'.substr($tmp[$j],0,45).'...</abbr>';
            }
        }
        $notes = implode(" ",$tmp);

        return $notes;
    }

    /**
     * @param string $txt
     * @return string
     */
    public static function adv_ucwords(string $txt): string
    {
        $alphabet = 'qwertyuiopasdfghjklzxcvbnm';
        $aArray = array();
        $rArray = array();
        for ($i = 0; $i < strlen($alphabet); $i++) {
            $aArray[] = '"'.$alphabet[$i];
            $rArray[] = strtoupper('"'.$alphabet[$i]);
        }
        return ucwords(str_replace($aArray, $rArray, $txt));
    }

    /**
     * generate random string with specified length
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function generate(int $length = 32): string
    {
        $str = "";
        $refSource = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $refSource.= "abcdefghijklmnopqrstuvwxyz";
        $refSource.= "0123456789";

        for ($i = 0; $i < $length; $i++)
        {
            $str .= $refSource[random_int(0, (strlen($refSource) - 1))];
        }

        return $str;
    }

    /**
     * generate random string + special chars with specified length
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function specialize(int $length = 32): string
    {
        $str = "";
        $refSource = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $refSource .= "abcdefghijklmnopqrstuvwxyz";
        $refSource .= "0123456789";
        $refSource .= "~!@#$%^&*(){}|:<>?,./;[]";

        for ($i = 0; $i < $length; $i++)
        {
            $str .= $refSource[random_int(0, (strlen($refSource) - 1))];
        }

        return $str;
    }

    /**
     * generate random string + special chars with specified length
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    function generateRandomString(int $length = 12): string 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }
}
