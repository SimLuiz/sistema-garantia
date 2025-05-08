# Sistema de Garantias de Baterias

Este é um sistema web desenvolvido para gerenciar o lançamento de garantias de baterias, incluindo o registro de coleta e detalhes das baterias como modelo, código e rótulo. O sistema foi projetado para motoristas que fazem a coleta de baterias e precisam registrar as garantias com informações detalhadas.

## Tecnologias Utilizadas

- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Banco de Dados**: MySQL
- **Ferramentas de Desenvolvimento**: XAMPP (para rodar o servidor Apache e MySQL)

## Funcionalidades

1. **Tela de Login**: Permite que os usuários acessem o sistema com suas credenciais.
2. **Tela Principal**: Exibe uma lista de lançamentos de garantias com a opção de consultar, editar ou excluir registros.
3. **Lançamento de Garantias**: Permite que os usuários registrem as baterias coletadas, incluindo informações como estado, cidade, cliente, modelo da bateria, código da bateria, rótulo da bateria e data da coleta.
4. **Consulta e Edição de Lançamentos**: Os usuários podem visualizar os registros de garantias e editar os dados caso necessário.
5. **Busca e Filtro**: A tela principal permite buscar e filtrar os registros de garantias por cliente, cidade e data de coleta.

## Como Executar o Projeto

### Pré-requisitos

Antes de executar o projeto, certifique-se de ter as seguintes ferramentas instaladas:

- **XAMPP** ou **WAMP** (para rodar o servidor Apache e MySQL)
- **PHP** (Versão 7 ou superior)
- **MySQL** (para o banco de dados)

### Passos para Instalar

1. **Baixar o Projeto**:
   Faça o download ou clone o repositório do projeto.

2. **Configurar o Banco de Dados**:

   - Acesse o **phpMyAdmin** ou use um cliente de banco de dados para criar um novo banco de dados chamado `sistema_garantias`.
   - Importe o arquivo SQL fornecido para criar as tabelas necessárias. O arquivo SQL pode ser encontrado na pasta `db` ou incluído no repositório.

3. **Configurar o Servidor Web**:

   - Coloque os arquivos do projeto dentro do diretório **htdocs** (caso use o XAMPP) ou o diretório correspondente no seu servidor web.
   - Inicie o servidor Apache e o MySQL no painel de controle do XAMPP ou WAMP.

4. **Configurar a Conexão com o Banco de Dados**:
   No arquivo `conexao.php`, configure as credenciais do banco de dados (usuário, senha e nome do banco). Exemplo:

   ```php
   <?php
   $servername = "localhost";
   $username = "root";  // Defina o nome de usuário do banco de dados
   $password = "";      // Defina a senha do banco de dados
   $dbname = "sistema_garantias"; // Nome do banco de dados

   // Criar conexão
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Checar conexão
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

Acessar o Sistema: Abra o navegador e digite http://localhost/sistema-garantias/login.html para acessar a tela de login. Após o login, você será redirecionado para o painel principal.

/sistema-garantias
├── /css
│ └── style.css # Arquivo CSS para o estilo do sistema
├── /includes
│ └── conexao.php # Arquivo de conexão com o banco de dados
│ └── funções.php # Funções auxiliares para manipulação de dados
├── login.html # Tela de login
├── painel.php # Painel principal com a lista de lançamentos
├── lancamento.php # Tela para registrar lançamentos de garantias
└── editar_lancamento.php # Tela para editar lançamentos existentes

Como Usar
Login: Na tela de login, insira as credenciais do usuário e clique em "Entrar".

Tela Principal: Após o login, você será direcionado à tela principal onde poderá visualizar os lançamentos de garantias. Você pode buscar, filtrar e editar os lançamentos.

Adicionar Lançamento: Clique no botão para adicionar um novo lançamento de garantia. Preencha os campos necessários e clique em "Salvar" para registrar.

Editar ou Excluir Lançamento: Na lista de lançamentos, você pode clicar para editar ou excluir registros existentes.

Contribuições
Se você deseja contribuir com o projeto, siga as etapas abaixo:

Faça um fork do repositório.

Crie uma nova branch (git checkout -b minha-nova-feature).

Faça as alterações necessárias.

Commit suas alterações (git commit -am 'Adicionando nova feature').

Envie para o repositório (git push origin minha-nova-feature).

Abra um pull request.

Licença
Este projeto está sob a licença MIT.

Esse **README.md** fornece uma visão geral do sistema, incluindo o processo de instalação, como usar o sistema, e a estrutura de diretórios do projeto. Se precisar de ajustes ou mais detalhes, é só avisar!
