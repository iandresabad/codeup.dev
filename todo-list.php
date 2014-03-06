<?php
//Read a file and then return it
function read_file($file) {
	$handle = fopen($file, "r");
		$contents = fread($handle, filesize($file));
	fclose($handle);
	return explode("\n", $contents);
}

//save file txt to an array
function save_file($file, $array) {
	$handle = fopen($file, 'w');
	$saveList = implode("\n", $array);
	fwrite($handle, $saveList);
	fclose($handle);
}

//open and set a file location 
$file = "data/todo_list.txt";
$archiveFile = "data/archives.txt";
$archives = read_file($archiveFile);
//it checks if the file is not empty 
$items = (filesize($file) > 0) ? read_file($file) : array();

//then add the items to the list
if (!empty($_POST['newItem'])) {
	array_push($items, $_POST['newItem']);
	save_file($file, $items);
	header("location: todo-list.php");
	exit(0);
}

if(isset($_GET['remove'])) {
	$archiveItem = array_splice($items, $_GET['remove'], 1);
	$archives = array_merge($archives, $archiveItem);
	save_file($archiveFile, $archives);
	save_file($file, $items);
	header("Location: todo-list.php");
	exit(0);
}

$errorMessage = '';
//errros that are given if their is no text file when file uploaded
if(count($_FILES) > 0) {
	if($_FILES['file1']['error'] != 0) {
		$errorMessage = 'ERROR UPLOADING FILE.';
	}elseif ($_FILES['file1']['type'] != 'text/plain') {
		$errorMessage = 'ERROR: INVALID FILE TYPE.';
	}else {
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$fileContents = read_file($saved_filename);

		if ($_POST['file0'] == TRUE) {
			$items = $fileContents;
		}else {
			$items = array_merge($items, $fileContents);
		}

		save_file($file, $items);
		header("Location: todo-list.php");
		exit(0);
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>TODO List with CSS</title>
	<link rel="stylesheet" href="/css/todo-list.css">
</head>
<body>
	<div id="container">
		<h1 class ="fancy-header">TODO List</h1>
			<div class="itemContainer">
				<ul>
					<? foreach ($items as $key => $item): ?>
						<li><?= htmlspecialchars(strip_tags($item)); ?> <a href="?remove=<?= $key; ?>">DELETE</a></li>
						<? endforeach; ?>
				</ul>
				<h3 class="fancy-header">Add a TODO List item:</h3>
				<form method="POST" enctype="multipart/form-data" action="todo-list.php">
					<p>
						<label for="newItem">New Item</label>
						<input id="newItem" name ="newItem" type="text" autofocus="autofocus">
					</p>
					<p>
						<? if (!empty($errorMessage)) : ?>
						<?= $errorMessage; ?>
						<? endif; ?>
					</p>
					<p>
						<button type="submit">Add Item</button>
					</p>
					<p>
						<label for="file0">Overwrite File? </label>
						<input id="file0" name="file0" type="checkbox">
					</p>
						<label for="file1">File to upload: </label>
						<input id="file1" name="file1" type="file">
						<p>&copy; 2014 Ivan Andres Abad</p>
					</form>
				</div>
		</div>
</body>
</html>