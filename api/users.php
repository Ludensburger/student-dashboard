<?php
// ini_set("session.save_path", "C:/Users/hp/Desktop/ryu-files/Codes/PHP/phpsite/final-project/student-dashboard/src/sessions");

session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Content-Type: application/json');
  echo json_encode($databaseDump['users']);
  exit;
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
      http_response_code(400); // Bad Request
      echo json_encode(['status' => 'error', 'message' => 'Username and password are required']);
      exit;
  }

  // Check if the username already exists
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  if ($stmt->fetch()) {
      http_response_code(409); // Conflict
      echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
      exit;
  }

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert the new user into the database
  $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->execute([$username, $hashedPassword]);

  http_response_code(201); // Created
  echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
  exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
      http_response_code(400); // Bad Request
      echo json_encode(['status' => 'error', 'message' => 'Username and password are required']);
      exit;
  }

  // Fetch the user from the database
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if (!$user || !password_verify($password, $user['password'])) {
      http_response_code(401); // Unauthorized
      echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
      exit;
  }

  // Set user info to session
  $_SESSION['user'] = [
    'id' => $user['ID'],
    'username' => $user['username']
  ];

  http_response_code(200); // OK
  echo json_encode([
    'status' => 'success',
    'message' => 'Login successful',
    'user' => [
        'id' => $user['ID'],
        'username' => $user['username']
    ]
  ]);
  exit;
}

// Handle logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
  session_destroy();
  http_response_code(200); // OK
  echo json_encode(['status' => 'success', 'message' => 'Logout successful']);
  exit;
}

// Handle other request methods if needed
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);