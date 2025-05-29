<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . "/../../backend/includes/conexao.php");

if (isset($_POST['id_lancamento'])) {
    $id_lancamento = (int) $_POST['id_lancamento'];
    $usuario_id = $_SESSION['usuario_id'] ?? null;

    if (!$usuario_id) {
        $_SESSION['msg_erro'] = "Usuário não identificado.";
        header("Location: ../../frontend/views/consultar_lancamentos.php");
        exit;
    }

    // Registrar exclusão no log
    $sql_log = "INSERT INTO log_exclusoes (id_lancamento, usuario_id) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql_log)) {
        $stmt->bind_param("ii", $id_lancamento, $usuario_id);
        $stmt->execute();
        $stmt->close();
    }

    // Excluir baterias associadas ao lançamento
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

    $_SESSION['msg_sucesso'] = 'Lançamento excluído com sucesso!';
    header("Location: ../../frontend/views/consultar_lancamentos.php?status=sucesso");
    exit;
} else {
    header("Location: ../../frontend/views/consultar_lancamentos.php");
    exit;
}
