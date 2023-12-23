        <?php
        include "config.inc";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        header('Content-Type: text/html; charset=utf-8');

        session_start();
        $IDuser = $_SESSION["id"];

        // Check if the form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if all required fields are present
            if (isset($_POST['filmTitle']) && isset($_POST['filmDescription']) && isset($_POST['filmCategory']) && isset($_FILES['filmFile']) && isset($_FILES['filmImage'])) {
                
                // Retrieve form data
                $filmTitle = $_POST['filmTitle'];
                $filmDescription = $_POST['filmDescription'];
                $filmCategories = $_POST['filmCategory']; // Assuming an array is sent
                $filmFileName = $_FILES['filmFile']['name'];
                $filmTempFile = $_FILES['filmFile']['tmp_name'];

                // Handle file upload for video - Move the file to a specific location
                $uploadVideoDirectory = 'uploads/filmes/videos';
                $videoDestination = $uploadVideoDirectory . basename($filmFileName);

                if (move_uploaded_file($filmTempFile, $videoDestination)) {
                    // Use FFmpeg to get video duration
                    $ffmpegCommand = "ffmpeg -i $videoDestination 2>&1";
                    $ffmpegOutput = shell_exec($ffmpegCommand);

                    // Extract duration from FFmpeg output
                    if (preg_match('/Duration: (.*?),/', $ffmpegOutput, $matches)) {
                        $duration = $matches[1]; // Obtains the video duration
                    } else {
                        $duration = "00:00:00"; // Set a default duration if unable to retrieve
                    }

                    // Video file uploaded successfully, now handle image upload
                    
                    // Retrieve image details
                    $filmImageName = $_FILES['filmImage']['name'];
                    $filmImageTemp = $_FILES['filmImage']['tmp_name'];

                    // Handle file upload for image - Move the file to a specific location
                    $uploadImageDirectory = 'uploads/filmes/Imagens/';
                    $imageDestination = $uploadImageDirectory . basename($filmImageName);

                    if (move_uploaded_file($filmImageTemp, $imageDestination)) {
                        // Image uploaded successfully, now insert data into the database

                        // Get the current year
                        $currentDate = date('Y-m-d'); // Current date in YYYY-MM-DD format


                        // Assuming you have a filmes table with columns: Titulo, Descricao, Caminho_Arquivo_Video, Caminho_Imagem, Duracao
                        $sql = "INSERT INTO filmes (Titulo, Descricao, Caminho_Arquivo_Video, Caminho_Imagem, Duracao, Data_Envio, ID_Utilizador) 
                                VALUES ('$filmTitle', '$filmDescription', '$videoDestination', '$imageDestination', '$duration', '$currentDate', $IDuser)";
                        
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
                            echo "Film uploaded successfully! Wait for a admin to check.";
                        } else {
                            // Error in inserting film details
                            echo "Error: " . mysqli_error($conn);
                        }
                    } else {
                        // Failed to upload image
                        echo "Failed to upload image.";
                    }
                } else {
                    // Failed to upload video file
                    echo "Failed to upload video file.";
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
