<?php 

require_once('classes/address_data_store.php');

class UnexpectedTypeIvalidInput extends Exception { }

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

$book = new AddressDataStore('address_book.csv');

try {
	foreach ($_FILES as $empty => $content) {
		if(empty($content)) {
			throw new UnexpectedTypeIvalidInput("Their is no $content in your file");
		}
	}
}catch (UnexpectedTypeIvalidInput $e) {
	echo 'ERROR:' . $e->getMessage();
}


if(!empty($_POST)) 
{
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

if (count($_FILES) > 0 && $_FILES['uploaded_file']['error'] == 0 && $_FILES['uploaded_file']['type'] == 'text/csv') {
	    // Set the destination directory for uploads
	    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
	    // Grab the filename from the uploaded file by using basename
	    $tempfilename = basename($_FILES['uploaded_file']['name']);
	    // Create the saved filename using the file's original name and our upload directory
	    $newlist->filename = $upload_dir . $tempfilename;
	    // Move the file from the temp location to our uploads directory
	    move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newlist->filename);
	    $appendList = $newlist->read_address_book();
	    if (isset($_POST['overwrite']) && $_POST['overwrite'] == "yes") {
	    	$addressBook = $appendList;
	    	$book->write_address_book($addressBook);
	    } else {
	    	$addressBook = array_merge($addressBook, $appendList);
	    	$book->write_address_book($addressBook);
	    }
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
						<form method = "POST" enctype="multipart/form-data" action = "">
					<p>
				        <label for="uploaded_file"></label>
				        <input id="uploaded_file" name="uploaded_file" type="file">
				    </p>
				    <p>
					    <label for="overwrite">
						    <input type="checkbox" id="overwrite" name="overwrite" value="yes"> Over Write
						</label>
					</p>
				    <p>
					<p>&copy; 2014 Ivan Andres Abad</p>
				</center>
				</form>
		</body>
</html>