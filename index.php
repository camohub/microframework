<?php

session_start();

require_once(__DIR__ . '/framework/Application.php');

$application = new Application();
$application->run();


