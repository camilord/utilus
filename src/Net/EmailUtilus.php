<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:49 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Net;
use camilord\utilus\Data\ArrayUtilus;
use camilord\utilus\Security\Sanitizer;


/**
 * Class EmailUtilus
 * @package camilord\utilus\Net
 */
class EmailUtilus
{
    /**
     * @param $fullpath_filename
     * @param null $filename
     * @return bool
     */
    public static function is_email_signature_image($fullpath_filename, $filename = null) {
        if (is_null($filename)) {
            $filename = basename($fullpath_filename);
        } else {
            $filename = basename($filename);
        }
        if (file_exists($fullpath_filename)) {
            $fsize = filesize($fullpath_filename);
            if ($fsize < 102400 && preg_match("/^image[0-9]{1,6}\\.(jpg|jpe|jpeg|gif|png|bmp)/i", $filename)) {
                return true;
            }

            //ab50-4bc5-86f2-313647393804_OutlookEmoji1478930651561_Logo30b94f3cc3694820bd5baa298459f961.jpg.pdf
            if ($fsize < 102400 && preg_match("/[a-z0-9\\-_]*OutlookEmoji[0-9]{10,15}_[a-z0-9\\-_]+\\.(jpg|jpe|jpeg|gif|png|bmp)/i", $filename)) {
                return true;
            }
        }
        return false;
    }

    public static function email_cleaner_html($txt) {
        $txt = strip_tags($txt, '<b><strong><p><a><ul><li><br><i>');
        //return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $txt);
        return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $txt);
    }

    public function email_body_cleaner($str) {
        $str = preg_replace('/(?:(?:\r\n|\r|\n)\s*){3}/s', "\n\n", $str);
        $str = preg_replace("/[ \t]+/", " ", $str);
        $str = preg_replace("/[ ]+/", " ", $str);
        return $str;
    }

    public function extract_emails_from($string) {
        preg_match_all("/[\\._a-zA-Z0-9-]+@[\\._a-zA-Z0-9-]+/i", $string, $matches);
        return $matches[0];
    }

    public function is_bounced_email($header) {
        return (preg_match("/(mailer\\-daemon|daemon)/", strtolower($header))) ? TRUE : FALSE;
    }

    public function is_auto_reply($headers)
    {
        $header_array = [];
        $data = explode("\r\n", $headers);
        if (ArrayUtilus::haveData($data)) {
            foreach($data as $item) {
                $tmp = explode(": ", $item);
                $append = false;

                $orig_key = @$tmp[0];
                $key = Sanitizer::text_cleaner($orig_key, false);
                $value = trim(@$tmp[1]);

                if (
                    isset($prev_key) && strlen($prev_key) > 0 &&
                    isset($prev_value) && strlen($prev_value) > 0 &&
                    $value == ''
                ) {
                    $key = $prev_key;
                    $value = $prev_value . "\r\n" . $orig_key;
                    $append = true;
                }
                $header_array[strtolower($key)] = $value;

                if ($append === false) {
                    $prev_key = $key;
                    $prev_value = $value;
                } else {
                    $prev_value = $value;
                }
            }
        }

        /**
         * validate difference variation of auto responder headers
         */
        if (
            !filter_var(Sanitizer::email_cleaner(@$header_array['return-path']), FILTER_VALIDATE_EMAIL) &&
            preg_match("/(auto.*reply)/i", @$header_array['subject'])
        ) {
            return true;
        } else if (isset($header_array['x-autoreply']) && strtolower($header_array['x-autoreply']) == 'yes') {
            return true;
        } else if (isset($header_array['x-auto-response-suppress'])) {
            return true;
        } else if (isset($header_array['auto-submitted']) && strtolower($header_array['auto-submitted']) == 'auto-generated') {
            return true;
        }

        /**
         * raw check...
         * the sample data in txt file have issues running on linux environment, i think its the charset settings
         * windows works well and only done checking on above statements
         * while in linux, i have to check the raw headers and use preg_match
         */
        if (preg_match("/x-autoreply: yes/i", $headers)) {
            return true;
        } else if (preg_match("/auto-submitted: auto-generated/i", $headers)) {
            return true;
        } else if (preg_match("/x-auto-response-suppress/i", $headers)) {
            return true;
        }

        return false;
    }

    public static function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}