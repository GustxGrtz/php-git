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
    <title>Document</title>
</head>
<body>
    <a href="listar.php">Listar</a><br>
    <a href="cadastrar.php">Cadastrar</a><br>
    <h1>Cadastrar</h1>
    <?php 
    //receber os campos em metodo post e filter default: recebe tudo como texto
    $dados = filter_INPUT_array(INPUT_POST,FILTER_DEFAULT);

    
    if(!empty($dados['CadUser'])){
        //var_dump($dados);

        //VERIFICAÇÃO INPUT VAZIO EM PHP
        $empty_input = false;
        $dados = array_map('trim',$dados);
        if(in_array("", $dados)){
            $empty_input = true;
            echo "<p style = 'color:#f00;'>Erro: Necessário preencher todos os campos</p>";
            //elseif para verificar se tem caracteristicas de email
        }elseif(!filter_var($dados['email'],FILTER_VALIDATE_EMAIL)){
            $empty_input = true;
            echo "<p style='color: #f00;'>Erro: Necessário um email válido</p>";
        }


        if(!$empty_input){
            $query_usuario = "INSERT INTO usuarios (nome,email) VALUES (:nome, :email)";
            $cad_usuario = $conn->prepare($query_usuario);
    
            $cad_usuario->bindParam(':nome',$dados['nome'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':email',$dados['email'], PDO::PARAM_STR);
            $cad_usuario ->execute();
            //se conseguiu cadastrar vai dar esse aviso
            if($cad_usuario->rowCount()){
                 //destroi o if de deixar o valor no campó assim que cadastrar
                 unset($dados);
                $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!<br></p>";
                header("location: listar.php");
            }else{
                echo "Houve algum erro<br>"; 
            }
        }
       //TÉRMINO DA VERIFICAÇÃO 
    }
    ?>
    <!-- PARA DEIXAR OS DADOS NO INPUT -->
    <form name="Cad-usuario" method="post" action="">
        <label>Nome: </label>
        <input type="text" name="nome" id="nome" placeholder="Nome Completo" value=

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





    <!-- VALIDAÇÃO PARA CAMPO VAZIO EM JAVA SCRIPT
    <script>
        document.forms['Cad-usuario'].addEventListener('submit', function(event) {
            var nome = document.getElementById('nome').value;
            var email = document.getElementById('email').value;
            if (nome === '' || email === '') {
                alert('Os campos Nome e Email não podem estar vazios.');
                event.preventDefault(); // Impede o envio do formulário
            }
        });
    </script> -->
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