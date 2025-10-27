<?php
// ===============================================
// WEDDING INVITATION CONFIGURATION
// ===============================================
// Edit these variables to customize your invitation

// BRIDE & GROOM NAMES
$Lelaki_Long = "Amirul Masri Bin Mohamed Shariefudin";          // Full name of the groom
$Lelaki_Short = "Amirul";               // Short name of the groom  
$Perempuan_Long = "Amirah Roslina Binti Roslee";       // Full name of the bride
$Perempuan_Short = "Amirah";          // Short name of the bride

// WEDDING DATE & TIME
$Wedding_Date_Malay = "SATURDAY";         // Day in Malay (Isnin, Selasa, Rabu, Khamis, Jumaat, Sabtu, Ahad)
$Wedding_Date_Full = "13.12.2025"; // Full date in Malay
$Wedding_Date_Full_Month = "13th December, 2025"; // Full date in Malay
$Wedding_Date_ISO = "2025-12-13";       // Date in YYYY-MM-DD format for countdown
$Wedding_Date_Hijri = "22 Jamadilakhir 1446H"; // Hijri date (editable)
$Wedding_Time = "11:00 AM - 4:00 PM";    // Time range

// VENUE DETAILS
$Venue_Address_Line1 = "Dewan Tengku Zara";
$Venue_Address_Line2 = "15, Jalan 15/23, Seksyen 1";
$Venue_Address_Line3 = "40200 Shah Alam, Selangor";

// PARENTS NAMES
$Parents_Male_1 = "Keluarga Roslee bin Hanan";        // Groom's father
$Parents_Female_1 = "Keluarga Mohamed Shariefudin bin Alias"; // Groom's mother

// PROGRAMME DETAILS
$Programme_Event1_Name = "Lunch";
$Programme_Event1_Time = "11:00 am - 5:00 pm";
$Programme_Event2_Name = "The Arrival of Bride & Groom";
$Programme_Event2_Time = "12:30 pm";

// ==============================================
// SECURE DATABASE CONFIGURATION
// ==============================================

// Detect environment automatically
$isLocal = ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1' || strpos($_SERVER['SERVER_NAME'], '.local') !== false);

if ($isLocal) {
    // LOCAL DEVELOPMENT
    $servername = "127.0.0.1:3306";
    $username = "root";
    $password = "";
    $database = "kad_kahwin";
} else {
    // PRODUCTION - Load from external config file
    if (file_exists('db_config.php')) {
        include 'db_config.php';
    } else {
        // Fallback - you'll create db_config.php manually on production server
        die('Database configuration file not found. Please create db_config.php on the server.');
    }
}

