<?php
class DB extends PDO
{
    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=biblioteca;charset=utf8';
        $username = 'root';
        $password = '';

        try {
            parent::__construct($dsn, $username, $password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}
?>
