<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if (isset($_POST['filmTitle']) && isset($_POST['filmDescription']) && isset($_POST['filmCategory']) && isset($_FILES['filmFile'])) {
        
        // Retrieve form data
        $filmTitle = $_POST['filmTitle'];
        $filmDescription = $_POST['filmDescription'];
        $filmCategories = $_POST['filmCategory']; // Assuming an array is sent
        $filmFileName = $_FILES['filmFile']['name'];
        $filmTempFile = $_FILES['filmFile']['tmp_name'];

        // Handle file upload - Move the file to a specific location
        $uploadDirectory = 'uploads/';
        $destination = $uploadDirectory . basename($filmFileName);

        if (move_uploaded_file($filmTempFile, $destination)) {
            // File uploaded successfully, now insert data into the database

            // Assuming you have a films table with columns: title, description, file_name
            $sql = "INSERT INTO filmes (Titulo, Descricao, Caminho_Arquivo_Video) VALUES ('$filmTitle', '$filmDescription', '$filmFileName')";
            
            // Execute the SQL query to insert film details
            if (mysqli_query($conn, $sql)) {
                // Get the last inserted film ID
                $filmId = mysqli_insert_id($conn);

                // Insert film categories into a separate table assuming a many-to-many relationship
                foreach ($filmCategories as $categoryId) {
                    $sqlCategory = "INSERT INTO filmes_categorias (Filme_ID, Categoria_ID) VALUES ('$filmId', '$categoryId')";
                    mysqli_query($conn, $sqlCategory);
                }

                // Successfully inserted film and categories
                echo "Film uploaded successfully!";
            } else {
                // Error in inserting film details
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            // Failed to upload file
            echo "Failed to upload file.";
        }
    } else {
        // Required fields are missing
        echo "Please fill in all required fields.";
    }
} else {
    // If the form wasn't submitted via POST
    echo "Form not submitted properly.";
}
?>