<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];

    // Atualiza os detalhes do usuário
    $sql = "UPDATE usuarios SET user = '$newUsername', email = '$newEmail' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
       
        header("Location: editar_utilizador.php");
    } else {
        echo '<script>alert("User details updated successfully");</script>'  . $conn->error;
    }
}

$conn->close();


?>