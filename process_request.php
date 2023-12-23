<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos necessários estão preenchidos
    
        $full_name = $_POST['full_name'];
        $motive = $_POST['motive'];
        $experience = $_POST['experience'];
        $portfolio = $_POST['portfolio'];

        // Lida com o arquivo enviado, se existir
        $file_name = $_FILES['file']['name'] ?? '';
        $file_tmp = $_FILES['file']['tmp_name'] ?? '';

        if ($file_name && $file_tmp) {
            $file_destination = 'uploads/portifolios/' . $file_name;
            move_uploaded_file($file_tmp, $file_destination);
        }

        session_start();
        $userID = $_SESSION["id"]; 
        $sql = "SELECT id FROM usuarios WHERE id = '$userID'";
        $result = mysqli_query($conn, $sql);

        $sql = "INSERT INTO solicitacoes_conta (full_name, motive, experience, portfolio, file_name, user_id) VALUES ('$full_name', '$motive', '$experience', '$portfolio', '$file_name', '$userID')";
        if ($conn->query($sql) === TRUE) {
        // Redireciona o usuário para uma página após o processamento bem-sucedido
        header('Location: pagina_perfil.php');
        exit;
        }
        else {
            // Erro na inserção
            echo "Error inserting register: " . $conn->error;
            include("registro.php");
        }
} else {
    // Redireciona para uma página de erro se a requisição não for via método POST
    header('Location: pagina_erro.php');
    exit;
}

?>