<?php 
session_start();
ob_start();
include_once './conexao.php';
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "Usuário não encontrado</p>";
    header("Location: listar.php");
    exit();
}

// Preparar e executar a consulta SQL para obter os dados do usuário
$query_usuario = "SELECT id, nome, email FROM usuarios WHERE id = :id LIMIT 1";
$result_usuario = $conn->prepare($query_usuario);
$result_usuario->bindParam(':id', $id, PDO::PARAM_INT);
$result_usuario->execute();

// Verificar se encontrou o usuário
if ($result_usuario->rowCount() > 0) {
    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
    // Extrair dados do usuário
    $nome = $row_usuario['nome'];
    $email = $row_usuario['email'];
} else {
    $_SESSION['msg'] = "Usuário não encontrado</p>";
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Substitutiva</title>
</head>
<body>
<div class="menu">
    <a href="listar.php">Listar</a><br>
    <a href="cadastrar.php">Cadastrar</a><br>

    <h1>Editar</h1>

    <?php 
    // Verificar se o formulário foi enviado
    if(isset($_POST['EditUsuario'])) {
        // Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Validar os dados do formulário
        $empty_input = false;
        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            echo "Preencha todos os campos</p>";
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $empty_input = true;
            echo "Preencha o campo com um email válido</p>";
        }

        // Se não houver erros de validação, atualiza no banco de dados
        if (!$empty_input) {
            $query_up_usuario = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $edit_usuario = $conn->prepare($query_up_usuario);
            $edit_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $edit_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $edit_usuario->bindParam(':id', $id, PDO::PARAM_INT);

            if ($edit_usuario->execute()) {
                $_SESSION['msg'] = "<p>Usuário editado com sucesso</p>";
                header("Location: listar.php");
                exit();
            } else {
                $_SESSION['msg'] = "Falha ao editar usuário</p>";
            }
        }
    }
    ?>

    <form id="edit-usuario" method="POST" action="">
        <label>Nome: </label>
        <input type="text" name="nome" id="nome" placeholder="Nome Completo" value="<?php echo isset($dados['nome']) ? $dados['nome'] : $nome; ?>"><br><br>
            
        <label>Email: </label>
        <input type="email" name="email" id="email" placeholder="Email" value="<?php echo isset($dados['email']) ? $dados['email'] : $email; ?>"><br><br>

        <input type="submit" value="Atualizar" name="EditUsuario">
    </form>
</body>
</html>