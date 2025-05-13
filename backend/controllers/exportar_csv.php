<?php
session_start();
include(__DIR__ . '/../includes/conexao.php');

// Definir a codificação de caracteres para UTF-8
$conn->set_charset('utf8mb4');

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: ../../login.php");
    exit();
}

// Cabeçalhos para exportação
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="garantias_baterias.csv"');

// Abrir o arquivo de saída
$output = fopen('php://output', 'w');

// Escrever a linha de cabeçalho (títulos das colunas)
fputcsv($output, array('Estado', 'Cidade', 'Nome do Cliente', 'Modelo da Bateria', 'Código da Bateria', 'Rótulo da Bateria', 'Data de Coleta'));

// Consulta SQL para obter os lançamentos
$sql = "SELECT * FROM lancamentos";  // Ajuste conforme sua tabela de lançamentos
$result = $conn->query($sql);

// Escrever os dados dos lançamentos no CSV
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Verifique se cada chave existe antes de usá-la
        $estado = isset($row['estado']) ? $row['estado'] : '';
        $cidade = isset($row['cidade']) ? $row['cidade'] : '';
        $nome_cliente = isset($row['nome_cliente']) ? $row['nome_cliente'] : '';
        $modelo_bateria = isset($row['modelo_bateria']) ? $row['modelo_bateria'] : '';
        $codigo_bateria = isset($row['codigo_bateria']) ? $row['codigo_bateria'] : '';
        $rotulo_bateria = isset($row['rotulo_bateria']) ? $row['rotulo_bateria'] : '';
        $data_coleta = isset($row['data_coleta']) ? $row['data_coleta'] : '';

        // Escrever os dados no CSV
        fputcsv($output, array($estado, $cidade, $nome_cliente, $modelo_bateria, $codigo_bateria, $rotulo_bateria, $data_coleta));
    }
}

// Fechar o arquivo
fclose($output);
?>
