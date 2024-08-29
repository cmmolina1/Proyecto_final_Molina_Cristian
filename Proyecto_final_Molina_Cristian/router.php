<?php
require_once 'utils/helpers.php';
require_once 'controllers/AutoresController.php';
require_once 'controllers/LibrosController.php';
require_once 'controllers/HomeController.php';

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];



// Eliminar la base del proyecto y los parámetros GET de la URL
$base = '/Proyecto_final_Molina_Cristian';
$request = strtok(str_replace($base, '', $request), '?');

if ($request == '/' || $request == '') {
    (new HomeController())->index();
} elseif (preg_match('/^\/autores\/(\d+)$/', $request, $matches)) {
    if ($method == 'DELETE') {
        (new AutoresController())->delete($matches[1]);
    } elseif ($method == 'GET') {
        (new AutoresController())->find($matches[1]);
    }
} elseif ($request == '/autores') {
    if ($method == 'GET') {
        (new AutoresController())->index();
    } elseif ($method == 'POST') {
        (new AutoresController())->create();
    } elseif ($method == 'PUT') {
        (new AutoresController())->update();
    }
} elseif (preg_match('/^\/libros\/(\d+)$/', $request, $matches)) {
    if ($method == 'DELETE') {
        (new LibrosController())->delete($matches[1]);
    } elseif ($method == 'GET') {
        (new LibrosController())->find($matches[1]);
    }
} elseif ($request == '/libros') {
    if ($method == 'GET') {
        (new LibrosController())->index();
    } elseif ($method == 'POST') {
        (new LibrosController())->create();
    } elseif ($method == 'PUT') {
        (new LibrosController())->update();
    }
} else {
    http_response_code(404);
    echo "404 Not Found";
}
?>



