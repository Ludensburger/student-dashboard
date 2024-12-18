<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Content-Type: application/json');
  echo json_encode($databaseDump['colleges']);
  exit;
}

// Handle other request methods if needed
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);