
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
                <a href="login.php">
                <img id="profile-image-avatar" src="uploads/user.png" alt="Foto de perfil">
                </a>
            </div>
            <div class="item"><a href="#"><i class="fas fa-desktop"></i>Discover</a></div>
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
    </div>

    <form class="form" action="search.php" method="GET"> 
    <div class="group-index">
        <svg class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
        <input placeholder="Search" type="search" class="input-search" name="search">
    </div>
    </form>
    
    <script src="js/nav-bar.js"></script>
    
   <main>
  

   <br><br><br><br>

   <div class="title-films">
    <h2>ONLINE STREAMING</h2>
    <h1>Recent Films</h1>
    </div>
    <div class="movie-container">
    <?php
    include "config.inc";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    header('Content-Type: text/html; charset=utf-8');

    
    $sql = "SELECT * FROM filmes";
    $result = $conn->query($sql);
    // Verificar se há resultados da query
    if ($result->num_rows > 0) {
        // Exibir os filmes
        while($row = $result->fetch_assoc()) {
            
                echo '<div class="movie">';
                echo '<a href="film.php?id=' . $row["ID"] . '" class="movie-link">';
                echo '<img src="' . $row["Caminho_Imagem"] . '" alt="' . $row["Titulo"] . '">';
                echo '</a>';
                echo '<div class="movie-content">';
                echo '<div class="movie-title">' . $row["Titulo"] . '</div>';
                echo '<div class="movie-year">' . date("Y", strtotime($row["Data_Envio"])) . '</div>';
                echo '<div class="movie-info">Duration: ' . $row["Duracao"] . '</div>';
                echo '<div class="movie-info">Rating: ' . $row["Classificacao"] . '</div>';
                // Adicione mais informações do filme se desejar
                echo '</div>';
                echo '</div>';
                
        }
    } else {
        echo "<h1>There are no films available.</h1>";
    }
    ?>
    </div>
    


   <footer>
    <p>&copy; 2023 CineSquad. All rights reserved.</p>
   </footer>
   
   <script src="js/nav-bar.js"></script>
   </main>   
</body>
</html>