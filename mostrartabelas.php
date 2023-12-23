<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SHOW CREATE TABLE avaliacoes";
$result = mysqli_query($conn, $sql); // Correção

$sql1 = "SHOW CREATE TABLE categorias";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "SHOW CREATE TABLE favoritos";
$result2 = mysqli_query($conn, $sql2);

$sql3 = "SHOW CREATE TABLE filmes";
$result3 = mysqli_query($conn, $sql3);

$sql4 = "SHOW CREATE TABLE filmes_categorias";
$result4 = mysqli_query($conn, $sql4);

$sql5 = "SHOW CREATE TABLE historico_visualizacao";
$result5 = mysqli_query($conn, $sql5);

$sql6 = "SHOW CREATE TABLE sits_usuario";
$result6 = mysqli_query($conn, $sql6);

$sql7 = "SHOW CREATE TABLE solicitacoes_conta";
$result7 = mysqli_query($conn, $sql7);

$sql8 = "SHOW CREATE TABLE usuarios";
$result8 = mysqli_query($conn, $sql8);



if ($result && $result1 && $result2 && $result3 && $result4 && $result5 && $result6 && $result7 && $result8 ) {
    $row = mysqli_fetch_assoc($result);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    echo"<br><br>";
    $row = mysqli_fetch_assoc($result1);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    echo"<br><br>";
    $row = mysqli_fetch_assoc($result2);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    echo"<br><br>";
    $row = mysqli_fetch_assoc($result3);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    echo"<br><br>";
    $row = mysqli_fetch_assoc($result4);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    echo"<br><br>";
    $row = mysqli_fetch_assoc($result5);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    echo"<br><br>";
    $row = mysqli_fetch_assoc($result6);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    $row = mysqli_fetch_assoc($result7);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    $row = mysqli_fetch_assoc($result8);
    $createTableSQL = $row['Create Table'];
    echo $createTableSQL;
    
} else {
    echo "Erro na consulta: " . mysqli_error($conn);
}

mysqli_close($conn);
?>