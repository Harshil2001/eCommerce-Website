<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonString = file_get_contents('php://input');
    $jsonArray = json_decode($jsonString, true);
    $prettyJsonString = json_encode($jsonArray, JSON_PRETTY_PRINT);
    file_put_contents('inventory.json', $prettyJsonString);
    echo json_encode(['status' => 'success', 'message' => 'JSON Inventory updated']);
}
?>
