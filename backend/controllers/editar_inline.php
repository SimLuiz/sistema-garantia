<?php
session_start();
include(__DIR__ . "/../includes/conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Editando dados do lançamento
    if (isset($_POST['estado'])) {
        $id_lancamento = intval($_POST['id_lancamento']);
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $data_coleta = $_POST['data_coleta'];

        // Atualiza o lançamento
        $sql = "UPDATE lancamentos SET estado = ?, cidade = ?, data_coleta = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $estado, $cidade, $data_coleta, $id_lancamento);
        if (!$stmt->execute()) {
            echo "Erro ao atualizar o lançamento.";
        }
    }

    // Editando dados da bateria
    if (isset($_POST['modelo']) && isset($_POST['codigo'])) {
        $id_bateria = intval($_POST['id_bateria']);
        $modelo = $_POST['modelo'];
        $codigo = $_POST['codigo'];
        $rotulo = $_POST['rotulo'];

        // Atualiza a bateria
        $sql_bateria = "UPDATE baterias SET modelo = ?, codigo = ?, rotulo = ? WHERE id = ?";
        $stmt_bateria = $conn->prepare($sql_bateria);
        $stmt_bateria->bind_param("sssi", $modelo, $codigo, $rotulo, $id_bateria);
        if (!$stmt_bateria->execute()) {
            echo "Erro ao atualizar a bateria.";
        }
    }

    // Redireciona de volta para a página de consulta de lançamentos
    header("Location: ../../frontend/views/consultar_lancamentos.php");
    exit;
}
?>
