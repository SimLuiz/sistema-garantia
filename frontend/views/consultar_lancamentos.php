<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . "/../../backend/includes/conexao.php");

// Pega o tipo e id do usuário logado da sessão
$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'motorista'; // default para motorista
$id_usuario = $_SESSION['usuario_id'] ?? 0;

// Monta o filtro inicial considerando o tipo de usuário
$where = [];
if ($tipo_usuario !== 'admin') {
    $where[] = "l.usuario_id = $id_usuario";
}

// Filtros da consulta
if (!empty($_GET['cliente'])) {
    $cliente = $conn->real_escape_string($_GET['cliente']);
    $where[] = "c.nome LIKE '%$cliente%'";
}
if (!empty($_GET['cidade'])) {
    $cidade = $conn->real_escape_string($_GET['cidade']);
    $where[] = "l.cidade LIKE '%$cidade%'";
}
if (!empty($_GET['data_ini'])) {
    $ini = $conn->real_escape_string($_GET['data_ini']);
    $where[] = "l.data_coleta >= '$ini'";
}
if (!empty($_GET['data_fim'])) {
    $fim = $conn->real_escape_string($_GET['data_fim']);
    $where[] = "l.data_coleta <= '$fim'";
}

$filtro = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT l.*, c.nome AS nome_cliente, u.usuario AS nome_usuario 
        FROM lancamentos l 
        JOIN cliente c ON l.cliente_id = c.id 
        JOIN usuarios u ON l.usuario_id = u.id 
        $filtro 
        ORDER BY l.criado_em DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../sistema-garantias/frontend/css/estilo.css">
    <title>Consulta de Lançamentos</title>

    <style>
        body {
            background-color: #666666;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: white;
        }

        .filtros {
            background-color: #3c3c3c;
            /* fundo escuro */
            color: white;
            /* texto escuro */
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
        }

        a {
            background-color: #b5b5b5;
            /* fundo escuro */
            color: black;
            /* texto escuro */
            border: 1px solid black;
            /* borda escuro */
            border-radius: 8px;
            margin-bottom: 10px;
            /* Adiciona o espaço desejado na parte inferior */
            font-size: 15px;
            padding: 10px 20px;
            /* Aumenta o espaçamento interno do botão (vertical e horizontal) */
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        a:hover {
            background-color: #8c8c8c;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        a:active {
            transform: translateY(4px);
        }

        input,
        select {
            padding: 5px;
            margin: 5px;
        }

        table {
            background-color: #3c3c3c;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            color: white;
            font-weight: bold;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3c3c3c;
        }

        tr:nth-child(even) {
            background-color: #3c3c3c;
        }

        .actions {
            text-align: center;
        }

        .actions a,
        .actions form input[type="submit"] {
            padding: 10px 20px;
            background-color: #b5b5b5;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            margin: 0 5px;
            border-radius: 5px;
            border: 1px solid black;
            /* borda escuro */
            margin-bottom: 10px;
        }

        .actions a:hover,
        .actions form input[type="submit"]:hover {
            background-color: #8c8c8c;
        }

        .actions form {
            display: inline;
        }

        .actions a:active {
            transform: translateY(4px);
        }

        /* Estilo para o formulário de edição de baterias */
        .edit-battery-form {
            margin-top: 10px;
            /* Espaçamento entre as baterias */
            background-color: #666666;
            padding: 10px;
            border-radius: 8px;
        }

        .edit-battery-form input {
            margin: 5px;
            padding: 5px;
        }

        .edit-battery-form:active {
            transform: translateY(1px);

        }

        .popup {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #3c3c3c;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
            font-weight: bold;
        }

        .btn-voltar {
            background-color: #b5b5b5;
            color: white;
            border: 1px solid black;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 16px;
            padding: 10px 8px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            cursor: pointer;
            font-weight: bold;
        }

        .btn-voltar:hover {
            background-color: #8c8c8c;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24),
                0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .btn-voltar:active {
            transform: translateY(4px);
        }

        .btn-limpar {
            background-color: #b5b5b5;
            color: white;
            border: 1px solid black;
            border-radius: 8px;
            padding: 10px 8px;
            font-size: 12px;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
            font-weight: bold;
            width: 100px;
        }

        .btn-limpar:hover {
            background-color: #8c8c8c;
            box-shadow: 0 12px 16px rgba(0, 0, 0, 0.24),
                0 17px 50px rgba(0, 0, 0, 0.19);
        }

        .btn-limpar:active {
            transform: translateY(4px);
        }

        .btn-editar {
            background-color: #b5b5b5;
            color: white;
            border: 1px solid black;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 12px;
            cursor: pointer;
            margin-right: 5px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
            font-weight: bold;
            width: 100px;
        }

        .btn-editar:hover {
            background-color: #8c8c8c;
            box-shadow: 0 12px 16px rgba(0, 0, 0, 0.24),
                0 17px 50px rgba(0, 0, 0, 0.19);
        }

        .btn-editar:active {
            transform: translateY(4px);
        }


        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <?php if (isset($_SESSION['msg_sucesso'])): ?>
            <div id="popup-msg" class="popup">
                <?= $_SESSION['msg_sucesso']; ?>
            </div>
            <script>
                // Fecha o popup automaticamente após 3 segundos
                setTimeout(() => {
                    const popup = document.getElementById('popup-msg');
                    if (popup) popup.style.display = 'none';
                }, 3000);
            </script>
            <?php unset($_SESSION['msg_sucesso']); ?>
        <?php endif; ?>


        <button type="button" class="btn-voltar" onclick="window.location.href='painel.php'">
            Voltar ao painel
        </button><br><br>

        <h2>Consulta de Lançamentos</h2>


        <div class="filtros">
            <form method="GET" action="consultar_lancamentos.php">
                Cliente: <input type="text" name="cliente" value="<?= $_GET['cliente'] ?? '' ?>">
                Cidade: <input type="text" name="cidade" value="<?= $_GET['cidade'] ?? '' ?>">
                Data Início: <input type="date" name="data_ini" value="<?= $_GET['data_ini'] ?? '' ?>">
                Data Fim: <input type="date" name="data_fim" value="<?= $_GET['data_fim'] ?? '' ?>">
                <input type="submit" value="Filtrar">
                <button type="button" class="btn-limpar" onclick="window.location.href='consultar_lancamentos.php'">
                    Limpar
                </button>

            </form>
        </div>

        <?php
        if ($result->num_rows > 0) {
            // Exibe os lançamentos encontrados

            while ($row = $result->fetch_assoc()) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Registro</th>";
                echo "<th>Usuario</th>";
                echo "<th>Cliente</th>";
                echo "<th>Estado/Cidade</th>";
                echo "<th>Data da Coleta</th>";
                echo "<th>Registrado em</th>";
                echo "<th>Ações</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['nome_usuario']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nome_cliente']) . "</td>";
                echo "<td>" . $row['estado'] . " / " . $row['cidade'] . "</td>";
                echo "<td>" . date("d/m/Y", strtotime($row['data_coleta'])) . "</td>";
                echo "<td>" . date("d/m/Y H:i", strtotime($row['criado_em'])) . "</td>";
                echo "<td class='actions'>";

                // Botão de edição
                echo "<button type='button' class='btn-editar' onclick=\"window.location.href='editar_lancamento.php?id=" . $row['id'] . "'\">✏️ Editar</button>";
                echo "</form>";

                echo "</td>";
                echo "</tr>";

                // Consulta baterias desse lançamento
                $id_lanc = $row['id'];
                $sql_baterias = "SELECT * FROM baterias WHERE id_lancamento = $id_lanc";
                $res_bat = $conn->query($sql_baterias);

                if ($res_bat->num_rows > 0) {
                    while ($bat = $res_bat->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td colspan='6'>";
                        echo "<strong>Baterias:</strong> " . $bat['modelo'] . " | Código: " . $bat['codigo'] . " | Rótulo: " . $bat['rotulo'];

                        // Formulário para edição do modelo de bateria
                        echo "<div class='edit-battery-form'>";
                        echo "<form method='POST' action='/sistema-garantias/backend/controllers/editar_bateria.php' style='display:inline-block; margin-right: 10px;'>";
                        echo "<input type='hidden' name='id_bateria' value='" . $bat['id'] . "'>";
                        echo "Modelo: <input type='text' name='modelo' value='" . $bat['modelo'] . "' required>";
                        echo "Código: <input type='text' name='codigo' value='" . $bat['codigo'] . "' required>";
                        echo "Rótulo: <input type='text' name='rotulo' value='" . $bat['rotulo'] . "' required>";
                        echo "<input type='submit' value='🖊️ Editar'>";
                        echo "</form>";

                        // Botão excluir ao lado do editar
                        echo "<form method='POST' action='../../backend/controllers/excluir_bateria_individual.php' onsubmit='return confirm(\"Tem certeza que deseja excluir esta bateria?\")' style='display:inline-block;'>";
                        echo "<input type='hidden' name='id_bateria' value='" . $bat['id'] . "'>";
                        echo "<input type='submit' value='❌ Excluir Bateria'>";
                        echo "</form>";

                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'><em>Nenhuma bateria cadastrada.</em></td></tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Nenhum lançamento encontrado.</p>";
        }
        ?>

    </div>

</body>

</html>