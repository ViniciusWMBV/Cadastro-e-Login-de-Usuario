<?php
require_once 'model/Usuario.php';

class UsuarioController {
    public function cadastrar() {
        $mensagem = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
            $confirma_senha = isset($_POST['confirma_senha']) ? $_POST['confirma_senha'] : '';

            // Verifica se todos os campos foram preenchidos
            if (empty($senha) || empty($confirma_senha)) {
                $mensagem = "Todos os campos de senha devem ser preenchidos.";
            } else {
                // Validação da senha
                if (strlen($senha) < 8) {
                    $mensagem = "A senha deve ter pelo menos 8 caracteres.";
                } elseif (!preg_match('/[A-Z]/', $senha)) {
                    $mensagem = "A senha deve conter pelo menos uma letra maiúscula.";
                } elseif (!preg_match('/[a-z]/', $senha)) {
                    $mensagem = "A senha deve conter pelo menos uma letra minúscula.";
                } elseif (!preg_match('/[0-9]/', $senha)) {
                    $mensagem = "A senha deve conter pelo menos um número.";
                } elseif (!preg_match('/[\W_]/', $senha)) {
                    $mensagem = "A senha deve conter pelo menos um caractere especial (ex: ! @ # $ % ^ & *).";
                } elseif ($senha !== $confirma_senha) {
                    // Verifica se as senhas coincidem
                    $mensagem = "As senhas não coincidem. Tente novamente.";
                } else {
                    // Criptografa a senha antes de salvar
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                    // Criação do usuário
                    $usuario = new Usuario($nome, $email, $senha_hash);

                    // Verificar se o arquivo foi enviado
                    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                        $foto = $_FILES['foto'];
                        $diretorio = "../uploads/";

                        // Gera um nome único para a foto
                        $nome_arquivo = basename($foto['name']);
                        $caminho_destino = $diretorio . $nome_arquivo;

                        // Move o arquivo para o diretório de uploads
                        if (move_uploaded_file($foto['tmp_name'], $caminho_destino)) {
                            // Atualiza a foto no banco de dados
                            $usuario->setFoto($nome_arquivo);
                        } else {
                            $mensagem = "Erro ao carregar a imagem.";
                        }
                    }

                    // Salva o usuário no banco de dados
                    if ($usuario->salvar()) {
                        $mensagem = "Usuário cadastrado com sucesso!";
                    } else {
                        $mensagem = "Erro ao cadastrar, tente novamente.";
                    }
                }
            }
        }
        return $mensagem;
    }
}
?>
