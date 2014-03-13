<?php

// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'national_parks_db');

// Check for errors
if ($mysqli->connect_errno) {
    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Create the query and assign to var
$tableCreate = 'create table national_parks (
	id int unsigned NOT NULL AUTO_INCREMENT,
	name varchar(100) NOT NULL,
	location varchar(100) NOT NULL,
	description text NOT NULL,
	date_established DATE NOT NULL,
	area_in_acres FLOAT(10,2) DEFAULT 0,
	primary key (id)
);';

// Run query, if there are errors then display them
if (!$mysqli->query($tableCreate)) {
    throw new Exception("Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error);
}

$parks = [
	[
	    'name' => 'Acadia',
	    'location' => 'Maine',
	    'description' => 'Covering most of Mount Desert Island and other coastal islands, Acadia features the tallest mountain on the Atlantic coast of the United States, granite peaks, ocean shoreline, woodlands, and lakes. There are freshwater, estuary, forest, and intertidal habitats.',
	    'date_established' => '1919-02-26',
	    'area_in_acres' => '47389.67'
    ],
	[
		'name' => 'American Samoa',
		'location' => 'American Samoa',
		'description' => 'The southernmost national park is on three Samoan islands and protects coral reefs, rainforests, volcanic mountains, and white beaches. The area is also home to flying foxes, brown boobies, sea turtles, and 900 species of fish.',
		'date_established' => '1988-10-31',
		'area_in_acres' => '9000'	

	],
	[
		'name' => 'Arches',
		'location' => 'Utah',
		'description' => 'This site features more than 2,000 natural sandstone arches, including the Delicate Arch. In a desert climate millions of years of erosion have led to these structures, and the arid ground has life-sustaining soil crust and potholes, natural water-collecting basins. Other geologic formations are stone columns, spires, fins, and towers.',
		'date_established' => '1971-11-12',
		'area_in_acres' => '76518.98'	

	]

];

foreach ($parks as $park) {
	$query = "INSERT INTO national_parks (name, location, description, date_established, area_in_acres) VALUES('{$park['name']}', '{$park['location']}', '{$park['description']}', '{$park['date_established']}', '{$park['area_in_acres']}');";
	// Execute Query
	if (!$mysqli->query($query)) {
    throw new Exception("Query failed: (" . $mysqli->errno . ") " . $mysqli->error);
	}
}


?>