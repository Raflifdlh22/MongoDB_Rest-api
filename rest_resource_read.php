<?php

// required headers
header("Access-Control-allow-origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database file
include_once 'mongodb_config.php';

//DB connection
$dbname = 'toko';
$collection = 'barang';

// DB connection
$db = new DbManager();
$conn = $db->getConnection();

// read all records
$filter = [];
$option = [];
$query = new MongoDB\Driver\Query($filter, $option);

$records = $conn->executeQuery("$dbname.$collection", $query);

echo json_encode(iterator_to_array($records));
