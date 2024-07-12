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
    
    $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    $limite_resultado = 6;

    $inicio = ($limite_resultado * $pagina) - $limite_resultado;

    $query_prova_final = "SELECT idFornecedor, razaoSocial, nomeFantasia, cnpj, responsavel, email, ddd, telefone FROM prova_final ORDER BY idFornecedor DESC LIMIT $inicio, $limite_resultado";
    $result_prova_final = $conn->prepare($query_prova_final);
    $result_prova_final->execute();

    //adicionar mais
    if($result_prova_final && $result_prova_final->rowCount() > 0) {
        while($row_prova_final = $result_prova_final->fetch(PDO::FETCH_ASSOC)) {
            extract($row_prova_final);
            echo "ID: $idFornecedor <br>";
            echo "Razão Social: $razaoSocial <br>";
            echo "Nome Fantasia: $nomeFantasia <br>";
            echo "CNPJ: $cnpj <br>";
            echo "Responsável: $responsavel <br>";
            echo "Email: $email <br>";
            echo "DDD: $ddd <br>";
            echo "Telefone: $telefone <br>";
            echo "<a href='editar.php?id=$idFornecedor'>Editar</a><br>";
            echo "<a href='deletar.php?id=$idFornecedor'>Deletar</a><br>";
            echo "<br>";
        }

    $query_qnt_registros = "SELECT COUNT(idFornecedor) AS num_result FROM prova_final";
    $result_qnt_registros = $conn->prepare($query_qnt_registros);
    $result_qnt_registros->execute();
    $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);
    $total_registros = $row_qnt_registros['num_result'];

    } 
    ?>
</body>
</html>

