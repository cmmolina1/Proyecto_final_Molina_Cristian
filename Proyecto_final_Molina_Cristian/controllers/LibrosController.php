<?php
require_once __DIR__ . '/../models/Libro.php';

class LibrosController
{
    private $model;
    private $autorModel;

    public function __construct()
    {
        $this->model = new Libro();
        $this->autorModel = new Autor();
    }

    public function index()
    {
        $libros = $this->model->all();
        $autores = $this->autorModel->all();
        view('libros.index', ['libros' => $libros, 'autores' => $autores, 'base' => '/Proyecto_final_Molina_Cristian']);
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $libro = new Libro();
        $libro->titulo = $data['titulo'];
        $libro->autor_id = $data['autor_id'];
        $libro->save();
        $libro->autor = Autor::find($libro->autor_id);
        echo json_encode($libro);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $libro = Libro::find($data['id']);
        $libro->titulo = $data['titulo'];
        $libro->autor_id = $data['autor_id'];
        $libro->save();
        $libro->autor = Autor::find($libro->autor_id);
        echo json_encode($libro);
    }

    public function delete($id)
    {
        $libro = Libro::find($id);
        $result = $libro->remove();
        echo json_encode(['status' => $result]);
    }

    public function find($id)
    {
        $libro = Libro::find($id);
        echo json_encode($libro);
    }
}
?>
