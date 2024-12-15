<?php

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Allow: DELETE');
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    return;
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

$database = new Database();
$dbConnection = $database->connect();
$bookmark = new Bookmark($dbConnection);

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id)) {
    http_response_code(422);
    echo json_encode(['error' => 'Missing required field: id']);
    return;
}

$bookmark->setId($data->id);

if ($bookmark->delete()) {
    echo json_encode(['message' => 'Bookmark deleted']);
} else {
    echo json_encode(['error' => 'Bookmark not deleted']);
}
