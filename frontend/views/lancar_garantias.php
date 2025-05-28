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
  <link rel="stylesheet" href="/sistema-garantias/frontend/css/estilo.css">
  <title>Lançar Garantias</title>
  <style>
    body {
      background-color: #E4E4E5;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    input,
    select {
      background-color: #b5b5b5;
      /* fundo escuro */
      color: black;
      /* texto escuro */
      padding: 8px;
      margin: 5px;
      width: 250px;
      border: 1px solid black;
      /* borda escuro */
    }

    input:hover {
      background-color: #8c8c8c;
    }

    label {
      color: black;
    }

    .bateria {
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 10px;
      margin: 10px 0;
    }

    button {
      padding: 10px 15px;
      background-color: #b5b5b5;
      /* fundo escuro */
      color: black;
      /* texto escuro */
      border: none;
      border-radius: 5px;
      border: 1px solid black;
      /* borda escuro */
      margin: 5px 0;
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    button:hover {
      background-color: #8c8c8c;
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    button:active {
      transform: translateY(4px);
    }

    .container {
      position: relative;
      background-color: #b5b5b5;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 700px;
      width: 100%;
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    /*edicao do botao voltar painel*/
    .btn-voltar {
      position: absolute;
      top: 30px;
      left: 30px;
      padding: 8px 16px;
      background-color: #b5b5b5;
      /* fundo escuro */
      color: black;
      /* texto escuro */
      text-decoration: none;
      border: 1px solid #ccc;
      border-radius: 5px;
      transition: background-color 0.3s, color 0.3s;
      font-size: 14px;
      border: 1px solid black;
      /* borda escuro */
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .btn-voltar:hover {
      background-color: #8c8c8c;
      /* leve cinza ao passar o mouse */
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    .btn-voltar:active {
      transform: translateY(4px);
    }

    #btnFinalizar {
      background-color: #8c8c8c;
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    #btnFinalizar:hover {
      background-color: #b5b5b5;
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    #btnFinalizar:active {
      transform: translateY(4px);
    }
  </style>


</head>

<body>
  <div class="container">
    <a href="/sistema-garantias/frontend/views/painel.php" class="btn-voltar">🔙 Voltar ao Painel</a>
    <h2>Lançamento de Garantias</h2>

    <form action="/sistema-garantias/backend/controllers/salvar_lancamento.php" method="POST">

      <label>Estado:</label><br>
      <select name="estado" id="estado" required onchange="carregarCidades()">
        <option value="">Selecione o estado</option>
        <option value="AC">Acre</option>
        <option value="AL">Alagoas</option>
        <option value="AP">Amapá</option>
        <option value="AM">Amazonas</option>
        <option value="BA">Bahia</option>
        <option value="CE">Ceará</option>
        <option value="DF">Distrito Federal</option>
        <option value="ES">Espírito Santo</option>
        <option value="GO">Goiás</option>
        <option value="MA">Maranhão</option>
        <option value="MT">Mato Grosso</option>
        <option value="MS">Mato Grosso do Sul</option>
        <option value="MG">Minas Gerais</option>
        <option value="PA">Pará</option>
        <option value="PB">Paraíba</option>
        <option value="PR">Paraná</option>
        <option value="PE">Pernambuco</option>
        <option value="PI">Piauí</option>
        <option value="RJ">Rio de Janeiro</option>
        <option value="RN">Rio Grande do Norte</option>
        <option value="RS">Rio Grande do Sul</option>
        <option value="RO">Rondônia</option>
        <option value="RR">Roraima</option>
        <option value="SC">Santa Catarina</option>
        <option value="SP">São Paulo</option>
        <option value="SE">Sergipe</option>
        <option value="TO">Tocantins</option>
      </select><br>

      <label>Cidade:</label><br>
      <select name="cidade" id="cidade" required>
        <option value="">Selecione o estado primeiro</option>
      </select><br>


      <label for="cliente_nome">Nome do Cliente:</label><br>
      <input type="text" name="cliente_nome" id="cliente_nome" required><br>

      <label>Data da Coleta:</label><br>
      <input type="date" name="data_coleta" required><br><br>

      <h3>Baterias</h3>
      <div id="baterias"></div>

      <button type="button" onclick="adicionarBateria()">➕ Adicionar Bateria</button><br><br>

      <input type="submit" value="Finalizar Lançamento" id="btnFinalizar">


    </form>
  </div>

  <script>
    let contador = 0;
    const limite = 30;

    function adicionarBateria() {
      if (contador >= limite) {
        alert("Você só pode adicionar até 30 baterias por lançamento.");
        return;
      }

      contador++;

      const container = document.getElementById("baterias");

      const div = document.createElement("div");
      div.className = "bateria";
      div.setAttribute("data-id", contador); // facilita encontrar e remover

      div.innerHTML = `
        <strong>Bateria ${contador}</strong><br>
        <label>Modelo:</label><br>
        <input type="text" name="baterias[${contador}][modelo]" required><br>
        <label>Código:</label><br>
        <input type="text" name="baterias[${contador}][codigo]" required><br>
        <label>Rótulo:</label><br>
        <input type="text" name="baterias[${contador}][rotulo]" required><br>
        <button type="button" onclick="removerBateria(this)">🗑 Remover</button>
      `;

      container.appendChild(div);
    }

    function removerBateria(botao) {
      const div = botao.parentElement;
      div.remove();
      contador--; // decrementa o contador
    }

    //API para puxar estados e cidades

    function carregarEstados() {
      fetch("https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome")
        .then(res => res.json())
        .then(estados => {
          const estadoSelect = document.getElementById("estado");
          estados.forEach(estado => {
            const option = document.createElement("option");
            option.value = estado.id;
            option.text = estado.nome;
            estadoSelect.add(option);
          });
        });
    }

    function carregarCidades() {
      const estadoId = document.getElementById("estado").value;
      const cidadeSelect = document.getElementById("cidade");

      cidadeSelect.innerHTML = "<option>Carregando...</option>";

      fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`)
        .then(res => res.json())
        .then(cidades => {
          cidadeSelect.innerHTML = "<option value=''>Selecione a cidade</option>";
          cidades.forEach(cidade => {
            const option = document.createElement("option");
            option.value = cidade.nome;
            option.text = cidade.nome;
            cidadeSelect.add(option);
          });
        });
    }
  </script>

</body>

</html>