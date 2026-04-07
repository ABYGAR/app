<?php

$minPHPVersion = '8.0';
if (phpversion() < $minPHPVersion) {
    die("Your PHP version must be {$minPHPVersion} or higher. Current version: " . phpversion());
}

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');

chdir(__DIR__);

require $pathsPath;
$paths = new Config\Paths();

require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();
$app->run();
