<?php
	
function get_file_added($file) {
	$handle = fopen($file, "r");
	$setFile = filesize($file);
	if ($setFile > 0) {
		$contents = fread($handle, filesize($file)); 
		fclose($handle); 
		return explode("\n", $contents); 
	} else {
		echo "You don't have items on your list"; 
		return array(); 
	}
}  

function save_file($file, $array) {
    $handle = fopen($file, 'w');
    $saveList = implode("\n", $array);
    fwrite($handle, $saveList);
    fclose($handle);

}

$file = "data/todo_list.txt";
$items = get_file_added($file);

if (!empty($_POST)) {
	array_push($items, $_POST['newItem']);
	save_file("data/todo_list.txt", $items);
	header("Location: todo-list.php");
}

if (!empty($_GET)) {
	array_splice($items, $_GET['remove'], 1);
	save_file($file, $items);
	header("Location: todo-list.php");
} 

if(isset($_POST['newItem'])) {
	array_push($file, $items);
	save_file($file, $items);
}

if(isset($_GET['remove'])) {
	$itemId = $_GET['remove'];
	unset($items[$itemId]);
	save_file($file, $items); 
}

$errorMessage = '';
if (count($_FILES) > 0 && $_FILES['file1']['error'] != 0){
	if($_FILES['file1']['type'] != 'text/plain') {
		$errorMessage = 'ERROR: INVALID FILE TYPE.';
	}elseif($_FILES['file1']['error'] != 0) {
		$errorMessage = 'ERROR UPLOADING FILE';
	}else {
	$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
	$filename = basename($_FILES['file1']['name']);
	$saved_filename = $upload_dir . $filename;
	move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

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


if (isset($saved_filename)) {

	echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>File Upload</title>
</head>
<body>
	<h2>TODOs!</h2>
	<ul>
		<? foreach ($items as $key => $item): ?>
			<li><?= htmlspecialchars(strip_tags($item)); ?> <a href="?remove=<?php echo $key; ?>"> Delete</a></li>
		<? endforeach; ?>
	</ul>
	<h3>Add a TODO list item:</h3>
	<form method="POST" action="todo-list.php">
	<p>
		<label for="newItem">New Item:</label>
			<input id="newItem" name="newItem" type="text" autofocus="autofocus"> 
			<button type="submit">Add Item</button>
	</p>
	<? if(!empty($errorMessage)) : ?>
		<a><?= $errorMessage; ?></a>
	<? endif; ?>
	<p>

		<label for="file1"></label>
		<input type="file" id="file1" name="file1">
	</p>
	<p>
		<input type="submit" value="upload">
	</p>
</form>
</body>
</html>