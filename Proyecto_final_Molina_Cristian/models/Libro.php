<?php
require_once 'DB.php';
class Libro extends DB
{
    public $id;
    public $titulo;
    public $autor_id;
    public $autor;

    public static function all()
    {
        $db = new DB();
        $query = 'SELECT l.*, a.nombre as autor_nombre, a.apellido as autor_apellido FROM libros l JOIN autores a ON l.autor_id = a.id';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $libros = $stmt->fetchAll(PDO::FETCH_CLASS, Libro::class);
        foreach ($libros as $libro) {
            $libro->autor = new Autor();
            $libro->autor->id = $libro->autor_id;
            $libro->autor->nombre = $libro->autor_nombre;
            $libro->autor->apellido = $libro->autor_apellido;
        }
        return $libros;
    }

    public static function find($id)
    {
        $db = new DB();
        $stmt = $db->prepare("SELECT l.*, a.nombre as autor_nombre, a.apellido as autor_apellido FROM libros l JOIN autores a ON l.autor_id = a.id WHERE l.id = :id");
        $stmt->execute([":id" => $id]);
        $libro = $stmt->fetchObject(Libro::class);
        if ($libro) {
            $libro->autor = new Autor();
            $libro->autor->id = $libro->autor_id;
            $libro->autor->nombre = $libro->autor_nombre;
            $libro->autor->apellido = $libro->autor_apellido;
        }
        return $libro;
    }

    public function save()
    {
        $db = new DB();
        $params = [":titulo" => $this->titulo, ":autor_id" => $this->autor_id];
        if (empty($this->id)) {
            $stmt = $db->prepare("INSERT INTO libros(titulo, autor_id) VALUES (:titulo, :autor_id)");
            $stmt->execute($params);
            $this->id = $db->lastInsertId();
        } else {
            $params[":id"] = $this->id;
            $stmt = $db->prepare("UPDATE libros SET titulo = :titulo, autor_id = :autor_id WHERE id = :id");
            $stmt->execute($params);
        }
        return true;
    }

    public function remove()
    {
        $db = new DB();
        $stmt = $db->prepare("DELETE FROM libros WHERE id = :id");
        return $stmt->execute([":id" => $this->id]);
    }
}
?>
