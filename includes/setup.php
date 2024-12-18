<?php
require ROOT . '/includes/router.php';
require ROOT . '/includes/functions.php';

$router = Router::getInstance();

$router->addRoute('/', function() {
    require ROOT . '/templates/home.php';
});

$router->addRoute('/colleges/', function() {
    require ROOT . '/templates/colleges.php';
});

$router->addRoute('/students/', function() {
    require ROOT . '/templates/students.php';
});

$router->addRoute('/programs/', function() {
    require ROOT . '/templates/programs.php';
});

$router->addRoute('/departments/', function() {
    require ROOT . '/templates/departments.php';
});

$router->addRoute('/api/students/', function() {
    require ROOT . '/api/students.php';
});

$router->addRoute('/api/programs/', function() {
    require ROOT . '/api/programs.php';
});

$router->addRoute('/api/colleges/', function() {
    require ROOT . '/api/colleges.php';
});

$router->addRoute('/api/departments/', function() {
    require ROOT . '/api/departments.php';
});

$router->addRoute('/api/users/', function() {
    require ROOT . '/api/users.php';
});

$router->dispatch();

