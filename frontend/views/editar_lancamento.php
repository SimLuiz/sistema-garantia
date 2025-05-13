<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: ../../login.html");
    exit;
}

include(__DIR__ . '/../../backend/includes/conexao.php');

$id = $_GET['id'];
$sql = "SELECT * FROM lancamentos WHERE id = $id";
$res = $conn->query($sql);
$lancamento = $res->fetch_assoc();

// Buscar nome do cliente a partir do ID
$cliente_id = $lancamento['cliente_id'] ?? null;

if ($cliente_id) {
    $sql_cliente = "SELECT nome FROM cliente WHERE id = $cliente_id";
    $res_cliente = $conn->query($sql_cliente);
    $cliente = $res_cliente->fetch_assoc();
    $nome_cliente = $cliente['nome'] ?? 'Desconhecido';
} else {
    $nome_cliente = 'Não informado';
}

$sql_cliente = "SELECT nome FROM cliente WHERE id = $cliente_id";
$res_cliente = $conn->query($sql_cliente);
$cliente = $res_cliente->fetch_assoc();

// Buscar baterias vinculadas
$sql_bat = "SELECT * FROM baterias WHERE id_lancamento = $id";
$res_bat = $conn->query($sql_bat);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/sistema-garantias/frontend/css/estilo.css">
    <title>Editar Lançamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #666666;
        }

        .container {
            position: relative;
            background-color: #b5b5b5;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 800px;
            width: 100%;
            text-align: left;
        }


        h2,
        h3,
        h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"],
        input[type="date"] {
            padding: 8px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #b5b5b5;
            /* fundo escuro */
            color: black;
            /* texto escuro */
            border: 1px solid black;
            /* borda escuro */
            align-items: flex-start;
            /* alinha os elementos à esquerda */

        }

        input[type="submit"] {
            background-color: #b5b5b5;
            color: black;
            /* texto escuro */
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            border: 1px solid black;
            /* borda escuro */
        }


        input[type="submit"]:hover {
            background-color: #8c8c8c;
        }

        .bateria {
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #b5b5b5;
            border-radius: 8px;
            border: 1px solid black;
            /* borda escuro */
        }

        .bateria input {
            background-color: #b5b5b5;
            /* fundo escuro */
            color: black;
            /* texto escuro */
            margin: 5px 0;
            border: 1px solid black;
            /* borda escuro */
        }

        input:hover {
            background-color: #8c8c8c;
        }

        .bateria label {
            display: inline-block;
            margin-top: 10px;
        }

        .meu-botao {
            background-color: #b5b5b5;
            /* fundo escuro */
            color: black;
            /* texto escuro */
            border: 1px solid black;
            /* borda escuro */
            border-radius: 8px;
            margin-bottom: 10px;
            /* Adiciona o espaço desejado na parte inferior */
            font-size: 12px;
            padding: 10px 10px;
            /* Aumenta o espaçamento interno do botão (vertical e horizontal) */
        }

        .meu-botao:hover {
            background-color: #8c8c8c;
        }

        #btnAtualizar {
            background-color: #8c8c8c;
        }

        #btnAtualizar:hover {
            background-color: #b5b5b5;
        }


        /* Responsivo */
        @media screen and (max-width: 768px) {
            .container {
                padding: 15px;
            }

            input[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <a href="/sistema-garantias/frontend/views/consultar_lancamentos.php" class="meu-botao">
            ← Voltar para Consultar Lançamentos
        </a>



        <h2>Editar Lançamento #<?= $id ?></h2>

        <form action="/sistema-garantias/backend/controllers/atualizar_lancamento.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">

            <label>Estado:</label><br>
            <input type="text" name="estado" value="<?= $lancamento['estado'] ?>" required><br>

            <label>Cidade:</label><br>
            <input type="text" name="cidade" value="<?= $lancamento['cidade'] ?>" required><br>

            <label>Cliente:</label><br>
            <input type="text" value="<?= $nome_cliente ?>" disabled><br>
            <input type="hidden" name="cliente_id" value="<?= $cliente_id ?>">

            <label>Data da Coleta:</label><br>
            <input type="date" name="data_coleta" value="<?= $lancamento['data_coleta'] ?>" required><br><br>

            <h3>Baterias</h3>
            <?php while ($bat = $res_bat->fetch_assoc()): ?>
                <div class="bateria">
                    <input type="hidden" name="baterias[<?= $bat['id'] ?>][id]" value="<?= $bat['id'] ?>">
                    Modelo: <input type="text" name="baterias[<?= $bat['id'] ?>][modelo]" value="<?= $bat['modelo'] ?>"><br>
                    Código: <input type="text" name="baterias[<?= $bat['id'] ?>][codigo]" value="<?= $bat['codigo'] ?>"><br>
                    Rótulo: <input type="text" name="baterias[<?= $bat['id'] ?>][rotulo]" value="<?= $bat['rotulo'] ?>"><br>
                    <label><input type="checkbox" name="baterias[<?= $bat['id'] ?>][excluir]"> Excluir esta bateria</label>
                </div>
            <?php endwhile; ?>

            <h4>Adicionar nova bateria:</h4>
            <div class="bateria">
                Modelo: <input type="text" name="nova_bateria[modelo]"><br>
                Código: <input type="text" name="nova_bateria[codigo]"><br>
                Rótulo: <input type="text" name="nova_bateria[rotulo]"><br>
            </div>

            <br><input type="submit" value="Atualizar Lançamento" id="btnAtualizar">
        </form>
        <form action="/sistema-garantias/backend/controllers/excluir_lancamento.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este lançamento? Esta ação é irreversível.');">
            <input type="hidden" name="id_lancamento" value="<?= $id ?>">
            <input type="submit" value="Excluir Lançamento" style="background-color: #d9534f; color: white; border: 1px solid black; padding: 10px; border-radius: 5px; font-weight: bold; margin-top: 10px;">
        </form>


    </div>

</body>

</html>