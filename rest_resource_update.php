<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database file
include_once 'mongodb_config.php';

$dbname = 'toko';
$collection = 'barang';

// DB connection
$db = new Dbmanager();
$conn = $db->getConnection();

// record to update
$data = json_decode(file_get_contents("php://input", true));

$fields = $data->{'fields'};

$set_values = array();

foreach ($fields as $key => $fields) {
    $arr = (array)$fields;
    foreach ($arr as $key => $value) {
        $set_values[$key] = $value;
    }
}

// _id field value
$id = $data->{'where'};

// update record
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(
    ['_id' => new MongoDB\BSON\ObjectId($id)],
    ['$set' => $set_values],
    ['multi' => false, 'upsert' => false]
);

try {
    // Execute the bulk write
    $result = $conn->executeBulkWrite("$dbname.$collection", $bulk);

    // Verify the result
    if ($result->getModifiedCount() == 1) {
        echo json_encode(["message" => "Record Updated Successfully."]);
    } else {
        echo json_encode(["message" => "No Record Found."]);
    }
} catch (Exception $e) {
    // Handle exceptions
    echo json_encode(["message" => "Error updating record: " . $e->getMessage()]);
}
