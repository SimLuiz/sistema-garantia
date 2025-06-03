<?php
session_start();
include(__DIR__ . "/conexao.php");

$usuario = $_POST['usuario'];
$senhaDigitada = $_POST['senha']; // senha em texto plano

// Buscar usuário pelo nome
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

// Se encontrou o usuário
if ($result->num_rows === 1) {
    $dados_usuario = $result->fetch_assoc();

    $hashArmazenado = $dados_usuario['senha'];

    // Se for hash do password_hash
    if (password_verify($senhaDigitada, $hashArmazenado)) {
        // Login OK
    }
    // Se ainda for senha em md5
    elseif (strlen($hashArmazenado) === 32 && md5($senhaDigitada) === $hashArmazenado) {
        // Atualiza para password_hash
        $novoHash = password_hash($senhaDigitada, PASSWORD_DEFAULT);
        $stmtUpdate = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmtUpdate->bind_param("si", $novoHash, $dados_usuario['id']);
        $stmtUpdate->execute();
        // Login OK
    } else {
        // Senha incorreta
        mostrarTelaErroLogin();
        exit;
    }

    // Login bem-sucedido
    $_SESSION['logado'] = true;
    $_SESSION['usuario_id'] = $dados_usuario['id'];
    $_SESSION['tipo_usuario'] = $dados_usuario['tipo'];
    $_SESSION['usuario'] = $dados_usuario['usuario'];
    $_SESSION['login_sucesso'] = true;

    header("Location: /sistema-garantias/frontend/views/painel.php");
    exit;
} else {
    mostrarTelaErroLogin();
    exit;
}

// Função para mostrar a tela de erro
function mostrarTelaErroLogin()
{
    echo  "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Erro no Login</title>
        <style>
            /* design para pagina */
            body {
                background-color: #666666;
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', sans-serif;
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
                max-width: 500px;
                width: 90%;
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
            }
    
            h1 {
                color: #fff;
            }
    
            .error-message {
                color: #fff;
            }
    
            .btn-voltar {
                display: inline-block;
                background-color: #b5b5b5;
                color: white;
                margin-top: 20px;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 6px;
                border: 1px solid black;
                transition: background-color 0.3s ease;
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
                font-weight: bold;
            }
    
            .btn-voltar:hover {
                background-color: #8c8c8c;
                box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
            }

            .btn-voltar:active {
            transform: translateY(4px);
            }

        </style>

    </head>
    <body>
        <div class='container'>
            <h1>Erro no Login</h1>
            <div class='error-message'>
                Usuário ou senha inválidos. <br>
                <a href='/sistema-garantias/login.html' class='btn-voltar'>Tentar novamente</a>
            </div>
        </div>
    </body>
    </html>
    ";
}
