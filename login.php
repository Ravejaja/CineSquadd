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
    <?php
        session_start();
    ?>  
    <style>
        h1 {
          font-size: 20px; /* Ajuste o tamanho da fonte conforme necessário */
        }
      </style>
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
    </div>

    <form class="form" action="search.php" method="GET"> 
        <div class="group-index">
            <svg class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
            <input placeholder="Search" type="search" class="input-search" name="search">
        </div>
    </form>
    <script src="js/nav-bar.js"></script>
   
   <main>
   

   <div class="main-login">
        <div class="left-login"><h1>Unlock a world of entertainment<br>log in now and join our movie-loving community.</h1>
            <img src="astronaut-animate.svg" class="left-login-image"   alt="Movie Night">
        </div>

        <form id="form" action="confirma_login.php" method="POST">
            <div class="right-login">
                <div class="card-login">
                    <h1>Login</h1>
                    <div class="textfield">
                        <label for="usuario">User</label>
                        <input type="text" name="usuario" placeholder="User" id="usuario" class="inputs required" >
                        <span class="span-required">Please fill in this field</span>

                    </div>
                    <div class="textfield">
                        <label for="senha">Password</label>
                        <input type="password" name="senha" placeholder="Password" id="senha" class="inputs required">
                        <span class="span-required">Please fill in this field</span>
                    </div>
                    <button class="btn-login" type="submit">Login</button>
                    <p style="color: #f0ffffde ">Don't have an account?&nbsp;&nbsp;<a href="registro.php" style="color: #00ff88;">Register</a></p>
                    <?php 
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                </div>  
            </div>
        </form>
    </div>
    </main> 
    <br><br>

    <footer>
        <p>&copy; 2023 CineSquad. All rights reserved.</p>
    </footer>


</body>
<script src="js/form_login.js"></script>
</html>