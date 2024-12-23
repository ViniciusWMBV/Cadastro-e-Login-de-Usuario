<?php
session_start();
require_once '../database/Database.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$Ft_Perfil_Usuario = null;

// Instanciar a classe de conexão com o banco de dados
$database = new Database();
$conn = $database->conn;

// Consultar a foto de perfil do usuário no banco de dados
$sql = "SELECT Ft_Perfil_Usuario FROM usuario WHERE nome = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$usuario]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && $result['Ft_Perfil_Usuario']) {
    $Ft_Perfil_Usuario = $result['Ft_Perfil_Usuario'];
}

// Verificar se foi enviado um arquivo pelo formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_perfil'])) {
    // Definir o diretório de upload (ajustado para a pasta uploads fora de app)
    $uploadDir = '../../uploads/ftperfil/'; // Caminho correto para uploads fora da pasta app
    $fileExtension = strtolower(pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION));

    // Gerar um nome único para o arquivo com base no timestamp e id único
    $uniqueName = uniqid('perfil_', true) . '.' . $fileExtension;
    $uploadFile = $uploadDir . $uniqueName;

    // Verificar se o arquivo é uma imagem
    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
        // Tentar mover o arquivo para a pasta uploads
        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $uploadFile)) {
            // Atualizar o banco de dados com o caminho da nova imagem
            $sql = "UPDATE usuario SET Ft_Perfil_Usuario = ? WHERE nome = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $uploadFile, PDO::PARAM_STR);
            $stmt->bindParam(2, $usuario, PDO::PARAM_STR);
            $stmt->execute();

            // Atualizar a variável de foto de perfil
            $Ft_Perfil_Usuario = $uploadFile;

            echo "<p>Imagem atualizada com sucesso!</p>";
        } else {
            echo "<p>Erro no upload da imagem.</p>";
        }
    } else {
        echo "<p>A imagem deve ser nos formatos JPG, JPEG, PNG ou GIF.</p>";
    }
}

// Fechar a conexão com o banco de dados
$database->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($usuario); ?>!</h1>

    <div class="profile-container">
        <?php if ($Ft_Perfil_Usuario): ?>
            <img src="<?php echo htmlspecialchars($Ft_Perfil_Usuario); ?>" alt="Foto de Perfil" class="profile-image">
        <?php else: ?>
            <div class="placeholder">
                <p>Carregar imagem</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Formulário de upload de imagem, para permitir atualização de foto de perfil -->
    <form method="POST" enctype="multipart/form-data">
        <label for="foto_perfil">Selecionar uma imagem:</label>
        <input type="file" name="foto_perfil" id="foto_perfil" required>
        <button type="submit">Atualizar Foto</button>
    </form>

    <a href="../controller/LogoutController.php">Sair</a>
</body>
</html>


