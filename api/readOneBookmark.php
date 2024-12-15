<?php

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
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

if (!isset($_GET['id'])) {
    http_response_code(422);
    echo json_encode(['error' => 'Missing required field: id']);
    return;
}

$bookmark->setId($_GET['id']);

if ($bookmark->readOne()) {
    echo json_encode([
        'id' => $bookmark->getId(),
        'URL' => $bookmark->getURL(),
        'title' => $bookmark->getTitle(),
        'dateAdded' => $bookmark->getDateAdded(),
    ]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Bookmark not found']);
}
