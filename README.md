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

         📁 sistema-garantias
         📁 backend
         │
         ├── 📁 banco
         │   └── database.sql                      # Script SQL para criação do banco de dados e tabelas
         │
         ├── 📁 controllers                       # Arquivos PHP que controlam ações do sistema (CRUD, exportação, logout)
         │   ├── atualizar_lancamento.php         # Atualiza os dados de um lançamento de garantia
         │   ├── editar_bateria.php                # Edita os dados de uma bateria específica
         │   ├── editar_inline.php                 # Edição rápida inline de dados na interface
         │   ├── excluir_bateria_individual.php   # Remove uma bateria específica de um lançamento
         │   ├── excluir_bateria.php               # Exclui baterias, possivelmente em lote
         │   ├── excluir_lancamento.php            # Apaga um lançamento inteiro de garantias
         │   ├── exportar_csv.php                  # Exporta lançamentos em formato CSV para download
         │   ├── logout.php                       # Finaliza a sessão do usuário (logout)
         │   └── salvar_lancamento.php             # Salva um novo lançamento no banco de dados
         │
         ├── 📁 includes                         # Arquivos auxiliares comuns para conexão e autenticação
         │   ├── conexao.php                      # Estabelece conexão com o banco MySQL
         │   └── validar_login.php                # Valida se o usuário está logado
         │
         ├── 📁 documentacao                    # Arquivos e recursos para documentação do sistema
         │   ├── 📁 css
         │   │   └── estilo_documentacao.css      # CSS para estilizar a documentação
         │   │
         │   ├── 📁 documentos_sistema
         │   │   ├── documentacao.html            # Documento HTML com informações técnicas/uso do sistema
         │   │   └── manual_uso.txt               # Manual de uso em formato texto para o usuário final
         │   │
         │   └── 📁 imagens                       # Imagens ilustrativas para a documentação
         │       ├── consulta.png
         │       ├── lancamento.png
         │       ├── login.png
         │       ├── painel.png
         │       └── powerbi.png
         │
         ├── 📁 frontend                        # Arquivos da interface do usuário (CSS e páginas PHP)
         │   ├── 📁 css
         │   │   └── estilo.css                   # Estilo principal do sistema (CSS)
         │   │
         │   └── 📁 views
         │       ├── consultar_lancamentos.php   # Página para visualizar e buscar lançamentos
         │       ├── editar_lancamento.php        # Página para editar um lançamento de garantia
         │       ├── lancar_garantias.php         # Página para cadastrar novos lançamentos
         │       ├── painel.php                   # Tela principal/dashboard após login
         │
         │
         |── login.html                          # Página de login para acesso ao sistema
         └── README.md                          # Documentação geral do projeto para desenvolvedores

Como Usar
Login: Na tela de login, insira as credenciais do usuário e clique em "Entrar".

Tela Principal: Após o login, você será direcionado à tela principal onde poderá visualizar os lançamentos de garantias. Você pode buscar, filtrar e editar os lançamentos.

Adicionar Lançamento: Clique no botão para adicionar um novo lançamento de garantia. Preencha os campos necessários e clique em "Salvar" para registrar.

Editar ou Excluir Lançamento: Na lista de lançamentos, você pode clicar para editar ou excluir registros existentes.

Licença
Este projeto está sob a licença MIT.

Esse **README.md** fornece uma visão geral do sistema, incluindo o processo de instalação, como usar o sistema, e a estrutura de diretórios do projeto. Se precisar de ajustes ou mais detalhes, é só avisar!
