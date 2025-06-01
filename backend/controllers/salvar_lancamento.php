<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . '/../includes/conexao.php');

// Pega os dados principais
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$cliente_nome = trim($_POST['cliente_nome']);
$data_coleta = $_POST['data_coleta'];
$usuario_id = $_SESSION['usuario_id']; // <- ID do usuário logado


// Verifica se o cliente já existe
$stmt = $conn->prepare("SELECT id FROM cliente WHERE nome = ?");
$stmt->bind_param("s", $cliente_nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Cliente já existe
    $cliente = $result->fetch_assoc();
    $cliente_id = $cliente['id'];
} else {
    // Cliente não existe, então insere
    $stmt = $conn->prepare("INSERT INTO cliente (nome, estado, cidade) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $cliente_nome, $estado, $cidade);
    $stmt->execute();
    $cliente_id = $stmt->insert_id;
}

// Inserir o lançamento principal com o cliente_id
$stmt = $conn->prepare("INSERT INTO lancamentos (cliente_id, estado, cidade, data_coleta, usuario_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isssi", $cliente_id, $estado, $cidade, $data_coleta, $usuario_id);
$stmt->execute();

// Pega o ID do lançamento recém criado
$id_lancamento = $stmt->insert_id;

// Inserir baterias
$baterias = $_POST['baterias'];

foreach ($baterias as $bateria) {
    $modelo = $bateria['modelo'];
    $codigo = $bateria['codigo'];
    $rotulo = $bateria['rotulo'];

    $stmt_bat = $conn->prepare("INSERT INTO baterias (id_lancamento, modelo, codigo, rotulo) VALUES (?, ?, ?, ?)");
    $stmt_bat->bind_param("isss", $id_lancamento, $modelo, $codigo, $rotulo);
    $stmt_bat->execute();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Sucesso</title>
    <style>
        /*design para pagina salva_lancamento*/
        body {
            background-color: #666666;
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #3c3c3c;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        h2 {
            color: #fff;
        }

        p {
            color: #fff;
        }

        .btn-voltar {
            display: inline-block;
            background-color: #b5b5b5;
            /* fundo escuro */
            color: white;
            /* texto escuro */
            margin-top: 20px;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid black;
            /* borda escuro */
            transition: background-color 0.3s ease;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            font-weight: bold;
        }

        .btn-voltar:hover {
            background-color: #8c8c8c;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .btn-voltar:active {
            transform: translateY(4px);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Lançamento salvo com sucesso!</h2>
        <p>As informações foram registradas no sistema.</p>
        <a class="btn-voltar" href="/sistema-garantias/frontend/views/painel.php">Voltar ao painel</a>
    </div>
</body>

</html>