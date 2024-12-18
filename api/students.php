<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    if (isset($_GET['studid'])) {
        echo json_encode($pdo->query("SELECT * FROM students WHERE studid = {$_GET['studid']}")->fetch());
    } else {
        echo json_decode($databaseDump['students']);
    }
    exit;
}

// Handle adding a new student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    header('Content-Type: application/json');
    $studid = $_POST['studid'] ?? '';
    $studfirstname = $_POST['studfirstname'] ?? '';
    $studlastname = $_POST['studlastname'] ?? '';
    $studmidname = $_POST['studmidname'] ?? '';
    $studprogid = $_POST['studprogid'] ?? '';
    $studcollid = $_POST['studcollid'] ?? '';
    $studyear = $_POST['studyear'] ?? '';

    if (empty($studfirstname) || empty($studlastname) || empty($studprogid) || empty($studcollid) || empty($studyear) || empty($studid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($studid == '0' || !is_numeric($studid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Student ID cannot be 0']);
        exit;
    }

    // Insert the new student into the database
    $stmt = $pdo->prepare("INSERT INTO students (studid, studfirstname, studlastname, studmidname, studprogid, studcollid, studyear) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$studid, $studfirstname, $studlastname, $studmidname, $studprogid, $studcollid, $studyear]);

    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Student added successfully']);
    exit;
}

// Handle updating a student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    header('Content-Type: application/json');
    $studid = $_POST['studid'] ?? '';
    $studfirstname = $_POST['studfirstname'] ?? '';
    $studlastname = $_POST['studlastname'] ?? '';
    $studmidname = $_POST['studmidname'] ?? '';
    $studprogid = $_POST['studprogid'] ?? '';
    $studcollid = $_POST['studcollid'] ?? '';
    $studyear = $_POST['studyear'] ?? '';

    $missingFields = [];

    if (empty($studid)) {
        $missingFields[] = 'studid';
    }
    if (empty($studfirstname)) {
        $missingFields[] = 'studfirstname';
    }
    if (empty($studlastname)) {
        $missingFields[] = 'studlastname';
    }
    if (empty($studprogid)) {
        $missingFields[] = 'studprogid';
    }
    if (empty($studcollid)) {
        $missingFields[] = 'studcollid';
    }
    if (empty($studyear)) {
        $missingFields[] = 'studyear';
    }

    if (!empty($missingFields)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'The following fields are required: ' . implode(', ', $missingFields)]);
        exit;
    }

    // Update the student in the database
    $stmt = $pdo->prepare("UPDATE students SET studfirstname = ?, studlastname = ?, studmidname = ?, studprogid = ?, studcollid = ?, studyear = ? WHERE studid = ?");
    $stmt->execute([$studfirstname, $studlastname, $studmidname, $studprogid, $studcollid, $studyear, $studid]);

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Student updated successfully']);
    exit;
}

// Handle removing a student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    header('Content-Type: application/json');
    $studid = $_POST['studid'] ?? '';

    if (empty($studid)) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Student ID is required']);
        exit;
    }

    // Remove the student from the database
    $stmt = $pdo->prepare("DELETE FROM students WHERE studid = ?");
    $stmt->execute([$studid]);

    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Student removed successfully']);
    exit;
}

// Handle other request methods if needed
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);