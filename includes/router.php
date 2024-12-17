<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseSlug = 'student-dashboard';
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathSegments = explode('/', trim($path, '/'));
$slug = isset($pathSegments[1]) ? $pathSegments[1] : '';

// Check if the base slug matches
if (isset($pathSegments[0]) && $pathSegments[0] === $baseSlug) {
    // Define the base directory for templates
    $templateDir = __DIR__ . '/../templates/';

    // Define the default route
    $defaultRoute = 'home.php';

    // Determine the template file to include
    $templateFile = $templateDir . ($slug ? $slug . '.php' : $defaultRoute);

    // Check if the template file exists
    if (file_exists($templateFile)) {
        require $templateFile;
    } else {
        // Default to a 404 page or redirect to a default page
        http_response_code(404);
        echo 'Page not found';
    }
} else {
    // Default to a 404 page or redirect to a default page
    http_response_code(404);
    echo 'Page not found';
}