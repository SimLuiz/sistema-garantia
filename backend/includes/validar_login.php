<?php
session_start();
include(__DIR__ . "/conexao.php");

$usuario = $_POST['usuario'];
$senha = md5($_POST['senha']); // criptografa com MD5

$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {

    $_SESSION['logado'] = true;
    $dados_usuario = $result->fetch_assoc(); // pega o usuário como array associativo
    $_SESSION['usuario_id'] = $dados_usuario['id'];
    $_SESSION['usuario'] = $dados_usuario['usuario']; // salva o nome de usuário na sessão    
    $_SESSION['login_sucesso'] = true; // Variável de sucesso
    header("Location: /sistema-garantias/frontend/views/painel.php");
    exit;
} else {
    echo "
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
                background-color: #b5b5b5;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 500px;
                width: 90%;
            }
    
            h1 {
                color: #2c3e50;
            }
    
            .error-message {
                color: #444;
            }
    
            .btn-voltar {
                display: inline-block;
                background-color: #8c8c8c;
                color: black;
                margin-top: 20px;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 6px;
                border: 1px solid black;
                transition: background-color 0.3s ease;
            }
    
            .btn-voltar:hover {
                background-color: #b5b5b5;
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
