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
            background-color: #3c3c3c;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 900px;
            width: 100%;
            text-align: left;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }


        h2,
        h3,
        h4 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 3px;
            color: white;
            font-weight: bold;
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
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .bateria {
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #3c3c3c;
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
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .bateria label {
            display: inline-block;
            margin-top: 10px;
        }

        .meu-botao {
            background-color: #b5b5b5;
            /* fundo escuro */
            color: white;
            /* texto escuro */
            border: 1px solid black;
            /* borda escuro */
            border-radius: 8px;
            margin-bottom: 10px;
            /* Adiciona o espaço desejado na parte inferior */
            font-size: 12px;
            padding: 10px 8px;
            /* Aumenta o espaçamento interno do botão (vertical e horizontal) */
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            width: fit-content;
            /* ⚠️ Faz o botão ter o tamanho do conteúdo */
            margin-left: 0;
            /* ⚠️ Ajuste isso para o quanto quiser mover para a direita */

        }

        .meu-botao:hover {
            background-color: #8c8c8c;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .meu-botao:active {
            transform: translateY(4px);
        }

        #btnAtualizar {
            background-color: #8c8c8c;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            color: white;
            font-weight: bold;
        }

        #btnAtualizar:hover {
            background-color: #b5b5b5;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        #btnAtualizar:active {
            transform: translateY(4px);
        }

        .btn-excluir {
            background-color: #d9534f;
            color: white;
            border: 1px solid black;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2),
                0 6px 20px 0 rgba(0, 0, 0, 0.19);
            cursor: pointer;
        }

        .btn-excluir:hover {
            background-color: #c9302c;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24),
                0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        .btn-excluir:active {
            transform: translateY(4px);
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

        <button class="meu-botao" onclick="window.location.href='/sistema-garantias/frontend/views/consultar_lancamentos.php'">
            Voltar para consulta
        </button>



        <h2>Editar Lançamento <?= $id ?></h2>

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
            <button type="submit" class="btn-excluir">
                Excluir Lançamento
            </button>

        </form>


    </div>

</body>

</html>