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
        header("Location:   login.php");
         exit();
    }
    
    else{
        $userID = $_SESSION["id"]; 
        $sql = "SELECT * FROM usuarios WHERE id = '$userID'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fotoDoUsuario = $row["foto"];
            $email = $row["email"];
            $user = $row["user"];
            $senha = $row["senha"];
            $tipo_conta = $row["tipo_conta"];
        } else {
            // Se não encontrar o perfil, pode exibir uma mensagem de erro ou redirecionar para uma página de erro
            echo "Perfil não encontrado.";
            exit();
        }
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
<body>
    
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

   <br><br><br><br>

    <div class="title-films">
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left"></i> back
    </a>
    <br><br>
    <h2>SEARCH RESULTS</h2>
    
    
    </div>
    <div class="search-container">
        <div class="filters">
            <h2>Filter by Type</h2>
            <form action="search_filters.php" method="GET">
                <div>
                    <input type="radio" id="all" name="category" value="all">
                    <label for="all">All</label>
                    
                </div>

                <div>
                    <input type="radio" id="films" name="category" value="filmes">
                    <label for="filmes">Films</label>
                </div>

                <div>
                    <input type="radio" id="series" name="category" value="series">
                    <label for="series">Series</label>
                </div>

                <!-- Adicione mais categorias conforme necessário -->

                <input type="submit" value="Filter">
            </form>
        </div>
    <?php

    if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    $query = "SELECT * FROM filmes WHERE Titulo LIKE '%$searchTerm%'";
    $result = $conn->query($query);



    
    if ($result->num_rows > 0) {
        // Exibir os filmes
        while($row = $result->fetch_assoc()) {
            
            echo '<div class="search slide-up">';
            echo '<div class="search">';
            echo '      ';
            echo '<a href="film.php?id=' . $row["ID"] . '" class="movie-link">';
            echo '<img src="' . $row["Caminho_Imagem"] . '" alt="' . $row["Titulo"] . '">';
            echo '</a>';
            echo '<div class="search-content">';
            echo '<div class="search-title">' . $row["Titulo"] . '</div>';
            echo '<div class="search-year">' . date("Y", strtotime($row["Data_Envio"])) . '</div>';
            echo '<div class="search-info">Duration: ' . $row["Duracao"] . '</div>';
            echo '<div class="search-info">Rating: ' . $row["Classificacao"] . '</div>';
            // Adicione mais informações do filme se desejar
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
        }
    } else {
        echo "<h1>No movies found.</h1>";
    }
    }else{
        echo "<h1>There was an error while making the query.</h1>";
    }
    ?>
    </div>
    <style>
        /* Adicione essa classe CSS para definir a animação */
        .slide-up {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUpAnimation 0.5s ease forwards;
        }

        @keyframes slideUpAnimation {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


    

   <br><br>
   
    <footer>
        <p>&copy; 2023 CineSquad. All rights reserved.</p>
    </footer>

   
</body>
</html>