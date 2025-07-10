<?php

namespace camilord\utilus\IO;

/**
 * Summary of IsolatedEnv
 */
class IsolatedEnv
{
    /**
     * Summary of data
     * @var array
     */
    private array $data = [];

    private string $env_file_path;

    /**
     * Summary of __construct
     * @param string $env_file_path
     */
    public function __construct(string $env_file_path) {
        $this->env_file_path = $env_file_path;
        $this->load();
    }

    /**
     * Summary of load
     * @return bool
     */
    private function load() 
    {
        if (!file_exists($this->env_file_path)) {
            return false;
        }

        $env = file_get_contents($this->env_file_path);
        $lines = explode("\n",$env);

        foreach($lines as $line)
        {
            preg_match("/([^#]+)\=(.*)/", $line, $matches);
            if (isset($matches[2]) && !preg_match("/^#.*/", $line)) 
            { 
                list($field, $value) = explode('=', $line);
                $field = trim($field);
                $value = trim($value);

                $this->data[$field] = $value;
            }
        } 
    }

    /**
     * Summary of get
     * @param string $name
     * @param mixed $default
     */
    public function get(string $name, $default = null) 
    {
        return $this->data[$name] ?? $default;
    }
}