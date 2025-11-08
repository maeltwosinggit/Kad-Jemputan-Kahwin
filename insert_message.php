<?php
// Load configuration
include 'config.php';

$connection = mysqli_connect($servername, $username, $password);

if (!$connection) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

mysqli_select_db($connection, $database);

// Add data into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set proper content type for JSON response
    header('Content-Type: application/json');
    
    // Validate input
    if (empty($_POST['name']) || empty($_POST['message'])) {
        echo json_encode(['success' => false, 'message' => 'Name and message are required.']);
        mysqli_close($connection);
        exit();
    }
    
    // Process the form submission
    $name = mysqli_real_escape_string($connection, trim($_POST['name']));
    $message = mysqli_real_escape_string($connection, trim($_POST['message']));
    
    // Insert into database
    $query = "INSERT INTO ucapan_kahwin (nama_tetamu, ucapan_tetamu) VALUES ('$name', '$message')";

    if (mysqli_query($connection, $query)) {
        echo json_encode(['success' => true, 'message' => 'Thank you! Your wishes have been sent successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving data: ' . mysqli_error($connection)]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

mysqli_close($connection);
?>
