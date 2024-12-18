<?php
$host = 'localhost';
$dbname = 'usjr-jsp1b03';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $databaseDump = [];

    foreach ($tables as $table) {
        // Fetch all rows from each table
        $rows = $pdo->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
        $databaseDump[$table] = $rows;
    }

    // var_dump($databaseDump);
    // print_r("<pre> " . print_r($databaseDump, true) . "</pre>");
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>