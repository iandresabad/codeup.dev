<?php 

$filename = "data/address_book.csv";
$errorMessage = "";

function readingCSV($filename) {
	$handle = fopen($filename, 'r');
	$filesize = filesize($filename);
	$contents = [];
	if($filesize != 0) {
		while(!feof($handle)) {
			$contents[] = fgetcsv($handle);
		}	
	}else {
		$contents = array();
	}
	fclose($handle);
	return $contents;
}


function savingCSV($address_book, $filename) {
	$handle = fopen($filename, "w");
	foreach ($address_book as $row) {
		if ($row != "") {
			fputcsv($handle, $row);
		}
	}
	fclose($handle);
}

function addingCSV($address_book, &$errorMessage) {
	$temp = $_POST;
	if ($temp['name'] == '' || $temp['address'] == '' || ['city'] == '' || ['state'] == '' || ['zip'] == '') {
		$errorMessage = "Please enter required information";
	}else {
		$address_book[] = $temp;
		$errorMessage = "";
	}
	return $address_book;
}

$address_book = readingCSV($filename);

if(!empty($_POST)) {
	$address_book = addingCSV($address_book, $errorMessage);
}

if(isset($_GET['remove']) && is_numeric($_GET['remove'])) {
	$remove = $_GET['remove'];
	unset($address_book[$remove]);
	savingCSV($address_book, $filename);
	$_GET = array();
	header("Location: address_book.php");
	exit(0);
}

savingCSV($address_book, $filename);
	// $name = $_POST['names'];
	// $address = $_POST['address'];
	// $city = $_POST['city'];
	// $state = $_POST['state'];
	// $zip = $_POST['zip'];

	// $entry = [$names, $address, $city, $state, $zip] 

	// array_push($address_book, $entry);

	// writeCSV('data/address_book.csv', $address_book);



// $address_book = [
//     ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
//     ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
//     ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
// ];

// var_dump($_POST)
// $archives = readingCSV($address_book);
// $value = (filesize($address_book) >0) ? readingCSV($address_book) : array(); 

// if(isset($_GET['remove'])) {
// 	$archiveValue = array_splice($value, $_GET['remove'], 1);
// 	$archives = array_merge($archives, $archiveValue);
// 	writeCSV($address_book, $value);
// 	header("Location: address_book.csv");
// 	foreach ($value as $key) {

		
// 	}
// }


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
				<? foreach ($address_book as $key => $address) : ?>
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