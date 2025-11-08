<?php
// Load configuration
include 'config.php';

// Set content type to JavaScript
header('Content-Type: application/javascript');

// Parse wedding time to get start and end times
$time_parts = explode(' - ', $Wedding_Time);
$start_time = isset($time_parts[0]) ? trim($time_parts[0]) : '11:00 AM';
$end_time = isset($time_parts[1]) ? trim($time_parts[1]) : '4:00 PM';

// Convert times to 24-hour format for calendar
function convertTo24Hour($time) {
    return date('H:i', strtotime($time));
}

$start_24h = convertTo24Hour($start_time);
$end_24h = convertTo24Hour($end_time);

// Create ISO datetime strings for calendar 
// Note: Using local time (Malaysia is UTC+8, but for calendar events we'll use local time)
$start_datetime = $Wedding_Date_ISO . 'T' . str_replace(':', '', $start_24h) . '00';
$end_datetime = $Wedding_Date_ISO . 'T' . str_replace(':', '', $end_24h) . '00';

// For Google Calendar, we need UTC time format
// Malaysia is UTC+8, so subtract 8 hours for UTC
$start_utc = date('Ymd\THis\Z', strtotime($Wedding_Date_ISO . ' ' . $start_24h . ' -8 hours'));
$end_utc = date('Ymd\THis\Z', strtotime($Wedding_Date_ISO . ' ' . $end_24h . ' -8 hours'));

// Create full venue address
$full_address = $Venue_Address_Line1 . ', ' . $Venue_Address_Line2 . ', ' . $Venue_Address_Line3;

// Create wedding title
$wedding_title = "Wedding Invitation " . $Lelaki_Short . " & " . $Perempuan_Short;

// Create wedding description
$wedding_description = "We cordially invite you to the wedding celebration of " . $Lelaki_Short . " & " . $Perempuan_Short . ". Time: " . $Wedding_Time . ". Venue: " . $full_address;

// Output JavaScript variables
?>
// Wedding event configuration from PHP
window.weddingEventConfig = {
    title: "<?php echo addslashes($wedding_title); ?>",
    startDate: "<?php echo $start_utc; ?>",
    endDate: "<?php echo $end_utc; ?>",
    location: "<?php echo addslashes($full_address); ?>",
    description: "<?php echo addslashes($wedding_description); ?>",
    groomName: "<?php echo addslashes($Lelaki_Short); ?>",
    brideName: "<?php echo addslashes($Perempuan_Short); ?>",
    weddingDate: "<?php echo addslashes($Wedding_Date_Full_Month); ?>",
    weddingTime: "<?php echo addslashes($Wedding_Time); ?>",
    venue: "<?php echo addslashes($full_address); ?>"
};

console.log('Wedding event config loaded:', window.weddingEventConfig);