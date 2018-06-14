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

/**
 * Class Sanitizer
 * @package camilord\utilus\Security
 */
class Sanitizer
{
    /**
     * @param string $value
     * @return mixed|string
     */
    public static function real_escape_string($value) {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }

    /**
     * @param string $text
     * @return null|string|string[]
     */
    public static function login_cleaner($text = '') {
        return preg_replace( '/[^a-zA-Z0-9._]/', '', $text);
    }

    /**
     * @param string $text
     * @return null|string|string[]
     */
    public static function email_cleaner($text = '') {
        return preg_replace( '/[^a-zA-Z0-9._\-@]/', '', $text);
    }

    /**
     * @param string $text
     * @param bool $withSpace
     * @return null|string|string[]
     */
    public static function slugger($text = '', $withSpace = false) {
        return ($withSpace) ?
            preg_replace( '/[^a-zA-Z0-9._\- ]/', '', $text) :
            preg_replace( '/[^a-zA-Z0-9._\-]/', '', $text);
    }

    /**
     * @param string $text
     * @param bool $negativity
     * @return null|string|string[]
     */
    public static function numeric_cleaner($text = '', $negativity = false) {
        return ($negativity) ?
            preg_replace( '/[^(\-)0-9.]/', '', $text) :
            preg_replace( '/[^0-9.]/', '', $text);
    }

    /**
     * @param string $text
     * @param bool $withSpace
     * @return null|string|string[]
     */
    public static function alpha_cleaner($text = '', $withSpace = false) {
        return ($withSpace) ?
            preg_replace('/[^a-zA-Z ]/', '', $text) :
            preg_replace('/[^a-zA-Z]/', '', $text);
    }

    /**
     * @param string $text
     * @param bool $withSpace
     * @return null|string|string[]
     */
    public static function text_cleaner($text = '', $withSpace = true) {
        return ($withSpace) ?
            preg_replace( '/[^a-zA-Z0-9._\-: ]/', '', $text) :
            preg_replace( '/[^a-zA-Z0-9._\-:]/', '', $text);
    }

    /**
     * Imported from Zekurity before it was removed
     * @param string $text
     * @return null|string|string[]
     */
    static public function filename_cleaner($text) {
        return preg_replace( '/[^a-zA-Z0-9._\-]/', '', $text);
    }

    /**
     * @param string $txt
     * @return null|string|string[]
     */
    public static function whitespaces($txt) {
        return preg_replace('/\s\s+/', ' ', $txt);
    }

    /**
     * @param string $text
     * @return null|string|string[]
     */
    public static function alphanumeric_cleaner($text) {
        return preg_replace( '/[^a-zA-Z0-9]/', '', $text);
    }

    /**
     * @param string $text
     * @return null|string|string[]
     */
    public static function stringFilter($text) {
        return preg_replace('/[^a-zA-Z0-9._\-:()&%$#*@ ]/', '', $text);
    }

    /**
     * @param float|string $float
     * @return mixed
     */
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

    public static function xss_clean($data, $encoding = 'UTF-8') {

        if (is_array($data)) {
            foreach($data as $key => $val) {
                $data[$key] = self::xss_clean($val, $encoding);
            }
            return $data;
        }

        // Fix &entity\n;
        //$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // remove style
        $data = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $data);

        // remove obvious injection
        $data = preg_replace('/javascript:[a-zA-Z0-9_ ]+\\(/i', '', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        $data = strip_tags($data, '<b><br><ul><li><ol><span>');

        // more complex patterns
        $patterns = array(
            // Match any attribute starting with "on" or xmlns
            '#(<[^>]+[\x00-\x20\"\'\/])(on|xmlns)[^>]*>?#iUu',
            // Match javascript:, livescript:, vbscript: and mocha: protocols
            '!((java|live|vb)script|mocha|feed|data):(\w)*!iUu',
            '#-moz-binding[\x00-\x20]*:#u',
            // Match style attributes
            '#(<[^>]+[\x00-\x20\"\'\/])style=[^>]*>?#iUu',
            // Match unneeded tags
            '#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i'
        );
        foreach($patterns as $regex) {
            $data = preg_replace($regex, '', $data);
        }

        /**
         * https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet#Code_Injection
         */
        $data = htmlspecialchars($data,ENT_QUOTES | ENT_HTML401, $encoding);

        // restore it..
        $data = str_replace('&amp;', '&', $data);

        return $data;
    }
}