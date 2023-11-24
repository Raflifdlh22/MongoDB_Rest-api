<?php

// required headers
header("Access_Control_allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");

// include database and object files
include_once 'mongodb_config.php';

$dbname = 'toko';
$collection = 'barang';

// DB connection
$db = new DbManager();
$conn = $db->getConnection();

// record too add
$data = json_decode(file_get_contents("php://input", true));

// insert record
$insert = new MongoDB\Driver\BulkWrite();
$insert->insert($data);

$result = $conn->executeBulkWrite("$dbname.$collection", $insert);

// verify
if ($result->getInsertedCount() == 1) {
    echo json_encode(
        array("message" => "Record successfully created")
    );
} else {
    echo json_encode(
        array("message" => "Error while saving record")
    );
}
