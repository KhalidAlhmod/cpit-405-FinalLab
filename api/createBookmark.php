<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
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

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['URL']) || !isset($data['title'])) {
    http_response_code(422);
    echo json_encode(['error' => 'Missing required fields: URL, title']);
    return;
}

$bookmark->setURL($data['URL']);
$bookmark->setTitle($data['title']);

if ($bookmark->create()) {
    echo json_encode(['message' => 'Bookmark created']);
} else {
    echo json_encode(['error' => 'Bookmark not created']);
}
