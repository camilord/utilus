<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:44 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Net;

/**
 * Class MobileNumberValidator
 * @package camilord\utilus\Net
 */
class MobileNumberValidator
{
    public static function verify_nz_mobile($peoplemobile) {

        $final_ok = "";
        $mobile['verification'] = "FAILED";

        //strip spaces and special characters
        $peoplemobile1 = str_replace(" ", "",$peoplemobile);
        $peoplemobile1 = str_replace("+", "",$peoplemobile1);
        $peoplemobile1 = str_replace("(0)", "",$peoplemobile1);
        $peoplemobile1 = str_replace("-", "",$peoplemobile1);
        $peoplemobile1 = str_replace("?", "",$peoplemobile1);

        $mobile_no_2 = substr("$peoplemobile1",0,2); // only testing for 04
        $mobile_no_3 = substr("$peoplemobile1",0,1); // only testing for first 4

        if($mobile_no_2 == "02")
        {
            $add_plus = "=".$peoplemobile1;
            $peoplemobile1 = str_replace("=02", "642",$add_plus);
        }

        $mobile_no = substr("$peoplemobile1",0,3);
        $verify_mobile_length = strlen("$peoplemobile1");// 11 digits after 00

        if ( ($mobile_no == 642) && ($verify_mobile_length >= 8 ) ) {
            $peoplemobile1 = "00".$peoplemobile1;
            $final_ok = "OK";
        }

        if ($mobile_no_2 == "00") {
            $mobile_no = substr("$peoplemobile1",0,5);
            $verify_mobile_length = strlen("$peoplemobile1");// 13 digits from begining

            if($verify_mobile_length >= 12 && $mobile_no == "00642")
            {
                $final_ok = "OK";
            }
        }


        if($mobile_no_3 == "2")
        {
            $verify_mobile_length = strlen("$peoplemobile1");// 9 digits from begining
            if($verify_mobile_length >= 9) {
                $peoplemobile1 = "0064".$peoplemobile1;
                $final_ok = "OK";
            }
        }


        if ($final_ok == "OK") {
            $mobile['mobile_no'] = $peoplemobile1;
            $mobile['verification'] = "PASSED";
        }

        return $mobile;
    }
}