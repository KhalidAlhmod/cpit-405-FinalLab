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

$result = $bookmark->readAll();

if (!empty($result)) {
    echo json_encode($result);
} else {
    echo json_encode(['message' => 'No bookmarks found']);
}
