<?php
require_once 'DB.php';
class Autor extends DB
{
    public $id;
    public $nombre;
    public $apellido;

    public static function all()
    {
        $db = new DB();
        $query = 'SELECT * FROM autores';
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Autor::class);
    }

    public static function find($id)
    {
        $db = new DB();
        $stmt = $db->prepare("SELECT * FROM autores WHERE id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetchObject(Autor::class);
    }

    public function save()
    {
        $db = new DB();
        $params = [":nombre" => $this->nombre, ":apellido" => $this->apellido];
        if (empty($this->id)) {
            $stmt = $db->prepare("INSERT INTO autores(nombre, apellido) VALUES (:nombre, :apellido)");
            $stmt->execute($params);
            $this->id = $db->lastInsertId();
        } else {
            $params[":id"] = $this->id;
            $stmt = $db->prepare("UPDATE autores SET nombre = :nombre, apellido = :apellido WHERE id = :id");
            $stmt->execute($params);
        }
        return true;
    }

    public function remove()
    {
        $db = new DB();
        $stmt = $db->prepare("DELETE FROM autores WHERE id = :id");
        return $stmt->execute([":id" => $this->id]);
    }
}
?>
