<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . '/../includes/conexao.php');

$id = $_POST['id'];
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
$data = $_POST['data_coleta'];

// Atualizar o lançamento
$stmt = $conn->prepare("UPDATE lancamentos SET estado=?, cidade=?, cliente_id=?, data_coleta=? WHERE id=?");
$stmt->bind_param("ssssi", $estado, $cidade, $cliente_id, $data, $id);
$stmt->execute();

// Atualizar ou excluir baterias
if (isset($_POST['baterias'])) {
    foreach ($_POST['baterias'] as $id_bat => $bat) {
        if (isset($bat['excluir'])) {
            $conn->query("DELETE FROM baterias WHERE id=$id_bat");
        } else {
            $stmt_b = $conn->prepare("UPDATE baterias SET modelo=?, codigo=?, rotulo=? WHERE id=?");
            $stmt_b->bind_param("sssi", $bat['modelo'], $bat['codigo'], $bat['rotulo'], $id_bat);
            $stmt_b->execute();
        }
    }
}

// Adicionar nova bateria (se preenchida)
if (!empty($_POST['nova_bateria']['modelo']) && !empty($_POST['nova_bateria']['codigo'])) {
    $nova = $_POST['nova_bateria'];
    $stmt_nova = $conn->prepare("INSERT INTO baterias (id_lancamento, modelo, codigo, rotulo) VALUES (?, ?, ?, ?)");
    $stmt_nova->bind_param("isss", $id, $nova['modelo'], $nova['codigo'], $nova['rotulo']);
    $stmt_nova->execute();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Sucesso</title>
    <style>
        /*design para pagina atualiza*/
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            background-color: #666666;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #b5b5b5;
            color: black;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border: 1px solid black;

        }

        h2 {
            color: #2c3e50;
        }

        p {
            color: #444;
        }

        .btn-voltar {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #8c8c8c;
            color: black;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
            border: 1px solid black;

        }

        .btn-voltar:hover {
            background-color: #b5b5b5;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 10px;
            }

            input,
            select,
            textarea,
            button {
                font-size: 15px;
                padding: 10px;
            }

            button {
                width: 100%;
                margin-bottom: 10px;
            }

            .card {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            input,
            select,
            textarea,
            button {
                font-size: 14px;
            }

            .card {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Lançamento atualizado com sucesso!</h2>
        <p>As informações foram alteradas no sistema.</p>
        <a class="btn-voltar" href="/sistema-garantias/frontend/views/consultar_lancamentos.php">Voltar a consulta de lançamentos</a>
    </div>
</body>

</html>