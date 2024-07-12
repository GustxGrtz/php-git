<?php 
session_start();
ob_start();
include_once './conexao.php';
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "Fornecedor não encontrado</p>";
    header("Location: listar.php");
    exit();
}

$query_fornecedor = "SELECT idFornecedor, razaoSocial, nomeFantasia, cnpj, responsavel, email, ddd, telefone FROM prova_final WHERE idFornecedor = :id LIMIT 1";
$result_fornecedor = $conn->prepare($query_fornecedor);
$result_fornecedor->bindParam(':id', $id, PDO::PARAM_INT);
$result_fornecedor->execute();

//adicionar mais
if ($result_fornecedor->rowCount() > 0) {
    $row_fornecedor = $result_fornecedor->fetch(PDO::FETCH_ASSOC);
    $razaoSocial = $row_fornecedor['razaoSocial'];
    $nomeFantasia = $row_fornecedor['nomeFantasia'];
    $cnpj = $row_fornecedor['cnpj'];
    $responsavel = $row_fornecedor['responsavel'];
    $email = $row_fornecedor['email'];
    $ddd = $row_fornecedor['ddd'];
    $telefone = $row_fornecedor['telefone'];
} else {
    $_SESSION['msg'] = "Fornecedor não encontrado</p>";
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
    if(isset($_POST['EditFornecedor'])) {
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

    //adicionar mais

    if (!$empty_input) {
        $query_up_fornecedor = "UPDATE prova_final SET razaoSocial = :razaoSocial, nomeFantasia = :nomeFantasia, cnpj = :cnpj, responsavel = :responsavel, email = :email, ddd = :ddd, telefone = :telefone WHERE idFornecedor = :id";
        $edit_fornecedor = $conn->prepare($query_up_fornecedor);
        $edit_fornecedor->bindParam(':razaoSocial', $dados['razaoSocial'], PDO::PARAM_STR);
        $edit_fornecedor->bindParam(':nomeFantasia', $dados['nomeFantasia'], PDO::PARAM_STR);
        $edit_fornecedor->bindParam(':cnpj', $dados['cnpj'], PDO::PARAM_STR);
        $edit_fornecedor->bindParam(':responsavel', $dados['responsavel'], PDO::PARAM_STR);
        $edit_fornecedor->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $edit_fornecedor->bindParam(':ddd', $dados['ddd'], PDO::PARAM_STR);
        $edit_fornecedor->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
        $edit_fornecedor->bindParam(':id', $id, PDO::PARAM_INT);

            if ($edit_fornecedor->execute()) {
                $_SESSION['msg'] = "<p>fornecedor editado com sucesso</p>";
                header("Location: listar.php");
                exit();
            } else {
                $_SESSION['msg'] = "Falha ao editar fornecedor</p>";
            }
        }
    }
    ?>

  <form id="edit-fornecedor" method="POST" action="">
    <label>Razão Social: </label>
    <input type="text" name="razaoSocial" id="razaoSocial" placeholder="Razão Social" value="<?php echo isset($dados['razaoSocial']) ? $dados['razaoSocial'] : $razaoSocial; ?>"><br><br>
        
    <label>Nome Fantasia: </label>
    <input type="text" name="nomeFantasia" id="nomeFantasia" placeholder="Nome Fantasia" value="<?php echo isset($dados['nomeFantasia']) ? $dados['nomeFantasia'] : $nomeFantasia; ?>"><br><br>
    
    <label>CNPJ: </label>
    <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" value="<?php echo isset($dados['cnpj']) ? $dados['cnpj'] : $cnpj; ?>"><br><br>
    
    <label>Responsável: </label>
    <input type="text" name="responsavel" id="responsavel" placeholder="Responsável" value="<?php echo isset($dados['responsavel']) ? $dados['responsavel'] : $responsavel; ?>"><br><br>
    
    <label>Email: </label>
    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo isset($dados['email']) ? $dados['email'] : $email; ?>"><br><br>
    
    <label>DDD: </label>
    <input type="text" name="ddd" id="ddd" placeholder="DDD" value="<?php echo isset($dados['ddd']) ? $dados['ddd'] : $ddd; ?>"><br><br>
    
    <label>Telefone: </label>
    <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?php echo isset($dados['telefone']) ? $dados['telefone'] : $telefone; ?>"><br><br>

    <input type="submit" value="Atualizar" name="EditFornecedor">

</body>
</html>