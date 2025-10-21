<?php
// Start output buffering and suppress any warnings
ob_start();
error_reporting(0);

// Load configuration
include 'config.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to database
    $connection = mysqli_connect($servername, $username, $password, $database);
    
    if (!$connection) {
        ob_clean();
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }
    
    // Get and sanitize form data
    $nama = mysqli_real_escape_string($connection, trim($_POST['nama']));
    $jumlah_pax = (int)$_POST['jumlah_pax'];
    $hubungan = mysqli_real_escape_string($connection, trim($_POST['hubungan']));
    $status = $_POST['status']; // 'hadir' or 'tidak_hadir'
    
    // Validate data
    if (empty($nama) || $jumlah_pax < 1 || empty($hubungan) || !in_array($status, ['hadir', 'tidak_hadir'])) {
        ob_clean();
        echo json_encode(['success' => false, 'message' => 'Sila isi semua maklumat dengan betul']);
        exit;
    }
    
    // Check for exact duplicate (same name AND relationship AND status) to prevent spam
    $check_query = "SELECT id FROM rsvp_guests WHERE nama = '$nama' AND hubungan = '$hubungan' AND status = '$status'";
    $check_result = mysqli_query($connection, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        ob_clean();
        echo json_encode(['success' => false, 'message' => 'RSVP dengan nama dan hubungan yang sama sudah wujud. Jika anda orang yang berbeza, sila tulis nama lengkap atau hubungan yang lebih spesifik.']);
        exit;
    }
    
    // Insert RSVP data
    $insert_query = "INSERT INTO rsvp_guests (nama, jumlah_pax, hubungan, status) 
                     VALUES ('$nama', $jumlah_pax, '$hubungan', '$status')";
    
    if (mysqli_query($connection, $insert_query)) {
        // Update the old counter table for backward compatibility
        if ($status == 'hadir') {
            mysqli_query($connection, "UPDATE kehadiran SET jumlah_kehadiran = jumlah_kehadiran + $jumlah_pax WHERE id = 1");
        } else {
            mysqli_query($connection, "UPDATE kehadiran SET jumlah_tidak_hadir = jumlah_tidak_hadir + $jumlah_pax WHERE id = 1");
        }
        
        $status_text = ($status == 'hadir') ? 'kehadiran' : 'ketidakhadiran';
        
        // Clean output buffer to ensure clean JSON
        ob_clean();
        
        echo json_encode([
            'success' => true, 
            'message' => "Terima kasih $nama! $status_text anda untuk $jumlah_pax orang telah disahkan."
        ]);
    } else {
        // Clean output buffer to ensure clean JSON
        ob_clean();
        
        echo json_encode(['success' => false, 'message' => 'Ralat semasa menyimpan data: ' . mysqli_error($connection)]);
    }
    
    mysqli_close($connection);
} else {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>