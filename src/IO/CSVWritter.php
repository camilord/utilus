<?php

namespace camilord\utilus\IO;

use camilord\utilus\Data\ArrayUtilus;

/**
 * Summary of CSVWritter
 */
class CSVWritter
{
    private $filename;

    /**
     * Summary of __construct
     * @param string $filename
     */
    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    /**
     * Summary of write
     * @param array $data
     * @return bool
     */
    public function write(array $data) 
    {
        if (!ArrayUtilus::is_multidimensional_array($data)) {
            $data = [ $data ];
        }

        $out = fopen($this->filename, 'a');

        foreach($data as $item) 
        {
            fputcsv($out, $item);
        }

        return fclose($out);
    }
}