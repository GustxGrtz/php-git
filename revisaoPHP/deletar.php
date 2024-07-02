<?php 
session_start();
include_once './conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
    header("Location: listar.php");
    exit();
}

// Verificar se o usuário existe no banco de dados
$query_check_user = "SELECT id FROM usuarios WHERE id = :id LIMIT 1";
$check_user = $conn->prepare($query_check_user);
$check_user->bindParam(':id', $id, PDO::PARAM_INT);
$check_user->execute();

if ($check_user->rowCount() > 0) {
    // Preparar e executar a consulta SQL para deletar o usuário
    $query_delete = "DELETE FROM usuarios WHERE id = :id";
    $delete_usuario = $conn->prepare($query_delete);
    $delete_usuario->bindParam(':id', $id, PDO::PARAM_INT);

    if ($delete_usuario->execute()) {
        $_SESSION['msg'] = "<p style='color: #0f0;'>Usuário excluído com sucesso</p>";
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Falha ao excluir usuário</p>";
    }
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
}

header("Location: listar.php");
exit();
?>
