<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 1/04/2019
 * Time: 10:11 PM
 * ----------------------------------------------------
 */

namespace IO;

use camilord\utilus\Data\ArrayUtilus;
use camilord\utilus\IO\ConsoleUtilus;
use camilord\utilus\IO\FileUtilus;

/**
 * Class FileReader
 * @package IO
 */
class FileReader
{
    private $delimeter;
    private $source_file;
    private $display_progress = false;

    public function __construct($source_file, $line_delimeter = '^[0-9]{3,6}')
    {
        $this->source_file = $source_file;
        $this->delimeter = $line_delimeter;
    }

    /**
     * @return bool
     */
    public function isDisplayProgress()
    {
        return $this->display_progress;
    }

    /**
     * @param bool $display_progress
     */
    public function setDisplayProgress($display_progress)
    {
        $this->display_progress = $display_progress;
    }

    /**
     * @return array
     */
    public function getLineData()
    {
        $content_data = [];
        if (file_exists($this->source_file))
        {
            try {
                $max_size = FileUtilus::filesize64($this->source_file);
            } catch (\Exception $e) {
                $max_size = filesize($this->source_file);
            }

            $handle = fopen($this->source_file, "rb") or die("Error! Couldn't get handle...");
            $filename = basename($this->source_file);

            $cache_count = 0;
            $ctr = -1;


            while (!feof($handle)) {

                // fgets reads one line at a time
                $line = fgets($handle);

                if ($this->isDisplayProgress()) {
                    $cache_count += strlen($line);
                    ConsoleUtilus::show_status_label($filename, $cache_count, $max_size);
                }

                if (strlen(trim($line)) == 0) {
                    continue;
                }

                $regex_expression = "/{$this->delimeter}/";

                // skip header
                if ($ctr < 0) {
                    $ctr++;
                    $content_data[$ctr] = $this->clean($line);
                    continue;
                } else if (preg_match($regex_expression, $line)) {
                    $ctr++;
                    $content_data[$ctr] = $this->clean($line);
                } else {
                    $content_data[$ctr] .= $this->clean($line);
                }

                unset($line);
            }
            fclose($handle);
        }

        return $content_data;
    }

    /**
     * @return array
     */
    public function getAssociativeData() {
        $data = $this->getLineData();
        $associative_data = [];
        $headers = null;

        foreach($data as $line)
        {
            $csv_line = str_getcsv(trim($line));

            if (is_null($headers)) {
                $headers = $csv_line;
                continue;
            }

            $associative_data[] = ArrayUtilus::convertAssociativeArray($headers, $csv_line);
        }

        return $associative_data;
    }

    private function clean($str) {
        return str_replace(["\r", "\n"], '', $str);
    }
}