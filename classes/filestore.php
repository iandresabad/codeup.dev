<?php

class Filestore {

    private $filename = '';

    private $errorMessage = "";

    private $is_CSV = FALSE;

    public function __construct($filename = 'data/address_book.csv')
    {
            $this->filename = $filename; 

            if(substr($filename, -3) == 'CSV') 
            {
                $this->is_CSV = TRUE; 
            }
    }  

    public function read() 
    {
            if ($this->is_CSV == TRUE) {
            return $this->read_CSV();
        } else {
            return $this->read_Lines();
        }
    }

    public function save($contents) 
    {
        if ($this->is_CSV == TRUE) {
            return $this->save_CSV($contents);
        } else {
            return $this->write_lines($contents);
        }
    }

    public function read_lines($return_array = FALSE)
    {
        $handle = fopen($this->filename, "r");
        $contents = fread($handle, filesize($this->filename));
        fclose($handle);
        return explode("\n", $contents);
    }
    //todo list
    public function write_lines($contents)
    {
        if (is_array($contents)) {
            $contents = implode("\n", $ontents);
        }
        $handle = fopen($this->filename, 'w');
        $saveList = implode("\n", $array);
        fwrite($handle, $saveList);
        fclose($handle);
    } 
    
    // address book
    public function reading_address_book() {
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
        // address
    public function write_addres_book($address_array) {
    $handle = fopen($this->filename, "w+");
    foreach ($address_array as $fields) {
        if ($fields != "") {
            fputcsv($handle, $fields);
        }
    }
    fclose($handle);
    }

    public function addingCSV($addressBook) 
    {
        $temp = $_POST;
        if ($temp['name'] == '' || $temp['address'] == '' || ['city'] == '' || ['state'] == '' || ['zip'] == '' && (empty($_FILES))) {
            throw new UnexpectedTypeIvalidInput('required fields where left empty');
        }elseif (strlen($temp['name']) > 125 || strlen($temp['address']) > 125 || strlen($temp['city']) > 125 || strlen($temp['state']) > 125 || strlen($temp['zip']) > 125) {
            throw new UnexpectedTypeIvalidInput('File exceeds more the 125 characters'); 
        }else {
            $addressBook[] = $temp;
            $this->errorMessage = "";
        }
        return $addressBook;
    }

}

?>
