<?php 
session_start();
include_once './conexao.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Substitutiva</title>
</head>
<body>
<div class="menu">
    <a href="listar.php">Listar</a><br>
    <a href="cadastrar.php">Cadastrar</a><br>

    </div>
    <h1>Listar</h1>
   </div>

    <?php 
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    
    // Receber o número da página atual
    $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    // Definir quantidade de registros por página
    $limite_resultado = 6;

    // Calcular o início da visualização
    $inicio = ($limite_resultado * $pagina) - $limite_resultado;

    // Consulta SQL para obter os usuários com paginação
    $query_usuarios = "SELECT id, nome, email FROM usuarios ORDER BY id DESC LIMIT $inicio, $limite_resultado";
    $result_usuarios = $conn->prepare($query_usuarios);
    $result_usuarios->execute();

    // Verificar se encontrou registros no banco de dados
    if($result_usuarios && $result_usuarios->rowCount() > 0) {
        while($row_usuarios = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
            extract($row_usuarios);
            echo "Id: $id <br>";
            echo "Nome: $nome <br>";
            echo "Email: $email <br>";
            echo "<a href='editar.php?id=$id'>Editar</a><br>";
            echo "<a href='deletar.php?id=$id'>Deletar</a><br>";
            echo "<br>";
        }

        // Contar a quantidade total de registros no banco de dados
        $query_qnt_registros = "SELECT COUNT(id) AS num_result FROM usuarios";
        $result_qnt_registros = $conn->prepare($query_qnt_registros);
        $result_qnt_registros->execute();
        $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

    } 
    ?>
</body>
</html>

