<?php 
session_start();
ob_start();
include_once './conexao.php';
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "Cliente não encontrado</p>";
    header("Location: listar.php");
    exit();
}

$query_cliente = "SELECT idCliente, nomeCompleto, cpf, dataAniversario, profissao, email, faleSobreVoce, telefone FROM prova_subs WHERE idCliente = :id LIMIT 1";
$result_cliente = $conn->prepare($query_cliente);
$result_cliente->bindParam(':id', $id, PDO::PARAM_INT);
$result_cliente->execute();

if ($result_cliente->rowCount() > 0) {
    $row_cliente = $result_cliente->fetch(PDO::FETCH_ASSOC);
    $nomeCompleto = $row_cliente['nomeCompleto'];
    $cpf = $row_cliente['cpf'];
    $dataAniversario = $row_cliente['dataAniversario'];
    $profissao = $row_cliente['profissao'];
    $email = $row_cliente['email'];
    $faleSobreVoce = $row_cliente['faleSobreVoce'];
    $telefone = $row_cliente['telefone'];
} else {
    $_SESSION['msg'] = "Cliente não encontrado</p>";
    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prova Substitutiva</title>
</head>
<body>
<div class="menu">
    <a href="listar.php">Listar Cliente</a><br>
    <a href="cadastrar.php">Cadastrar Cliente</a><br>

    <h1>Editar</h1>

    <?php 
    if(isset($_POST['Editcliente'])) {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $empty_input = false;
        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            echo "Preencha todos os campos</p>";
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $empty_input = true;
            echo "Preencha o campo com um email válido</p>";
        }

    if (!$empty_input) {
        $query_up_cliente = "UPDATE prova_subs SET nomeCompleto = :nomeCompleto, cpf = :cpf, dataAniversario = :dataAniversario, profissao = :profissao, email = :email, faleSobreVoce = :faleSobreVoce, telefone = :telefone WHERE idcliente = :id";
        $edit_cliente = $conn->prepare($query_up_cliente);
        $edit_cliente->bindParam(':nomeCompleto', $dados['nomeCompleto'], PDO::PARAM_STR);
        $edit_cliente->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
        $edit_cliente->bindParam(':dataAniversario', $dados['dataAniversario'], PDO::PARAM_STR);
        $edit_cliente->bindParam(':profissao', $dados['profissao'], PDO::PARAM_STR);
        $edit_cliente->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $edit_cliente->bindParam(':faleSobreVoce', $dados['faleSobreVoce'], PDO::PARAM_STR);
        $edit_cliente->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
        $edit_cliente->bindParam(':id', $id, PDO::PARAM_INT);

            if ($edit_cliente->execute()) {
                $_SESSION['msg'] = "<p>Cliente editado com sucesso</p>";
                header("Location: listar.php");
                exit();
            } else {
                $_SESSION['msg'] = "Falha ao editar cliente</p>";
            }
        }
    }
    ?>

  <form id="edit-cliente" method="POST" action="">
    <label>Nome Completo: </label>
    <input type="text" name="nomeCompleto" id="nomeCompleto" placeholder="Nome Completo" value="<?php echo isset($dados['nomeCompleto']) ? $dados['nomeCompleto'] : $nomeCompleto; ?>"><br><br>
        
    <label>CPF: </label>
    <input type="text" name="cpf" id="cpf" placeholder="CPF" value="<?php echo isset($dados['cpf']) ? $dados['cpf'] : $cpf; ?>"><br><br>
    
    <label>Data Aniversário: </label>
    <input type="text" name="dataAniversario" id="dataAniversario" placeholder="Data Aniversário" value="<?php echo isset($dados['dataAniversario']) ? $dados['dataAniversario'] : $dataAniversario; ?>"><br><br>
    
    <label>Profissão: </label>
    <input type="text" name="profissao" id="profissao" placeholder="Profissão" value="<?php echo isset($dados['profissao']) ? $dados['profissao'] : $profissao; ?>"><br><br>
    
    <label>Email: </label>
    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo isset($dados['email']) ? $dados['email'] : $email; ?>"><br><br>
    
    <label>Fale Sobre Voce: </label>
    <input type="text" name="faleSobreVoce" id="faleSobreVoce" placeholder="Fale Sobre Você" value="<?php echo isset($dados['faleSobreVoce']) ? $dados['faleSobreVoce'] : $faleSobreVoce; ?>"><br><br>
    
    <label>Telefone: </label>
    <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?php echo isset($dados['telefone']) ? $dados['telefone'] : $telefone; ?>"><br><br>

    <input type="submit" value="Atualizar" name="Editcliente">

</body>
</html>