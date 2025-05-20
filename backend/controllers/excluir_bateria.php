<?php
session_start();
include(__DIR__ . "/../includes/conexao.php");

// Verifica se o ID da bateria foi enviado via POST
if (isset($_POST['id_bateria'])) {
    $id_bateria = intval($_POST['id_bateria']);

    // Deleta a bateria com o ID fornecido
    $sql = "DELETE FROM baterias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_bateria);
    
    if ($stmt->execute()) {
        // Se a exclusão for bem-sucedida, redireciona para a página de consulta de lançamentos
        header("Location: ../../frontend/views/consultar_lancamentos.php");
        exit;
    } else {
        // Se ocorrer um erro na exclusão
        echo "Erro ao excluir a bateria.";
    }
} else {
    echo "ID da bateria não informado.";
}
?>
