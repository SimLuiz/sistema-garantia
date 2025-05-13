<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . "/../../backend/includes/conexao.php");

if (isset($_POST['id_lancamento'])) {
    $id_lancamento = (int) $_POST['id_lancamento'];

    // Excluir as baterias associadas ao lançamento
    $sql_baterias = "DELETE FROM baterias WHERE id_lancamento = ?";
    if ($stmt = $conn->prepare($sql_baterias)) {
        $stmt->bind_param("i", $id_lancamento);
        $stmt->execute();
        $stmt->close();
    }

    // Excluir o lançamento
    $sql_lancamento = "DELETE FROM lancamentos WHERE id = ?";
    if ($stmt = $conn->prepare($sql_lancamento)) {
        $stmt->bind_param("i", $id_lancamento);
        $stmt->execute();
        $stmt->close();
    }

    // Definir a mensagem de sucesso na sessão
    $_SESSION['msg_sucesso'] = 'Lançamento excluído com sucesso!';

    // Redirecionar de volta para a consulta de lançamentos
    header("Location: ../../frontend/views/consultar_lancamentos.php?status=sucesso");
    exit;
} else {
    // Se o ID do lançamento não foi passado, redirecionar de volta
    header("Location: ../../frontend/views/consultar_lancamentos.php");
    exit;
}
