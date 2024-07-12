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


        if(!$empty_input){
            $query_usuario = "INSERT INTO usuarios (nome,email) VALUES (:nome, :email)";
            $cad_usuario = $conn->prepare($query_usuario);
    
            $cad_usuario->bindParam(':nome',$dados['nome'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':email',$dados['email'], PDO::PARAM_STR);
            $cad_usuario ->execute();
            if($cad_usuario->rowCount()){
                 unset($dados);
                $_SESSION['msg'] = "Usuário cadastrado com sucesso</p>";
                header("location: listar.php");
            }else{
                echo "Erro"; 
            }
        }
    }
    ?>

    <form name="Cad-usuario" method="post" action="">
        <label>Nome: </label>
        <input type="text" name="nome" id="nome" placeholder="Nome" value=

        "<?php if(isset($dados['nome'])){
            echo $dados['nome'];

        }
        ?>"><br><br>

        <label>Email: </label>
        <input type="email" name="email" id="email" placeholder="Email" value=

        "<?php if(isset($dados['email'])){
            echo $dados['email'];

        }
        ?>"><br><br>

        <input type="submit" value="Cadastrar" name="CadUser">
    </form>

</body>
</html>

<!-- Acesso ao banco de dados
    1- localhost/phpmyadmin
    2- utilizador: root servidor: mysql
    3- Criar banco de dados utf8mb4_unicode_ci
    4- Colunas - primeira: coluna id - int - PRIMARY - marque a caixinha A_I
    outras colunas de acordo com o que estiver no projeto ex: nome,email
    para nome temos: varchar, tamanho valores: 220 caracteres.
    5- depois disso, selecione innoDB para fazer o relacionamento de chave primaria com a chave estrangeira
    6 - Criar um arquivo chamado conexão
-->