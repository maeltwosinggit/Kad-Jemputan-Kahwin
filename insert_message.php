<?php
// Load configuration
include 'config.php';

// Load Google Sheets helper (only if configured)
$google_sheets_enabled = false;
if (file_exists('google_sheets_config.php') && file_exists('google_sheets_helper.php')) {
    try {
        require_once 'google_sheets_helper.php';
        $google_sheets = new GoogleSheetsHelper();
        $google_sheets_enabled = true;
    } catch (Exception $e) {
        // Google Sheets not configured properly, continue without it
        error_log("Google Sheets sync disabled: " . $e->getMessage());
    }
}

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
        $insert_id = mysqli_insert_id($connection);
        
        // Sync to Google Sheets if enabled
        if ($google_sheets_enabled) {
            try {
                $google_sheets->addUcapanEntry($insert_id, $name, $message);
            } catch (Exception $e) {
                // Log error but don't fail the request
                error_log("Google Sheets sync failed for ucapan: " . $e->getMessage());
            }
        }
        
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
