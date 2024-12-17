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

function get_header($title = 'Student Information Entry') {
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo htmlspecialchars($title); ?></title>
      <?php enqueue_styles(); ?>
  </head>
  <body>
  <?php
}

function get_footer() {
  enqueue_scripts();
  ?>
  </body>
  </html>
  <?php
}

// Register scripts and styles
register_style('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
register_script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
register_style('/student-dashboard/src/css/styles.css');
register_script('/student-dashboard/src/js/scripts.js');
register_script('/student-dashboard/axios/axios.min.js');
