<?php 
session_start();
ob_start();
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

    <h1>Cadastrar</h1>
    <?php 
    
    $dados = filter_INPUT_array(INPUT_POST,FILTER_DEFAULT);

    
    if(!empty($dados['CadUser'])){

        $empty_input = false;
        $dados = array_map('trim',$dados);
        if(in_array("", $dados)){
            $empty_input = true;
            echo "<p>Preencher todos os campos</p>";
        }elseif(!filter_var($dados['email'],FILTER_VALIDATE_EMAIL)){
            $empty_input = true;
            echo "Email inválido</p>";
        }

    //adicionar mais
        if(!$empty_input){
            $query_fornecedor = "INSERT INTO prova_final (razaoSocial, nomeFantasia, cnpj, responsavel, email, ddd, telefone) VALUES (:razaoSocial, :nomeFantasia, :cnpj, :responsavel, :email, :ddd, :telefone)";
            $cad_fornecedor = $conn->prepare($query_fornecedor);
    
            $cad_fornecedor->bindParam(':razaoSocial', $dados['razaoSocial'], PDO::PARAM_STR);
            $cad_fornecedor->bindParam(':nomeFantasia', $dados['nomeFantasia'], PDO::PARAM_STR);
            $cad_fornecedor->bindParam(':cnpj', $dados['cnpj'], PDO::PARAM_STR);
            $cad_fornecedor->bindParam(':responsavel', $dados['responsavel'], PDO::PARAM_STR);
            $cad_fornecedor->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $cad_fornecedor->bindParam(':ddd', $dados['ddd'], PDO::PARAM_STR);
            $cad_fornecedor->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
            $cad_fornecedor->execute();

            if($cad_fornecedor->rowCount()){
                 unset($dados);
                $_SESSION['msg'] = "Fornecedor cadastrado com sucesso</p>";
                header("location: listar.php");
            }else{
                echo "Erro"; 
            }
        }
    }
    ?>

<!-- adicionar mais -->
<form name="Cad-fornecedor" method="post" action="">
        <label>Razão Social: </label>
        <input type="text" name="razaoSocial" id="razaoSocial" placeholder="Razão Social" value="<?php if(isset($dados['razaoSocial'])){ echo $dados['razaoSocial']; } ?>"><br><br>
        
        <label>Nome Fantasia: </label>
        <input type="text" name="nomeFantasia" id="nomeFantasia" placeholder="Nome Fantasia" value="<?php if(isset($dados['nomeFantasia'])){ echo $dados['nomeFantasia']; } ?>"><br><br>
        
        <label>CNPJ: </label>
        <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" value="<?php if(isset($dados['cnpj'])){ echo $dados['cnpj']; } ?>"><br><br>
        
        <label>Responsável: </label>
        <input type="text" name="responsavel" id="responsavel" placeholder="Responsável" value="<?php if(isset($dados['responsavel'])){ echo $dados['responsavel']; } ?>"><br><br>
        
        <label>Email: </label>
        <input type="email" name="email" id="email" placeholder="Email" value="<?php if(isset($dados['email'])){ echo $dados['email']; } ?>"><br><br>
        
        <label>DDD: </label>
        <input type="text" name="ddd" id="ddd" placeholder="DDD" value="<?php if(isset($dados['ddd'])){ echo $dados['ddd']; } ?>"><br><br>
        
        <label>Telefone: </label>
        <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?php if(isset($dados['telefone'])){ echo $dados['telefone']; } ?>"><br><br>

        <input type="submit" value="Cadastrar" name="CadUser">
    </form>

</body>
</html>
