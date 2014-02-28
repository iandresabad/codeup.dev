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

$book = new AddressDataStore();

$addressBook = $book->reading_address_book();


if(!empty($_POST)) {
	$addressBook = $book->addingCSV($addressBook);
}


if(isset($_GET['remove']) && is_numeric($_GET['remove'])) {
	$remove = $_GET['remove'];
	unset($addressBook[$remove]);
	$book->write_addres_book($addressBook, $filename); 
	$_GET = array();
	header("Location: address_book.class.php");
	exit(0);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Addres Book</title>
</head>
<body>
	<div style="margin-center: 20px;"></div>
	<h2>Address Book</h2>
		<p>
			<table>
				<? foreach ($addressBook as $key => $address) : ?>
				<tr>
					<? if ($address != '') : ?>
						<? foreach ($address as $item) : ?>
						<td><?= htmlspecialchars(strip_tags($item)); ?></td>
					<? endforeach; ?>
						<td><a href="?remove=<?= $key; ?>">DELETE</a></td>
					<? endif; ?>
				</tr>
				<? endforeach; ?>
			</table>
				<form method="POST" action="">
					<center>
					<h3>Add a new Item</h3> 
					<p><? $errorMessage; ?></p>
					<p>
						<label for="name">Name</label>
						<input id="name" name="name" type="text" autofocus="autofocus" placeholder="Name" required>
					</p>
					<p>
						<label for="address">Address</label>
						<input id="address" name="address" type="text" autofocus="autofocus" placeholder="Address" required>
					</p>
					<p>
						<label for="city">City</label>
						<input id="city" name="city" type="text" autofocus="autofocus" placeholder="City" required>
					</p>
					<p>
						<label for="State">State</label>
						<input id="state" name="state" type="text" autofocus="autofocus" placeholder="State" required>
					</p>
					<p>
						<label for="zip">Zip</label>
						<input id="zip" name="zip" type="text" autofocus="autofocus" placeholder="Zip" required>
					</p>
					<p>
						<button type="submit">Add</button>
					</p>
					<p>&copy; 2014 Ivan Andres Abad</p>
				</center>
				</form>
		</body>
</html>