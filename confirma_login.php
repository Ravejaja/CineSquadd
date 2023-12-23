<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
		$senha = mysqli_real_escape_string($conn, $_POST['senha']);
	
		// Encripta a senha do usuário com o algoritmo MD5
		$senha = md5($senha);
		$senha = md5($senha);
	

		// Consulta SQL para buscar o usuário pelo nome de usuário
		$sql = "SELECT id, senha, sit_usuario_id FROM usuarios WHERE user = '$usuario'";
		$resultado = $conn->query($sql);
	
		if ($resultado->num_rows > 0) {
			$linha = $resultado->fetch_assoc();
			$userID = $linha['id'];
			$userSIT = $linha['sit_usuario_id'];
			$hash = $linha['senha'];

			if($userSIT != 1){
				echo '<script>alert("Error: Email not confirmed");</script>';
				include("login.html");
			}elseif (password_verify($senha, $hash)) {
				session_start(); // Iniciar a sessão
				$_SESSION["id"] = $userID; // Armazenar o ID do usuário na sessão
				echo '<script>alert("Login Successfully.");</script>';
				include("pagina_protegida.php"); // Redirecionar para a página protegida após o login
				exit();
			} else {
				// Senha incorreta, exibe mensagem de erro
				echo '<script>alert("Incorrect password");</script>';
				include("login.php");
				exit();
			}
		} else {
			// Usuário não encontrado, exibe mensagem de erro
			echo '<script>alert("User not found");</script>';
			include("login.php");
			exit();
		}
	}

	else {
		// Se o formulário não foi submetido via POST, você pode exibir uma mensagem de erro ou redirecionar para a página correta.
		echo '<script>alert("The form was not submitted correctly");</script>';
		include("login.php");
		exit();
	}
		// Fechar a conexão com o banco de dados
        $conn->close();

?>	
