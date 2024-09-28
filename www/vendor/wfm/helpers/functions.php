<?php

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
    if ($die)
        die;
}

function h($str)
{
    return htmlspecialchars($str);
}
