<?php
/**
 * AlphaOne Building Consent System
 * Copyright Alpha77 Limited | Setak Holdings Limited 2013 - 2019
 * Generated in PhpStorm.
 * Developer: Camilo Lozano III - www.camilord.com
 * Username: AlphaDev1
 * Date: 26 Feb 2019
 * Time: 9:49 AM
 */

namespace camilord\utilus\IO;

/**
 * Class ConsoleUtilus
 * @package camilord\utilus\IO
 */
class ConsoleUtilus
{
    /**
     * show a status bar in the console
     *
     * <code>
     * for($x=1;$x<=100;$x++){
     *
     *     show_status($x, 100);
     *
     *     usleep(100000);
     *
     * }
     * </code>
     *
     * @param   int     $done   how many items are completed
     * @param   int     $total  how many items are to be done total
     * @param   int     $size   optional size of the status bar
     * @return  void
     *
     */
    public static function show_status($done, $total, $size=30) {

        static $start_time;

        // if we go over our bound, just ignore it
        if($done > $total) {
            echo "\n";
            return;
        }

        if(empty($start_time)) $start_time=time();
        $now = time();

        $perc=(double)($done/$total);

        $bar=floor($perc*$size);

        $status_bar="\r[";
        $status_bar.=str_repeat("=", $bar);
        if($bar<$size){
            $status_bar.=">";
            $status_bar.=str_repeat(" ", $size-$bar);
        } else {
            $status_bar.="=";
        }

        $disp=number_format($perc*100, 0);

        $status_bar.="] $disp%  $done/$total";

        $rate = ($now-$start_time)/$done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);

        $elapsed = $now - $start_time;

        $status_bar .= " remaining: ".number_format($eta)." sec. | elapsed: ".number_format($elapsed)." sec.                                                  ";

        echo "$status_bar  ";

        flush();

        // when done, send a newline
        if($done == $total) {
            echo "\n";
            unset($start_time);
        }

    }

    /**
     * @param $text
     * @param $done
     * @param $total
     * @param int $size
     */
    public static function show_status_label($text, $done, $total, $size=30) {

        static $start_time;
        static $pad_max = 0;

        // if we go over our bound, just ignore it
        if($done > $total) {
            echo "\n";
            return;
        }

        if ($pad_max < strlen($text)) {
            $pad_max = strlen($text);
        }

        if(empty($start_time)) $start_time=time();
        $now = time();

        $perc=(double)($done/$total);

        $bar=floor($perc*$size);

        $status_bar="\r[";
        $status_bar.=str_repeat("=", $bar);
        if($bar<$size){
            $status_bar.=">";
            $status_bar.=str_repeat(" ", $size-$bar);
        } else {
            $status_bar.="=";
        }

        $disp=number_format($perc*100, 0);

        $status_bar.="] $disp% $done/$total";

        $rate = ($now-$start_time)/$done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);

        $elapsed = $now - $start_time;

        $status_bar .= " remaining: ".number_format($eta)." sec. | elapsed: ".number_format($elapsed)." sec. | ".str_pad($text, $pad_max, ' ');

        echo "$status_bar  ";

        flush();

        // when done, send a newline
        if($done == $total) {
            echo "\n";
            unset($pad_max);
            unset($start_time);
        }

    }

    /**
     * @param string $cmd
     */
    public static function shell_exec($cmd) {
        while (@ob_end_flush()); // end all output buffers if any

        $proc = popen($cmd, 'r');
        while (!feof($proc))
        {
            echo fread($proc, 4096);
            @flush();
        }
    }
}