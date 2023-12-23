<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $query = "SELECT * FROM filmes WHERE Titulo LIKE '%$searchTerm%'";

    
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $_GET['category'];
        if ($category === 'all') {
            // Nenhuma condição extra necessária para 'Tudo'
        } elseif ($category === 'films') {
            $query .= " AND Tipo = 'Filme'";
        } elseif ($category === 'series') {
            $query .= " AND Tipo = 'Série'";
        }
       
    }

    $result = $conn->query($query);

    
}
?>