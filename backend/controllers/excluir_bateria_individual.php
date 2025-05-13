<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . "/../../backend/includes/conexao.php");

if (isset($_POST['id_bateria'])) {
    $id_bateria = $_POST['id_bateria'];

    if ($id_bateria) {
        // Preparar a consulta SQL para excluir a bateria
        $sql = "DELETE FROM baterias WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_bateria);

        // Executar a consulta
        if ($stmt->execute()) {
            $_SESSION['msg_sucesso'] = "Bateria excluída com sucesso!";
        } else {
            $_SESSION['msg_erro'] = "Erro ao excluir a bateria: " . $stmt->error; // Capturando erro do MySQL
        }

        $stmt->close();
    } else {
        $_SESSION['msg_erro'] = "ID da bateria não foi fornecido corretamente.";
    }
} else {
    $_SESSION['msg_erro'] = "Nenhum ID de bateria foi passado.";
}

// Redirecionar de volta à página de consulta
header("Location: /sistema-garantias/frontend/views/consultar_lancamentos.php");
exit;
?>
