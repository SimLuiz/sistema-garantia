<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . "/../includes/conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_bateria = $_POST['id_bateria'];
    $modelo = $conn->real_escape_string($_POST['modelo']);
    $codigo = $conn->real_escape_string($_POST['codigo']);
    $rotulo = $conn->real_escape_string($_POST['rotulo']);

    $sql = "UPDATE baterias 
            SET modelo = '$modelo', 
                codigo = '$codigo', 
                rotulo = '$rotulo' 
            WHERE id = $id_bateria";

    if ($conn->query($sql)) {
        $_SESSION['msg_sucesso'] = "Bateria atualizada com sucesso!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Erro ao atualizar bateria: " . $conn->error;
    }
} else {
    echo "Requisição inválida.";
}
?>
