<?php
require_once __DIR__ . '/../models/Autor.php';

class AutoresController
{
    private $model;

    public function __construct()
    {
        $this->model = new Autor();
    }

    public function index()
    {
        $autores = $this->model->all();
        view('autores.index', ['autores' => $autores, 'base' => '/Proyecto_final_Molina_Cristian']);
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $autor = new Autor();
        $autor->nombre = $data['nombre'];
        $autor->apellido = $data['apellido'];
        $autor->save();
        echo json_encode($autor);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $autor = Autor::find($data['id']);
        $autor->nombre = $data['nombre'];
        $autor->apellido = $data['apellido'];
        $autor->save();
        echo json_encode($autor);
    }

    public function delete($id)
    {
        $autor = Autor::find($id);
        $result = $autor->remove();
        echo json_encode(['status' => $result]);
    }

    public function find($id)
    {
        $autor = Autor::find($id);
        echo json_encode($autor);
    }
}
?>