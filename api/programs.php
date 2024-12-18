<?php
require 'config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['progid'])) {
        $progid = $_GET['progid'];
        $stmt = $pdo->prepare('SELECT * FROM programs WHERE progid = ?');
        $stmt->execute([$progid]);
        $program = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($program);
    } else {
        $stmt = $pdo->query('SELECT * FROM programs');
        $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($programs);
    }
    exit;
}

// Handle adding a new program
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $progfullname = $_POST['progfullname'] ?? '';
    $progshortname = $_POST['progshortname'] ?? '';
    $progcollid = $_POST['progcollid'] ?? '';
    $progcolldeptid = $_POST['progcolldeptid'] ?? '';

    if (empty($progfullname) || empty($progcollid) || empty($progcolldeptid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Full Name, College ID, and Department ID are required']);
        exit;
    }

    // Insert the new program into the database
    $stmt = $pdo->prepare("INSERT INTO programs (progfullname, progshortname, progcollid, progcolldeptid) VALUES (?, ?, ?, ?)");
    $stmt->execute([$progfullname, $progshortname, $progcollid, $progcolldeptid]);

    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Program added successfully']);
    exit;
}

// Handle updating a program
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $progid = $_POST['progid'] ?? '';
    $progfullname = $_POST['progfullname'] ?? '';
    $progshortname = $_POST['progshortname'] ?? '';
    $progcollid = $_POST['progcollid'] ?? '';
    $progcolldeptid = $_POST['progcolldeptid'] ?? '';

    $missingFields = [];

    if (empty($progid)) {
        $missingFields[] = 'progid';
    }
    if (empty($progfullname)) {
        $missingFields[] = 'progfullname';
    }
    if (empty($progcollid)) {
        $missingFields[] = 'progcollid';
    }
    if (empty($progcolldeptid)) {
        $missingFields[] = 'progcolldeptid';
    }

    if (!empty($missingFields)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'The following fields are required: ' . implode(', ', $missingFields)]);
        exit;
    }

    // Update the program in the database
    $stmt = $pdo->prepare("UPDATE programs SET progfullname = ?, progshortname = ?, progcollid = ?, progcolldeptid = ? WHERE progid = ?");
    $stmt->execute([$progfullname, $progshortname, $progcollid, $progcolldeptid, $progid]);

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Program updated successfully']);
    exit;
}

// Handle removing a program
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $progid = $_POST['progid'] ?? '';

    if (empty($progid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Program ID is required']);
        exit;
    }

    // Remove the program from the database
    $stmt = $pdo->prepare("DELETE FROM programs WHERE progid = ?");
    $stmt->execute([$progid]);

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Program removed successfully']);
    exit;
}

// Handle other request methods if needed
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);