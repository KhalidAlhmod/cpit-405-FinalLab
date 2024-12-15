<?php

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    return;
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Allow these HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow specific headers

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

$database = new Database();
$dbConnection = $database->connect();
$bookmark = new Bookmark($dbConnection);

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id) || !isset($data->URL) || !isset($data->title)) {
    http_response_code(422);
    echo json_encode(['error' => 'Missing required fields: id, URL, title']);
    return;
}

$bookmark->setId($data->id);
$bookmark->setURL($data->URL);
$bookmark->setTitle($data->title);

if ($bookmark->update()) {
    echo json_encode(['message' => 'Bookmark updated']);
} else {
    echo json_encode(['error' => 'Bookmark not updated']);
}
