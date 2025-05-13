<?php
$servername = "localhost";
$username = "root";
$password = ""; // senha do seu MySQL, se tiver
$database = "sistema_garantias";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// buscar todos os clientes
$clientes = $conn->query("SELECT id, nome FROM cliente");
?>
