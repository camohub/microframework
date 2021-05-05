<?php

session_start();

require_once(__DIR__ . '/framework/application.php');

$application = new Application();
$application->run();


