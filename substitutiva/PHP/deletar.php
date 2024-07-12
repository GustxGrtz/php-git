<?php 
session_start();
include_once './conexao.php';

$idFornecedor = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($idFornecedor)) {
    $_SESSION['msg'] = "fornecedor não encontrado</p>";
    header("Location: listar.php");
    exit();
}

$query_check_user = "SELECT idFornecedor FROM prova_final WHERE idFornecedor = :id LIMIT 1";
$check_user = $conn->prepare($query_check_user);
$check_user->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
$check_user->execute();

if ($check_user->rowCount() > 0) {
    $query_delete = "DELETE FROM prova_final WHERE idFornecedor = :id";
    $delete_fornecedor = $conn->prepare($query_delete);
    $delete_fornecedor->bindParam(':id', $idFornecedor, PDO::PARAM_INT);

    if ($delete_fornecedor->execute()) {
        $_SESSION['msg'] = "fornecedor excluído com sucesso</p>";
    } else {
        $_SESSION['msg'] = "Falha ao excluir fornecedor</p>";
    }
} else {
    $_SESSION['msg'] = "fornecedor não encontrado";
}

header("Location: listar.php");
exit();
?>
