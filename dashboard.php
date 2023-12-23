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
    include("login.php");
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
    echo "Profile not found";
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
   <div class="header">
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
            $usuario_eh_admin = false;
            if($tipo_conta == 3){
            $usuario_eh_admin = true; // Substitua isso com sua lógica real
            }   
            if ($usuario_eh_admin) {
                echo '<div class="item"><a href="dashboard.php"><i class="fas fa-chart-line"></i>Dashboard (Admin) </a></div>';
            }
            ?>
            <div class="item"><a href="pagina_protegida.php"><i class="fas fa-desktop"></i>Discover</a></div>
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
    <form class="form" action="search.php" method="GET"> 
    <div class="group">
        <svg class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
        <input placeholder="Search" type="search" class="input-search" name="search">
    </div>
    </form>
    <script src="js/nav-bar.js"></script>

   </header>
  
   <main>
</section>
<br><br><br>
<div class="admin-page">
    <h1>Administration</h1>
    <br>
    <div class="card-container">
        <div class="card">
            <a href="users.php"><h2><i class="fa fa-users"></i>Users</h2>
                <p>
            <?php
                include "config.inc"; 
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sqlUsers = "SELECT COUNT(*) AS total_users FROM usuarios"; 
                $resultUsers = $conn->query($sqlUsers);
                $rowUsers = $resultUsers->fetch_assoc();
                echo $rowUsers['total_users'];

                $conn->close();
                ?>
                </p>
            </a>
        </div>
        <div class="card">
            <a href="films.php"><h2><i class="fa fa-film"></i>Films</h2>
            <p>
            <?php
                include "config.inc"; 
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sqlFilms = "SELECT COUNT(*) AS total_films FROM filmes"; 
                $resultFilms = $conn->query($sqlFilms);
                $rowFilms = $resultFilms->fetch_assoc();
                echo $rowFilms['total_films'];

                $conn->close();
                ?>
            </p>
            </a>
        </div>
    </div>

    <h2>Account Change Requests</h2>
    <div class="submissions">
        <p> 
        <?php
            include "config.inc"; 
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sqlRequests = "SELECT * FROM solicitacoes_conta WHERE status = 'Em espera'" ; 
            $resultRequests = $conn->query($sqlRequests);

            if ($resultRequests->num_rows > 0) {
                while ($row = $resultRequests->fetch_assoc()) {
    
                    echo "<div class='request-entry'>";
                    echo "<p class='request-info'>Full Name: " . $row['full_name'] . "</p>";
                    echo "<p class='request-info'>Motive: " . $row['motive'] . "</p>";
                    echo "<div class='request-actions'>";
                    
                    // Formulário para aceitar a solicitação
                    echo "<form action='confirm_acchange.php' method='post'>";
                    echo "<input type='hidden' name='request_id' value='" . $row['id'] . "'>";
                    echo "<input type='hidden' name='action' value='accept'>";
                    echo "<button type='submit' id='accept'><i class='fa fa-check'> Accept</i></button>";
                    echo "</form>";
                    
                    // Formulário para rejeitar a solicitação
                    echo "<form action='confirm_acchange.php' method='post'>";
                    echo "<input type='hidden' name='request_id' value='" . $row['id'] . "'>";
                    echo "<input type='hidden' name='action' value='reject'>";
                    echo "<button type='submit' id='reject' ><i class='fa fa-times'> Reject</i></button>";
                    echo "</form>";

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No requests found.";
            }
        ?>
        </p>
    </div>
    <br>
    <h2>Film Submissions</h2>
    <div class="submissions">
        <p> 
        <?php
            $sqlFilms = "SELECT * FROM filmes WHERE Status = 'Em espera'";
            $resultFilms = $conn->query($sqlFilms);

            
            // Seu código PHP para buscar e exibir os filmes...
            if ($resultFilms->num_rows > 0) {
                while ($row = $resultFilms->fetch_assoc()) {
                    echo '<div class="movie-item">';
                    echo '<img src="' . $row['Caminho_Imagem'] . '" alt="' . $row['Titulo'] . '" class="movie-poster">';
                    echo '<div class="movie-details">';
                    echo '<h2>' . $row['Titulo'] . '</h2>';
                    echo '<p class="description">' . $row['Descricao'] . '</p>';
                    echo '</div>';
                    echo '<div class="movie-actions">';
                    echo '<button class="accept-btn">Accept</button>';
                    echo '<button class="reject-btn">Reject</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '<hr>'; // Linha separadora entre os filmes
                }
            } else {
                echo "No film submissions found.";
            }
            

            $conn->close();
        ?>
        </p>
    </div>
</div>

</main>
</body>
</html>