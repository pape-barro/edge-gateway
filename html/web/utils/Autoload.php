<?php
function autoload($class) {
    try {
        require_once str_replace('\\', '/', $class) . '.class.php';
    } catch (Exception $exc) {
        die('Impossible d\'ouvrir le fichier : ' . $class);
    }
}

spl_autoload_register('autoload');