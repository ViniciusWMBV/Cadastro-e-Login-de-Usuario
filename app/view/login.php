<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="icon" href="">
    <title>Login</title>
</head>
<body>
    <div class="form-cadastro">
    <h1>Login</h1>
    <form action="../controller/LoginController.php" method="POST">
        <label for="email">E-mail:</label>
        <br>
        <input type="email" name="email" id="email" required>
        <br><br>
        <label for="senha">Senha:</label>
        <br>
        <input type="password" name="senha" id="senha" required>
        <br><br>
        <button type="submit">Entrar</button>
    </form>
</div>
</body>
</html>
