<?php 
	
$filename = '';

$errorMessage = "";

class AddressDataStore {

	function __construct($filename = 'data/address_book.csv') {
		$this->filename = $filename;
	}	
		
	function reading_address_book() {
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

	function write_addres_book($address_array) {
	$handle = fopen($this->filename, "w");
	foreach ($address_array as $fields) {
		if ($fields != "") {
			fputcsv($handle, $fields);
		}
	}
	fclose($handle);
	}

	function addingCSV($addressBook) {
	$temp = $_POST;
	if ($temp['name'] == '' || $temp['address'] == '' || ['city'] == '' || ['state'] == '' || ['zip'] == '') {
		$this->errorMessage = "Please enter required information";
	}else {
		$addressBook[] = $temp;
		$this->errorMessage = "";
	}
	return $addressBook;
	}
}

?>