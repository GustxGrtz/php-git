<?php 

try{
    $conn = new PDO('mysql:host=localhost;dbname=php', 'root', 'positivo');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $erro)
{
    echo "ERRO => " . $erro->getMessage();
}

?>
