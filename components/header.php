<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <?php enqueue_styles(); ?>
</head>
<body>

<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand"><strong>Student Masterlist</strong></a>
    <p class="navbar__title"><?= !empty($_SESSION) ? 'Logged in as: ' . $_SESSION['user']['username'] : '' ?></p>
    <div class="row">
      <?php
      if (! isset($_SESSION['user'])) {
        ?>
        <div class="col">
          <button class="btn btn-outline-success login" data-bs-toggle="modal" data-bs-target="#login">Login</button>
        </div>
        <div class="col">
          <button class="btn btn-outline-warning register" data-bs-toggle="modal" data-bs-target="#register">Register</button>
        </div>
        <?php
      } else {
        ?>
        <div class="col-6">
          <button class="btn btn-outline-danger logout">Logout</button>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</nav>