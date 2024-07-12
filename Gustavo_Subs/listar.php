<?php 
session_start();
include_once './conexao.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- tirei o css pq corrompeu -->  

    <title>Prova Substitutiva</title>
</head>
<body>
<div class="menu">
    <a href="listar.php">Listar Cliente</a><br>
    <a href="cadastrar.php">Cadastrar Cliente</a><br>
    <h1>Listar</h1>
    </div>

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

    $query_prova_subs = "SELECT idCliente, nomeCompleto, cpf, dataAniversario, profissao, email, faleSobreVoce, telefone FROM prova_subs ORDER BY idCliente DESC LIMIT $inicio, $limite_resultado";
    $result_prova_subs = $conn->prepare($query_prova_subs);
    $result_prova_subs->execute();

    if($result_prova_subs && $result_prova_subs->rowCount() > 0) {
        while($row_prova_subs = $result_prova_subs->fetch(PDO::FETCH_ASSOC)) {
            extract($row_prova_subs);
            echo "ID: $idCliente <br>";
            echo "Nome Completo: $nomeCompleto <br>";
            echo "CPF: $cpf <br>";
            echo "Data Aniversário: $dataAniversario <br>";
            echo "Profissao: $profissao <br>";
            echo "Email: $email <br>";
            echo "Fale Sobre Você: $faleSobreVoce <br>";
            echo "Telefone: $telefone <br>";
            echo "<a href='editar.php?id=$idCliente'>Editar</a><br>";
            echo "<a href='deletar.php?id=$idCliente'>Deletar</a><br>";
            echo "<br>";
        }

    $query_qnt_registros = "SELECT COUNT(idCliente) AS num_result FROM prova_subs";
    $result_qnt_registros = $conn->prepare($query_qnt_registros);
    $result_qnt_registros->execute();
    $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);
    $total_registros = $row_qnt_registros['num_result'];

    } 
    ?>
</body>
</html>

