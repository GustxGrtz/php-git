<?php 
session_start();
ob_start();
include_once './conexao.php';

//nao é necessario

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Visualizar Usuário</title>
</head>
<body>
    <a href="listar.php">Listar</a><br>
    <a href="cadastrar.php">Cadastrar</a><br>
    <h1>Visualizar Usuário</h1>
    <?php 
    // Preparar a consulta SQL com parâmetros
    $query_usuario = "SELECT id, nome, email FROM usuarios WHERE id = :id LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id, PDO::PARAM_INT);
    $result_usuario->execute();

    // Verificar se o usuário foi encontrado
    if (($result_usuario) && ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        // Extrair e exibir os dados do usuário
        echo "ID: " . htmlspecialchars($row_usuario['id']) . "<br>";
        echo "Nome: " . htmlspecialchars($row_usuario['nome']) . "<br>";
        echo "Email: " . htmlspecialchars($row_usuario['email']) . "<br>";
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
        header("Location: listar.php");
        exit();
    }
    ?>
</body>
</html>
