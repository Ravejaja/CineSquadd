<?php
include "config.inc";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: text/html; charset=utf-8');

$caminhoDoVideo = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT Caminho_Arquivo_Video FROM filmes WHERE ID = $id";
    $result = $conn->query($sql);      
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $caminhoDoVideo = $row["Caminho_Arquivo_Video"];
    } else {
        echo "No results found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
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
    
</head>
<body>

<div class="movie-player">
    <?php if (!empty($caminhoDoVideo)): ?>
        <video class="media" width="100%" height="60%" controls autoplay>
            <source src="<?php echo $caminhoDoVideo; ?>" type="video/mp4">
        </video>
    <?php else: ?>
        <p>Sorry, the video is not available.</p>
    <?php endif; ?>
    
    <!-- Aqui você pode adicionar mais informações sobre o filme se desejar -->
    <div class="movie-info">
        <p>Other information about the film...</p>
    </div>
</div>

</body>
</html>