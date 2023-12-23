<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    // Redirecionar para a página de resultados com o parâmetro da pesquisa
    header("Location: search_results.php?search=$searchTerm");
    exit();
} else {
    echo "The form was not submitted correctly";
}
?>