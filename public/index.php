<?php
try {

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../src/convert.php';
    require_once __DIR__ . '/../src/doctrine.php';
    require_once __DIR__ . '/../src/bootstrap.php';
	require_once __DIR__ . '/../src/TratarImagem.php';
} catch (Exception $exception) {
    echo $exception;
    die;
}
