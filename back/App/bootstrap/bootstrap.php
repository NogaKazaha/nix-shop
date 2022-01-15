<?php
require __DIR__ . "/../../vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv = DotEnv::createImmutable(dirname(dirname(__DIR__)));
$dotenv->load();
