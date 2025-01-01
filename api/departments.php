<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    if (isset($_GET['deptid'])) {
        $stmt = $pdo->prepare("SELECT * FROM departments WHERE deptid = ?");
        $stmt->execute([$_GET['deptid']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        $stmt = $pdo->query("SELECT * FROM departments");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// Handle adding a new department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    header('Content-Type: application/json');
    $deptid = $_POST['deptid'] ?? '';
    $deptfullname = $_POST['deptfullname'] ?? '';
    $deptshortname = $_POST['deptshortname'] ?? '';
    $deptcollid = $_POST['deptcollid'] ?? '';

    if (empty($deptid) || empty($deptfullname) || empty($deptcollid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($deptid == '0' || !is_numeric($deptid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Department ID cannot be 0']);
        exit;
    }

    // Check if the department ID already exists
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM departments WHERE deptid = ?');
    $stmt->execute([$deptid]);
    if ($stmt->fetchColumn() > 0) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Department ID already exists']);
        exit;
    }

    // Insert the new department into the database
    $stmt = $pdo->prepare("INSERT INTO departments (deptid, deptfullname, deptshortname, deptcollid) VALUES (?, ?, ?, ?)");
    $stmt->execute([$deptid, $deptfullname, $deptshortname, $deptcollid]);

    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Department added successfully']);
    exit;
}

// Handle updating a department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    header('Content-Type: application/json');
    $deptid = $_POST['deptid'] ?? '';
    $deptfullname = $_POST['deptfullname'] ?? '';
    $deptshortname = $_POST['deptshortname'] ?? '';
    $deptcollid = $_POST['deptcollid'] ?? '';

    if (empty($deptid) || empty($deptfullname) || empty($deptcollid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    // Update the department in the database
    $stmt = $pdo->prepare("UPDATE departments SET deptfullname = ?, deptshortname = ?, deptcollid = ? WHERE deptid = ?");
    $stmt->execute([$deptfullname, $deptshortname, $deptcollid, $deptid]);

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Department updated successfully']);
    exit;
}

// Handle removing a department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    header('Content-Type: application/json');
    $deptid = $_POST['deptid'] ?? '';

    if (empty($deptid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Department ID is required']);
        exit;
    }

    // Remove the department from the database
    $stmt = $pdo->prepare("DELETE FROM departments WHERE deptid = ?");
    $stmt->execute([$deptid]);

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Department removed successfully']);
    exit;
}

// Handle other request methods if needed
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);