<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "cadastro_usuario";
    public $conn;

    public function __construct(){
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Conexão falhou: " . $e->getMessage());
        }
    }

    public function close(){
        $this->conn = null;
    }
}
?>
