<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:16 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Security;


class Sanitizer
{
    public static function real_escape_string($value) {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }

    public static function login_cleaner($text = '') {
        return preg_replace( '/[^a-zA-Z0-9._]/', '', $text);
    }

    public static function email_cleaner($text = '') {
        return preg_replace( '/[^a-zA-Z0-9._\-@]/', '', $text);
    }

    public static function slugger($text = '', $withSpace = false) {
        return ($withSpace) ?
            preg_replace( '/[^a-zA-Z0-9._\- ]/', '', $text) :
            preg_replace( '/[^a-zA-Z0-9._\-]/', '', $text);
    }

    public static function numeric_cleaner($text = '', $negativity = false) {
        return ($negativity) ?
            preg_replace( '/[^(\-)0-9.]/', '', $text) :
            preg_replace( '/[^0-9.]/', '', $text);
    }

    public static function alpha_cleaner($text = '', $withSpace = false) {
        return ($withSpace) ?
            preg_replace('/[^a-zA-Z ]/', '', $text) :
            preg_replace('/[^a-zA-Z]/', '', $text);
    }

    public static function text_cleaner($text = '', $withSpace = true) {
        return ($withSpace) ?
            preg_replace( '/[^a-zA-Z0-9._\-: ]/', '', $text) :
            preg_replace( '/[^a-zA-Z0-9._\-:]/', '', $text);
    }

    public static function whitespaces($txt) {
        return preg_replace('/\s\s+/', ' ', $txt);
    }

    public static function alphanumeric_cleaner($text) {
        return preg_replace( '/[^a-zA-Z0-9]/', '', $text);
    }

    public static function stringFilter($text) {
        return preg_replace('/[^a-zA-Z0-9._\-:()&%$#*@ ]/', '', $text);
//        return filter_var($text, FILTER_SANITIZE_STRING);
    }

    public static function floatFilter($float) {
        return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT);
    }
    /**
     * @param $txt - input text
     * @param bool $remove_redundant_spaces - set to true if you want to delete redundant white spaces
     *                                      - set to false if you want to maintain the spaces after stripping special characters
     * @return mixed|string
     */
    public static function text_normalizer($txt, $remove_redundant_spaces = true) {
        $txt = str_replace("`", "'", $txt);
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $txt = strtr( $txt, $unwanted_array );
        if (function_exists('iconv')) {
            $txt = iconv('utf-8', 'ascii//TRANSLIT', $txt);
            $txt = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $txt);
        }
        if ($remove_redundant_spaces) {
            $txt = Sanitizer::whitespaces($txt);
        }
        return $txt;
    }
}