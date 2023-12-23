<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');


if (isset($_GET['id'])) {
    
    // Obtém o nome do usuário da URL
    $id = $_GET['id'];

      // Excluir as referências do usuário na tabela 'solicitacoes_conta'
      $sqlDeleteSolicitacoes = "DELETE FROM solicitacoes_conta WHERE user_id = $id";
      $resultDeleteSolicitacoes = $conn->query($sqlDeleteSolicitacoes);

      if ($resultDeleteSolicitacoes === TRUE) {
        // As referências foram excluídas com sucesso
        // Agora podemos excluir o usuário na tabela 'usuarios'
        $sqlDeleteUsuario = "DELETE FROM usuarios WHERE id = $id";
        $resultDeleteUsuario = $conn->query($sqlDeleteUsuario);

        if ($resultDeleteUsuario === TRUE) {
            echo "User removed successfully.";
        } else {
            echo "Error removing user:" . $conn->error;
        }
    } else {
        echo "Error when deleting user references in the 'requests_account' table: " . $conn->error;
    }

    $conn->close();

} 
?>