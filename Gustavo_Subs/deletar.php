<?php 
session_start();
include_once './conexao.php';

$idCliente = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($idCliente)) {
    $_SESSION['msg'] = "Cliente não encontrado</p>";
    header("Location: listar.php");
    exit();
}

$query_check_user = "SELECT idCliente FROM prova_subs WHERE idCliente = :id LIMIT 1";
$check_user = $conn->prepare($query_check_user);
$check_user->bindParam(':id', $idCliente, PDO::PARAM_INT);
$check_user->execute();

if ($check_user->rowCount() > 0) {
    $query_delete = "DELETE FROM prova_subs WHERE idCliente = :id";
    $delete_cliente = $conn->prepare($query_delete);
    $delete_cliente->bindParam(':id', $idCliente, PDO::PARAM_INT);

    if ($delete_cliente->execute()) {
        $_SESSION['msg'] = "Cliente excluído com sucesso</p>";
    } else {
        $_SESSION['msg'] = "Falha ao excluir cliente</p>";
    }
} else {
    $_SESSION['msg'] = "Cliente não encontrado";
}

header("Location: listar.php");
exit();
?>
