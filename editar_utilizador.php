<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

session_start();
if (!isset($_SESSION["id"])) {
    // Se o usuário não estiver autenticado, redirecione para a página de login ou exiba uma mensagem de erro
    echo '<script>alert("Ops! Login!");</script>';
    include("login.html");
    exit();
}

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
    echo "Perfil não encontrado.";
    exit();
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" charset="utf-8"></script>
    <title>CineSquad</title>
    
</head>
<body >
    
   <header>
   <div class="menu-btn">
        <i class="fas fa-bars"></i>
    </div>
    <div class="side-bar">
        <div class="close-btn">
            <i class="fas fa-times"></i>
        </div>
        <div class="menu">
            <div class="profile">
                <a href="pagina_perfil.php">
                    <?php
                    if ($fotoDoUsuario == null) {
                        // Se o campo "foto" for nulo, exibe a imagem padrão
                        echo '<img id="profile-image-avatar" src="uploads/user.png" alt="Foto de perfil">';
                    } else {
                        // Se o campo "foto" não for nulo, exibe a imagem do banco de dados
                        echo '<img id="profile-image-user" src="' . $fotoDoUsuario . '" alt="Foto de perfil">';
                    }
                    ?>
                </a>   
            </div>
            <?php
            if($tipo_conta == 3){
            $usuario_eh_admin = true; // Substitua isso com sua lógica real
            }   
            if ($usuario_eh_admin) {
                echo '<div class="item"><a href="dashboard.php"><i class="fas fa-chart-line"></i>Dashboard (Admin) </a></div>';
            }
            ?>
            <div class="item"><a href="index.php"><i class="fas fa-desktop"></i>Discover</a></div>
            <div class="item">
                <a class="sub-btn"><i class="fas fa-table"></i>Movies<i class="fas fa-angle-right dropdown"></i></a>
                <div class="sub-menu">
                    <a href="#" class="sub-item">Horror </a>
                    <a href="#" class="sub-item">Action</a>
                    <a href="#" class="sub-item">Sci-Fi</a>
                </div>
            </div>
            <div class="item"><a href="#"><i class="fas fa-th"></i>Series</a></div>
            <div class="item">
                <a class="sub-btn"><i class="fas fa-cogs"></i>Settings<i class="fas fa-angle-right dropdown"></i></a>
                <div class="sub-menu">
                    <a href="#" class="sub-item">Sub item 01</a>
                    <a href="#" class="sub-item">Sub item 02</a>  
                </div>
            </div>
            <div class="item"><a href="#"><i class="fas fa-info-circle"></i>About</a></div>
        </div>
    </div>
    <script src="js/nav-bar.js"></script>

   </header>
  
   <main>
</section>

<div class="admin-page">
    <h1>Administration</h1>
    <br>
    <h2>Edit User</h2>
    <?php
    include "config.inc";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    header('Content-Type: text/html; charset=utf-8');

   
    

    $userID = $_SESSION["id"];
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <form action="edit_user.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $row['user']; ?>">
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo $row['email']; ?>">
                <input type="submit" value="Update">
            </form>
    <?php
        } else {
            echo "User not found.";
        }
    }

    $conn->close();
    ?>
</div>

</main>
</body>
</html>