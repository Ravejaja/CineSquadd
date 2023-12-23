<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

// Verifique se o usuário está logado (você deve ter a lógica de autenticação aqui)
session_start();
if (!isset($_SESSION["id"])) {
    // Se o usuário não estiver autenticado, redirecione para a página de login ou exiba uma mensagem de erro
    header("Location: login.php");
    exit();
}

$userID = $_SESSION["id"]; 

// Recupere a foto de perfil do usuário
$query = "SELECT foto FROM usuarios WHERE id = $usuario_id";
$result = $conexao->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_picture = $row["foto"];
} else {
    // Se o usuário não tiver uma foto de perfil, defina uma imagem padrão
    $profile_picture = "uploads/user.png";
}

// Agora, você pode retornar a URL da foto de perfil ou a imagem padrão
echo json_encode(["profile_picture" => $profile_picture]);

// Feche a conexão com o banco de dados
$conexao->close();
?>