<?php

function view($view, $data = [])
{
    extract($data);
    $view = str_replace('.', '/', $view);
    require_once __DIR__ . "/../views/{$view}.php";
}
?>
