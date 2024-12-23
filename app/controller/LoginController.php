<?php
require_once '../database/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Conexão com o banco de dados usando PDO
    $db = new Database();
    $conn = $db->conn;

    // Verificação do login
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        session_start();
        $_SESSION['usuario'] = $usuario['nome'];
        header('Location: ../view/dashboard.php'); // Redireciona para o dashboard
        exit();
    } else {
        echo "E-mail ou senha incorretos.";
    }

    // Fechar a conexão
    $db->close();
}
?>
