<?php
$styles = [];
$scripts = [];

function register_style($style) {
  global $styles;
  $styles[] = $style;
}

function register_script($script) {
  global $scripts;
  $scripts[] = $script;
}

function enqueue_styles() {
  global $styles;
  foreach ($styles as $style) {
      echo '<link rel="stylesheet" type="text/css" href="' . htmlspecialchars($style) . '">';
  }
}

function enqueue_scripts() {
  global $scripts;
  foreach ($scripts as $script) {
      echo '<script src="' . htmlspecialchars($script) . '"></script>';
  }
}

function get_header() {
  require __DIR__ . '/../components/header.php';
}

function get_footer() {
  require __DIR__ . '/../components/footer.php';
}

// Register scripts and styles
register_style('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
register_script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
register_script('/student-dashboard/dist/bundle.js');
register_script('/student-dashboard/axios/axios.min.js');
