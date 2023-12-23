
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
                <a href="login.html">
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
   
    <br><br><br><br>
   <div class="main-login">
        <div class="left-login"><h1>Register<br>and join our team</h1>
            <img src="movie.svg" class="left-login-image"   alt="Movie Night">
        </div>

        <form  id ="form" action="confirma_registro.php" method="POST">
            <div class="right-registo">
                <div class="card-login">
                    <h1>Create Account</h1>
                    <?php 
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <div class="textfield">
                        <label for="usuario">Username</label>
                        <input type="text" name="usuario" ; placeholder="Username" class="inputs required"  id="usuario" oninput="nameValidate()" >
                        <span class="span-required">The username must have more than 4 characters</span>
                    </div>
                    <div class="textfield">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" placeholder="E-mail" class="inputs required" id="email" oninput="emailValidate()">
                        <span class="span-required">Enter a valid email address</span>
                    </div>
                   
                    <div class="textfield">
                        <label for="senha">Password</label>
                        <input type="password" name="senha"   placeholder="Password" class="inputs required" id="senha" oninput="mainPasswordValidate()">
                        <span class="span-required">Enter a password with at least 8 characters</span>
                    </div>
                    <div class="textfield">
                        <label for="senha2">Confirm password</label>
                        <input type="password" name="senha2"  placeholder="Confirm Password" class="inputs required" id="senha2" oninput="comparePassword()">
                        <span class="span-required">Passwords must be compatible</span>
                    </div>
                    
                    <button class="btn-login" type="submit">Register</button>
                    <p style="color: #f0ffffde ">Already have an account?&nbsp;&nbsp;<a href="login.php" style="color: #00ff88;">Login</a></p>

                    <div class="error" style="display: none">
                        <div class="error__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z"></path></svg>
                        </div>
                        <div class="error__title" ></div>
                        <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20"><path fill="#393a37" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path></svg></div>
                    </div>

                    <div class="success" style="display: none">
                        <div class="success__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill-rule="evenodd" fill="#393a37" d="m12 1c-6.075 0-11 4.925-11 11s4.925 11 11 11 11-4.925 11-11-4.925-11-11-11zm4.768 9.14c.0878-.1004.1546-.21726.1966-.34383.0419-.12657.0581-.26026.0477-.39319-.0105-.13293-.0475-.26242-.1087-.38085-.0613-.11844-.1456-.22342-.2481-.30879-.1024-.08536-.2209-.14938-.3484-.18828s-.2616-.0519-.3942-.03823c-.1327.01366-.2612.05372-.3782.1178-.1169.06409-.2198.15091-.3027.25537l-4.3 5.159-2.225-2.226c-.1886-.1822-.4412-.283-.7034-.2807s-.51301.1075-.69842.2929-.29058.4362-.29285.6984c-.00228.2622.09851.5148.28067.7034l3 3c.0983.0982.2159.1748.3454.2251.1295.0502.2681.0729.4069.0665.1387-.0063.2747-.0414.3991-.1032.1244-.0617.2347-.1487.3236-.2554z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="success__title"></div>
                        <div class="success__close"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20"><path fill="#393a37" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path></svg></div>
                    </div>

                </div>
            </div>
        </form>
   </div>

   <br><br><br><br>

    <footer>
        <p>&copy; 2023 CineSquad. All rights reserved.</p>
    </footer>

</body>
<script src="js/form_registro.js"></script>
</html>