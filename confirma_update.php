<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

session_start();

$userID = $_SESSION["id"]; 

$sql = "SELECT * FROM usuarios WHERE id = '$userID'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row["email"];
    $user = $row["user"];
    $senha = $row["senha"];
    $fotoDoUsuario = $row["foto"];
    $tipo_conta = $row["tipo_conta"];
} else {
    // Se não encontrar o perfil, pode exibir uma mensagem de erro ou redirecionar para uma página de erro
    echo "Profile not found";
    exit();
}

// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se a requisição foi para atualizar a foto do perfil
    if (isset($_FILES["profile-picture"]) && $_FILES["profile-picture"]["error"] == 0) {
        $targetDir = "uploads/"; // Pasta de destino para salvar as imagens
        $targetFile = $targetDir . basename($_FILES["profile-picture"]["name"]);
    
        // Move o arquivo para a pasta de destino
        if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $targetFile)) {
    
            $sql = "UPDATE usuarios SET foto = '$targetFile' WHERE id = $userID";
            if ($conn->query($sql) === TRUE) {
                
                echo '<script>alert("successful image upload");</script>';
                header("Location: atualizar_perfil.php");
                
            } else {
                echo '<script>alert("Error updating image in database:");</script>' . $conn->error;
                include("atualizar_perfil.php");
            }
    
        } else {
            echo '<script>alert("Error uploading image.");</script>' . $conn->error;
            include("atualizar_perfil.php");
        }
    }

    // Processar os outros dados do formulário
    $update_user = $_POST['update_user'];
    $update_email = $_POST['update_email'];
    $old_password = $_POST['senha']; // Verifique se está usando a mesma ID para senhas diferentes
    $update_password = $_POST['update_password'];
    $confirm_password = $_POST['new_password'];

    // Inicializa uma variável para guardar as partes da consulta SQL
    $updateFields = [];


   // Verificar se o nome de usuário já existe
    $sqlCheckUser = "SELECT * FROM usuarios WHERE user = '$update_user' AND id != $userID";
    $resultUser = $conn->query($sqlCheckUser);
    $userUnique = ($resultUser->num_rows === 0);

    // Verificar se o e-mail já existe
    $sqlCheckEmail = "SELECT * FROM usuarios WHERE email = '$update_email' AND id != $userID";
    $resultEmail = $conn->query($sqlCheckEmail);
    $emailUnique = ($resultEmail->num_rows === 0);

    // Agora você pode utilizar essas variáveis na sua lógica de atualização
    if ($userUnique && $emailUnique) {
        // Ambos o nome de usuário e e-mail são únicos
        if (!empty($update_user) && $update_user != $user) {
            $updateFields[] = "user = '$update_user'";
        }

        if (!empty($update_email) && $update_email != $email) {
            $updateFields[] = "email = '$update_email'";
        }

        // Restante do seu código para atualizar o perfil
        // ...
    } else {
        // Se o nome de usuário ou e-mail não forem únicos
        if (!$userUnique) {
            echo '<script>alert("Username already exists. Choose another username.");</script>';
            include("atualizar_perfil.php");
        }

        if (!$emailUnique) {
            echo '<script>alert("This email is already in use. Use another email address.");</script>';
            include("atualizar_perfil.php");
        }

        // Lidar com a situação em que os campos não são únicos, por exemplo, redirecionar de volta para a página de edição de perfil
    }
    
    if (!empty($update_password)) {
        $updateFields[] = "senha = '$update_password'";
    }

    
    // Monta a consulta SQL para atualizar o perfil
    if (!empty($updateFields)) {
        $updateFieldsString = implode(', ', $updateFields);
        $sql = "UPDATE usuarios SET $updateFieldsString WHERE id = $userID";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("profile updated successfully");</script>';
            include("pagina_perfil.php");
        } else {
            echo '<script>alert("Error updating profile");</script>' . $conn->error;
            include("atualizar_perfil.php");
        }
    } else {
        echo '<script>alert("No fields have been modified");</script>';
        
    }

}
?>
