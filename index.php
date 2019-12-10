<?php
require_once 'vendor/autoload.php';
require_once 'VKBot.php';

$VKBot = new VKBot();
$data = json_decode(file_get_contents('php://input'), false);
$VKBot->parse($data);