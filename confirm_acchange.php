<?php   
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário
    $requestId = $_POST['request_id'];
    $action = $_POST['action'];

    // Iniciar a transação
    $conn->begin_transaction();

    try {
        // Atualize o status com base na ação recebida
        $sql = "";
        if ($action === 'accept') {
            $sql = "UPDATE solicitacoes_conta SET status = 'Aceito' WHERE id = $requestId";
        } elseif ($action === 'reject') {
            $sql = "UPDATE solicitacoes_conta SET status = 'Recusado' WHERE id = $requestId";
        }

        // Execute a primeira consulta
        if ($conn->query($sql) === TRUE) {
            // Consulta para atualizar a tabela usuarios
            if ($action === 'accept') {
                $sqlUsuarios = "UPDATE usuarios SET tipo_conta = 2 WHERE id = (SELECT user_id FROM solicitacoes_conta WHERE id = $requestId)";
                if ($conn->query($sqlUsuarios) === TRUE) {
                    // Se ambas as consultas foram bem-sucedidas, commit na transação
                    $conn->commit();
                    echo "Request $requestId was $action.";
                } else {
                    throw new Exception("Erro ao atualizar usuarios: " . $conn->error);
                }
            } else {
                // Se a ação for 'reject', não é necessário atualizar a tabela 'usuarios'
                $conn->commit();
                echo "Request $requestId was $action.";
            }
        } else {
            throw new Exception("Erro ao atualizar solicitacoes_conta: " . $conn->error);
        }
    } catch (Exception $e) {
        // Reverter a transação em caso de erro
        $conn->rollback();
        echo $e->getMessage();
    }

    // Feche a conexão
    $conn->close();
} else {
    echo "Acesso inválido.";
}
?>