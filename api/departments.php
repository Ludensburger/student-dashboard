<?php
require 'config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['deptid'])) {
        $deptid = $_GET['deptid'];
        $stmt = $pdo->prepare('SELECT * FROM departments WHERE deptid = ?');
        $stmt->execute([$deptid]);
        $department = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($department);
    } else {
        $stmt = $pdo->query('SELECT * FROM departments');
        $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($departments);
    }
    exit;
}

// Handle adding a new department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $deptid = $_POST['deptid'] ?? '';
    $deptfullname = $_POST['deptfullname'] ?? '';
    $deptshortname = $_POST['deptshortname'] ?? '';
    $deptcollid = $_POST['deptcollid'] ?? '';

    if (empty($deptfullname) || empty($deptcollid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Full Name and College ID are required']);
        exit;
    }

    if ($deptid == '0' || !is_numeric($deptid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Department ID cannot be 0']);
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
    $deptid = $_POST['deptid'] ?? '';
    $deptfullname = $_POST['deptfullname'] ?? '';
    $deptshortname = $_POST['deptshortname'] ?? '';
    $deptcollid = $_POST['deptcollid'] ?? '';

    $missingFields = [];

    if (empty($deptid)) {
        $missingFields[] = 'deptid';
    }
    if (empty($deptfullname)) {
        $missingFields[] = 'deptfullname';
    }
    if (empty($deptcollid)) {
        $missingFields[] = 'deptcollid';
    }

    if (!empty($missingFields)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'The following fields are required: ' . implode(', ', $missingFields)]);
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
    $deptid = $_POST['deptid'] ?? '';

    if (empty($deptid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Department ID is required']);
        exit;
    }

    try {
        // Remove the department from the database
        $stmt = $pdo->prepare("DELETE FROM departments WHERE deptid = ?");
        $stmt->execute([$deptid]);

        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'Department removed successfully']);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Integrity constraint violation
            http_response_code(400); // Bad Request
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete department because it is referenced by other records']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['status' => 'error', 'message' => 'An error occurred while deleting the department']);
        }
    }
    exit;
}

// Handle other request methods if needed
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);