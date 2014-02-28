<?php 

require_once('classes/address_data_store.php');

$book = new AddressDataStore();

$addressBook = $book->reading_address_book();

class AddressBook extends AddressDataStore 
{
	public $items = array();

	public function __construct($filename = '') {
		$this->filename = $filename;
	}

	function read_address_book() 
	{
		$this->reading_address_book();	
	}

	function write_address_book($addresses_array) 
	{
		$this->write_address_book();
	}
}


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