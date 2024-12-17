<?php
/**
 * Iterate through php files in the includes folder and include them.
 */
try {
    $dir_iterator = new \RecursiveDirectoryIterator(__DIR__ . '/includes/');
    $it           = new \RecursiveIteratorIterator($dir_iterator);

    while ($it->valid()) {
        if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->getExtension() === 'php') {
            require $it->key();
        }
        $it->next();
    }
} catch (\Exception $e) {
    throw $e;
}
