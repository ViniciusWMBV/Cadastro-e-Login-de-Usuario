<?php
    require_once('database/Database.php');

    class Usuario {
        private $nome;
        private $email;
        private $senha;
        private $db;
        public function __construct($nome, $email, $senha){
            $this->nome = $nome;
            $this->email = $email;
            $this->senha = $senha;
            $this->db = new Database();
    }

    public function salvar() {
        $stmt = $this->db->conn->prepare
        ("INSERT INTO usuario (nome, email, senha) VALUES (?,?,?)");
        $stmt->bind_param("sss", $this->nome, $this->email, $this->senha);
        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
    
    public function __destruct() {
        $this->db->close();
    }
}

?>