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
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- tirei o css pq corrompeu -->  
    <title>Prova Substitutiva</title>
</head>
<body>
<div class="menu">
    <a href="listar.php">Listar Cliente</a><br>
    <a href="cadastrar.php">Cadastrar Cliente</a><br>

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

        if(!$empty_input){
            $query_cliente = "INSERT INTO prova_subs (nomeCompleto, cpf, dataAniversario, profissao, email, faleSobreVoce, telefone) VALUES (:nomeCompleto, :cpf, :dataAniversario, :profissao, :email, :faleSobreVoce, :telefone)";
            $cad_cliente = $conn->prepare($query_cliente);
    
            $cad_cliente->bindParam(':nomeCompleto', $dados['nomeCompleto'], PDO::PARAM_STR);
            $cad_cliente->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
            $cad_cliente->bindParam(':dataAniversario', $dados['dataAniversario'], PDO::PARAM_STR);
            $cad_cliente->bindParam(':profissao', $dados['profissao'], PDO::PARAM_STR);
            $cad_cliente->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $cad_cliente->bindParam(':faleSobreVoce', $dados['faleSobreVoce'], PDO::PARAM_STR);
            $cad_cliente->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
            $cad_cliente->execute();

            if($cad_cliente->rowCount()){
                 unset($dados);
                $_SESSION['msg'] = "Cliente cadastrado com sucesso</p>";
                header("location: listar.php");
            }else{
                echo "Erro"; 
            }
        }
    }
    ?>

<form name="Cad-cliente" method="post" action="">
        <label>Nome Completo: </label>
        <input type="text" name="nomeCompleto" id="nomeCompleto" placeholder="Nome Completo" value="<?php if(isset($dados['nomeCompleto'])){ echo $dados['nomeCompleto']; } ?>"><br><br>
        
        <label>CPF: </label>
        <input type="text" name="cpf" id="cpf" placeholder="CPF" value="<?php if(isset($dados['cpf'])){ echo $dados['cpf']; } ?>"><br><br>
        
        <label>Data Aniversário: </label>
        <input type="text" name="dataAniversario" id="dataAniversario" placeholder="Data Aniversário" value="<?php if(isset($dados['dataAniversario'])){ echo $dados['dataAniversario']; } ?>"><br><br>
        
        <label>Profissâo: </label>
        <input type="text" name="profissao" id="profissao" placeholder="Profissao" value="<?php if(isset($dados['profissao'])){ echo $dados['profissao']; } ?>"><br><br>
        
        <label>Email: </label>
        <input type="email" name="email" id="email" placeholder="Email" value="<?php if(isset($dados['email'])){ echo $dados['email']; } ?>"><br><br>
        
        <label>Fale Sobre Você: </label>
        <input type="text" name="faleSobreVoce" id="faleSobreVoce" placeholder="Fale Sobre Você" value="<?php if(isset($dados['faleSobreVoce'])){ echo $dados['faleSobreVoce']; } ?>"><br><br>
        
        <label>Telefone: </label>
        <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?php if(isset($dados['telefone'])){ echo $dados['telefone']; } ?>"><br><br>

        <input type="submit" value="Cadastrar" name="CadUser">
    </form>

</body>
</html>
