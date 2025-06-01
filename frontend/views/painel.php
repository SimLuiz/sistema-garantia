<?php
session_start();
if (!isset($_SESSION['logado'])) {
  header("Location: ../../login.html");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/sistema-garantias/frontend/css/estilo.css"> <!-- Linkando o arquivo CSS -->
  <title>Painel - Sistema de Garantias</title>
  <style>
    body {
      background-color: #666666;
      font-family: Arial, sans-serif;
      text-align: center;
      margin-top: 100px;
    }

    h1 {
      color: #fff;
      margin-bottom: 40px;
    }

    /*botao*/
    a {
      background-color: #b5b5b5;
      /* fundo escuro */
      color: white;
      /* texto escuro */
      height: 80px;
      display: flex;
      /* flexbox para centralizar o texto */
      flex-direction: column;
      padding: 10px 20px;
      border: 1px solid black;
      /* borda escuro */
      text-decoration: none;
      margin: 10px;
      /* espaçamento entre os links */
      border-radius: 8px;
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      justify-content: center;
      font-size: 25px;
      font-weight: bold;
      text-decoration: none;
    }

    a:hover {
      background-color: #8c8c8c;
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
      text-decoration: none;
    }

    a:active {
      transform: translateY(4px);
    }

    .container {
      background-color: #3c3c3c;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 1200px;
      width: 1200px;
      height: 600px;
      margin: 0 auto;
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

    <h1>Bem-vindo, <?= $_SESSION['usuario'] ?>!</h1>

    <a href="lancar_garantias.php">➕ Lançar</a>
    <a href="consultar_lancamentos.php">🔍 Consultar</a>
    <a href="/sistema-garantias/backend/controllers/logout.php">🚪 Sair</a>

  </div>

  <?php if (isset($_SESSION['login_sucesso'])): ?>
    <div id="popup" style="
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #3c3c3c;
    color: white;
    padding: 15px 25px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    z-index: 1000;
    font-weight: bold;
  ">
      Login efetuado com sucesso!
    </div>
    <script>
      setTimeout(() => {
        const popup = document.getElementById('popup');
        if (popup) popup.remove();
      }, 3000); // some após 3 segundos
    </script>
    <?php unset($_SESSION['login_sucesso']); ?>
  <?php endif; ?>
</body>

</html>