<?php

class Filestore {

    public $filename = '';

    public function __construct($filename = '') 
    {
        if (!empty($filename)) {
            $this->filename = $filename; 
        }

    }

    /**
     * Returns array of lines in $this->filename
     */
    public function save_file()

    public function read_lines($return_array = FALSE)
    {
        $handle = fopen($this->filename, "r");
        $contents = fread($handle, filesize($this->filename));
        fclose($handle);
        return explode("\n", $contents);
    }else {
        return $contents;
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    function write_lines($contents)
    {
        if (is_array($contents)) {
            $contents = implode("\n", $ontents);
        }
        $handle = fopen($this->filename, 'w');
        $saveList = implode("\n", $array);
        fwrite($handle, $saveList);
        fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    function read_csv()
    {
        $handle = fopen($this->filename, 'r');
        $filesize = filesize($this->filename);
        $openList = [];
        if($filesize != 0) {
            while(!feof($handle)) {
                $openList[] = fgetcsv($handle);
            }   
        }else {
            $openList = array();
        }
        fclose($handle);
        return $openList;
        }
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    function write_csv($array)
    {
        $handle = fopen($this->filename, "w");
        foreach ($address_array as $fields) 
        {
            if ($fields != "") 
            {
            fputcsv($handle, $fields);
            }
        }
        fclose($handle);
    }
    

}