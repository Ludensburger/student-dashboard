<?php
/**
 * Iterate through php files in the includes folder and include them.
 */

try {
    $dir_iterator = new RecursiveDirectoryIterator(__DIR__ . '/includes/');
    $it = new RecursiveIteratorIterator($dir_iterator);

    foreach ($it as $file) {
        if ($file->isFile() && $file->isReadable() && $file->getExtension() === 'php') {
            require $file->getPathname();
        }
    }
} catch (Exception $e) {
    throw $e;
}