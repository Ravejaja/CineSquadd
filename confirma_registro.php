<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'lib/vendor/autoload.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);



include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']); 
    $senha2 = mysqli_real_escape_string($conn, $_POST['senha2']);
    $usuario = mysqli_real_escape_string($conn, $_POST["usuario"]);

    // Verifica se o nome de usuário já existe
    $checkUser = "SELECT * FROM usuarios WHERE user = '$usuario'";
    $resultUser = $conn->query($checkUser);

    if ($resultUser->num_rows > 0) {
        echo '<script>alert("Username already exists. Choose another username.");</script>';
        include("registro.php");
        

    }else {
        // Verifica se o e-mail já está registrado
        $checkEmail = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultEmail = $conn->query($checkEmail);

        if ($resultEmail->num_rows > 0) {
            echo '<script>alert("This email is already in use. Use another email address.");</script>';
            include("registro.php");
        } else {
            // Validação de senha
            if ($senha == $senha2) {
                // Encripta a senha do usuário com o algoritmo MD5
                $senha = md5($senha);
                
                // Encripta a encriptação da senha do usuário com o algoritmo MD5
                $senha = md5($senha);

                // Encripta a encriptação MD5 da senha do usuário usando password_hash()
                $senha = password_hash($senha, PASSWORD_DEFAULT);

                $chave = password_hash($email . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);

                $mail = new PHPMailer(true);

                try{
                    
                    $mail->CharSet = "UTF-8";
                    
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'sandbox.smtp.mailtrap.io';              //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'd0b851cdef5826';                     //SMTP username
                    $mail->Password   = '15d4beeac568e6';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port       = 2525;    
                    
                     //Recipients
                    $mail->setFrom('cinesquad@gmail.com', 'Paulo');
                    $mail->addAddress($email, $usuario);     //Add a recipient
                    

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Confirm Email';
                    $mail->Body    = "Dear ". $usuario .  "<br><br> We hope this message finds you well. We are excited to welcome you to the CineSquad community and extend our heartfelt thanks for registering your account.
                    To complete your registration and unlock the full potential of your CineSquad experience, please confirm your email address by clicking on the confirmation link below: <br><br> <a href='http://localhost/CineSquad/confirma_email.php?chave=$chave'> Clique aqui </a>  <br><br>";

                    $mail->AltBody = "Dear ". $usuario .  ".\n\nWe hope this message finds you well. We are excited to welcome you to the CineSquad community and extend our heartfelt thanks for registering your account.
                    To complete your registration and unlock the full potential of your CineSquad experience, please confirm your email address by clicking on the confirmation link below: \n\n http://localhost/CineSquad/confirma_email.php?chave=$chave Clique aqui  \n\n  ";

                    $mail->send();

                   
                }
                catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    header("Location: registro.php");
                }

                // Insere os dados na Base de Dados
                $sql = "INSERT INTO usuarios (email, senha, user, chave) VALUES ('$email','$senha','$usuario', '$chave')"; 
                if ($conn->query($sql) === TRUE) {

                    ob_end_clean();
                    echo '<script>alert("Check your email addres.");</script>';
                    include("registro.php");
                    
                    
                    
                    
                    
                } else {
                    // Erro na inserção
                    echo "Error inserting register: " . $conn->error;
                    include("registro.php");
                }
            } else {
                echo '<script>alert("Passwords do not match");</script>';
                include("registro.php");
            }
        }
    }
}
else {
    // Se o formulário não foi submetido via POST, você pode exibir uma mensagem de erro ou redirecionar para a página correta.
    echo '<script>alert("The form was not submitted correctly");</script>';
    include("registro.php");
    exit();
}




// Fechar a conexão com o banco de dados
$conn->close();

?>
