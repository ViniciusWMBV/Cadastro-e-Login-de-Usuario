<?php
require_once 'controller/UsuarioController.php';

$controller = new UsuarioController();
$mensagem = $controller->cadastrar();

include'view/cadastro.php';
?>