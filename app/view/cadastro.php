<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="icon" href="">
    <title>Cadastre-se</title>
</head>
<body>
    <div class="form-cadastro">
    <h1>Cadastre-se</h1>
    <form action="index.php" method="POST">
        <label for="nome">Nome:</label>
        <br>
        <input type="text" name="nome" required placeholder="Digite seu nome">
        <br><br>
        <label for="email">Email:</label>
        <br>
        <input type="email" name="email" required placeholder="Digite seu Email">
        <br><br>
        <label for="senha">Senha:</label>
        <br>
        <input type="password" name="senha" required placeholder="Digite sua senha">
        <br><br>
        <label for="confirma_senha">Repita sua senha:</label>
        <br>
        <input type="password" name="confirma_senha" required placeholder="Digite sua senha novamente">
        <br><br>
        <button type="submit">Cadastrar</button>
       <a href="view/login.php"><p>Fazer login</p></a>
    </form>

    <?php if (isset($mensagem)) echo "<p> $mensagem</p>"; 
    ?>
    </div>
</body>
</html>