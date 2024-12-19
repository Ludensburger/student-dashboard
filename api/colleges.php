<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    if (isset($_GET['collid'])) {
        echo json_encode($pdo->query("SELECT * FROM colleges WHERE collid = {$_GET['collid']}")->fetch());
    } else {
        echo json_encode($pdo->query("SELECT * FROM colleges")->fetchAll());
    }
    exit;
}

// Handle adding a new college
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    header('Content-Type: application/json');
    $collid = $_POST['collid'] ?? '';
    $collfullname = $_POST['collfullname'] ?? '';
    $collshortname = $_POST['collshortname'] ?? '';

    if (empty($collid) || empty($collfullname) || empty($collshortname)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($collid == '0' || !is_numeric($collid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'College ID cannot be 0']);
        exit;
    }

    // Check if the college ID already exists
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM colleges WHERE collid = ?');
    $stmt->execute([$collid]);
    if ($stmt->fetchColumn() > 0) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'College ID already exists']);
        exit;
    }

    // Insert the new college into the database
    $stmt = $pdo->prepare("INSERT INTO colleges (collid, collfullname, collshortname) VALUES (?, ?, ?)");
    $stmt->execute([$collid, $collfullname, $collshortname]);

    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'College added successfully']);
    exit;
}

// Handle updating a college
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    header('Content-Type: application/json');
    $collid = $_POST['collid'] ?? '';
    $collfullname = $_POST['collfullname'] ?? '';
    $collshortname = $_POST['collshortname'] ?? '';

    if (empty($collid) || empty($collfullname) || empty($collshortname)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($collid == '0' || !is_numeric($collid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'College ID cannot be 0']);
        exit;
    }

    // Update the college in the database
    $stmt = $pdo->prepare("UPDATE colleges SET collid = ?, collfullname = ?, collshortname = ? WHERE collid = ?");
    $stmt->execute([$collid, $collfullname, $collshortname, $collid]);

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'College updated successfully']);
    exit;
}

// Handle removing a college
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    header('Content-Type: application/json');
    $collid = $_POST['collid'] ?? '';

    if (empty($collid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'College ID is required']);
        exit;
    }

    try {
        // Remove the college from the database
        $stmt = $pdo->prepare("DELETE FROM colleges WHERE collid = ?");
        $stmt->execute([$collid]);

        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'College removed successfully']);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Integrity constraint violation
            http_response_code(400); // Bad Request
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete college because it is referenced by other records']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['status' => 'error', 'message' => 'An error occurred while deleting the college']);
        }
    }
    exit;
}

// Handle other request methods if needed
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);