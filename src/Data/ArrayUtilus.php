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

use Exception;

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
     * @param $headers
     * @param $data
     * @return array
     */
    public static function convertAssociativeArray($headers, $data) {
        $final_data = [];
        foreach($headers as $i => $field) {
            if ($field == '') {
                continue;
            }
            if (strtolower($data[$i] ?? 'null') === 'null') {
                $data[$i] = null;
            }
            $final_data[$field] = $data[$i] ?? null;
        }
        return $final_data;
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
            return $array_data;
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

    /**
     * Summary of flatten_array
     * @param mixed $data
     * @param mixed $prefix
     */
    public static function flatten_array($data, $prefix = null) 
    {
        $new_data = [];
        foreach($data as $key => $item) 
        {
            if (ArrayUtilus::haveData($item)) {
                $sub_data = self::flatten_array(
                    $item, (is_null($prefix) ? '' : $prefix.'_').$key
                );
                $new_data[] = $sub_data;
                unset($data[$key]);
            } else if ($prefix) {
                $data[$prefix.'_'.$key] = $item;
                unset($data[$key]);
            }
        }

        if (ArrayUtilus::haveData($new_data)) {
            foreach($new_data as $item) {
                $data = array_merge($data, $item);
            }
        }

        return $data;
    }

    /**
     * Summary of isMultiDimensionalArray
     * @param array $data
     * @return bool
     */
    public static function is_multidimensional_array(array $data) 
    {
        $rv = array_filter($data, 'is_array'); 

        if (count($rv) > 0) {
            return true; 
        }

        return false;
    }

    /**
     * Summary of reset_keys
     * @param array $data
     * @return array
     */
    public static function reset_keys(array $data): array 
    {
        $data = array_values(array_filter($data));
        return $data;
    }

    /**
     * Summary of aws_sqs_array_chunk
     * @param array $data
     * @param bool $skip_large_chunks
     * @throws Exception
     * @return array<array>
     * 
     * To Address: 
     *  "aws_code": "InvalidParameterValueException",
     *  "aws_message": "One or more parameters are invalid. Reason: Message must be shorter than 262144 bytes."
     */
    public static function aws_sqs_array_chunk(array $data, bool $skip_large_chunks = false, int $overhead = 25600) 
    {
        $limit = 262144 - $overhead; // 256Kb minus 25Kb for overhead
        // $limit = 262144; // 256Kb without overhead -- without overhead still fails
        // $limit = 204800; // 200Kb

        $grouped_data = [];
        $chunks = [];
        
        foreach($data as $i => $chunk) 
        {
            $this_chunk_size = strlen(json_encode($chunk));

            if ($this_chunk_size > $limit) 
            {
                if ($skip_large_chunks) {
                    error_log("[{$i}] Chunk size ({$this_chunk_size}) exceeds limit of {$limit} bytes. Skipping large chunk.");
                    continue; // skip large chunks
                } else {
                    throw new Exception('Chunk size exceeds limit of '.$limit.' bytes. Multi-dimensional arrays with large data is not supported.');
                }
            }

            $chunks_size = strlen(json_encode($chunks));

            if (($chunks_size + $this_chunk_size) < $limit) 
            {
                $chunks[] = $chunk;
            } 
            else 
            {
                $grouped_data[] = $chunks;

                // reset to zero chunks
                $chunks = [];
                $chunks[] = $chunk;
            }
        }

        // add remaining chunks
        if (ArrayUtilus::haveData($chunks)) 
        {
            $grouped_data[] = $chunks;
        }

        return $grouped_data;
    }
}
