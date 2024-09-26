<?php
/**
 * @var $errno \wfm\ErrorHandler
 * @var $errstr \wfm\ErrorHandler
 * @var $errfile \wfm\ErrorHandler
 * @var $errline \wfm\ErrorHandler
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
</head>
<body>
<h1>Error</h1>
<p>Code: <b><?= $errno ?></b></p>
<p>Message: <b><?= $errstr ?></b></p>
<p>File: <b><?= $errfile ?></b></p>
<p>Line: <b><?= $errline ?></b></p>
</body>
</html>