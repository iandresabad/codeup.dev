<?php 

class AddressDataStore extends filestore {

	public $filename ='';

	public $errorMessage = "";

    public function __construct($filename = '') 
    {
        if (!empty($filename)) {
            $this->filename = $filename; 
        }else {
        	echo "Your File is empty"; 
        }

    }

    /**
     * Returns array of lines in $this->filename
     */
    public function read_lines_array($return_array = FALSE) 
    {
        $return_array = "{$this->read_Lines()} from {$this->file}";
    }
    
    /**
     * Writes each element in $array to a new line in $this->filename
     */
    function write_lines_contents($contents)
    {
        $contents = "{$this->write_lines()} from {$this-file}";
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    function read_csv($filename = '')
    {
          $filename = "{$this->reading_address_book()} from {$this->filename}"; 
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    function write_csv($address_array)
    {
        $address_array = "{$this->write_address_book()} from {$this->filename}"; 
    }

    function addCSV($addressBook) 
    {
    	$addressBook = "{$this->addingCSV} from {$this->filename}";
    }

}

?>