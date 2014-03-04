<?php 
require_once('classes/filestore.php');

class AddressDataStore extends Filestore {

	public $filename ='';

	public $errorMessage = "";

    public function __construct($filename = 'data/address_book.csv') 
    {
        parent::__construct($filename);
        if (!empty($filename)) {
            $this->filename = $filename; 
        }else {
        	echo "Your File is empty"; 
        }

    }

    /**
     * Returns array of lines in $this->filename
     */
    //todo list 
    public function read_lines_array($return_array = FALSE) 
    {
        $return_array = "{$this->read_Lines()} from {$this->filename}";
    }
    
    /**
     * Writes each element in $array to a new line in $this->filename
     */
    //todo list
    public function write_lines_contents($contents)
    {
        $contents = "{$this->write_lines()} from {$this->filename}";
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    //book
    public function read_csv($filename = '')
    {
          $filename = "{$this->reading_address_book()} from {$this->filename}"; 
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    //book
    public function write_csv($address_array)
    {
        $address_array = "{$this->write_address_book()} from {$this->filename}"; 
    }
    //book
    public function addCSV($addressBook) 
    {
        $addressBook = "{$this->addingCSV} from {$this->filename}";
    }
}

?>