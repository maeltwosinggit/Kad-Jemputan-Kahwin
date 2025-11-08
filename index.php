<!-- Connect DB -->
<?php
// Load configuration
include 'config.php';

$connection = mysqli_connect($servername, $username, $password);

if (!$connection) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Check if Database Not Exists Then Create The Database, But If Exists Then Proceed
if (!mysqli_fetch_row(mysqli_query($connection, "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'"))) {
    mysqli_query($connection, "CREATE DATABASE " . $database);
}

// New Connection If Database is Created
$connection = mysqli_connect($servername, $username, $password, $database);

$query1 = mysqli_query($connection, "SHOW TABLES LIKE 'ucapan_kahwin'");

// Create Table if Does Not Exists
if (mysqli_num_rows($query1) == 0) {
    $table_ucapan = "CREATE TABLE `ucapan_kahwin` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama_tetamu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `ucapan_tetamu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    mysqli_query($connection, $table_ucapan);
}

$query2 = mysqli_query($connection, "SHOW TABLES LIKE 'kehadiran'");

// Create Table if Does Not Exists
if (mysqli_num_rows($query2) == 0) {
    $table_kehadiran = "CREATE TABLE `kehadiran` (
    `id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
    `jumlah_kehadiran` int UNSIGNED NOT NULL,
    `jumlah_tidak_hadir` int UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    mysqli_query($connection, $table_kehadiran);

    // Insert Data
    $seeder = "INSERT INTO kehadiran (id, jumlah_kehadiran, jumlah_tidak_hadir) VALUES (1, 0, 0)";
    mysqli_query($connection, $seeder);
}

// Create RSVP Guests Table
$query3 = mysqli_query($connection, "SHOW TABLES LIKE 'rsvp_guests'");

if (mysqli_num_rows($query3) == 0) {
    $table_rsvp = "CREATE TABLE `rsvp_guests` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `jumlah_pax` int UNSIGNED NOT NULL,
    `hubungan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `status` enum('hadir','tidak_hadir') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    mysqli_query($connection, $table_rsvp);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css Vendor -->
    <link rel="stylesheet" href="./css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="./images/logo.png" />
    <title><?php echo $Lelaki_Short; ?> & <?php echo $Perempuan_Short; ?></title>
</head>

<body>
    <div class="wrapper">
        <div id="overlay" class="overlay">
            <div class="overlay-content">
                <button id="toggle-content" class="toggle-button">
                    <img src="./images/Amirul & Pasangan Monogram (1).svg" alt="<?php echo $Lelaki_Short; ?> & <?php echo $Perempuan_Short; ?> Monogram" class="monogram">
                    <!-- <p class="buka">Open</p> -->
                </button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="petal-container"></div>
        <!-- Intro Section -->
        <section class="intro">
            <div class="content">
                <!-- <img src="./images/bismillah.png" alt="" class="fade-top-1"> -->
                <p class="title fade-top-2">The Wedding of</p>
                <h2 class="fade-top-3"><?php echo $Lelaki_Short; ?></h2>
                <h3 class="fade-top-3">&</h3>
                <h2 class="fade-top-3"><?php echo $Perempuan_Short; ?></h2>
                <p class="date fade-top-4">
                    <span><?php echo $Wedding_Date_Malay; ?></span>
                    <span>|</span>
                    <span><?php echo $Wedding_Date_Full; ?></span>
                </p>
                <h4 class="fade-top-3">#amiracleforamirul</h4>
            </div>
        </section>

        <!-- Event Info Section -->
        <section class="info">
            <img src="./images/bismillah.png" alt="" class="assalamualaikum reveal fade-bottom">
            <div class="event-info reveal fade-bottom">
                <div class="one">
                    <p>With Joy and Gratitude to Almighty God</p>
                    <div class="parent">
                        <p><?php echo $Parents_Male_1; ?></p>
                        <p>&</p>
                        <p><?php echo $Parents_Female_1; ?></p>
                    </div>
                    <p>cordially invite</p>
                    <p>Yang Berbahagia Tan Sri | Puan Sri | Dato’ Seri | Datin Seri | Dato’| Datin</p>
                    <p>Mr. | Mrs. | Miss</p>
                    <p>to the wedding reception of our son and daughter</p>
                </div>
                <div class="two">
                    <p><?php echo $Lelaki_Long; ?></p>
                    <p>&</p>
                    <p><?php echo $Perempuan_Long; ?></p>
                </div>
                <div class="three">
                    <p class="title">Venue</p>
                    <p class="venue-name"><?php echo $Venue_Address_Line1; ?></p>
                    <p><?php echo $Venue_Address_Line2; ?></p>
                    <p><?php echo $Venue_Address_Line3; ?></p>
                </div>
                <div class="four">
                    <p class="title">Date</p>
                    <p><?php echo $Wedding_Date_Full_Month; ?></p>
                    <p>Bersamaan <?php echo $Wedding_Date_Hijri; ?></p>
                </div>
                <div class="five">
                    <p class="title">Time</p>
                    <p><?php echo $Wedding_Time; ?></p>
                </div>
                <div class="six">
                    <p class="title">Dress Code</p>
                    <p><?php echo $Wedding_Dress_Code; ?></p>
                </div>
                <div class="save-date">
                    <button id="save-date-btn" class="btn-save-date">
                        Save The Date
                    </button>
                </div>
            </div>
            <!-- Aturcara & Countdown Section -->
            <div class="countdown reveal fade-bottom">
                <!-- Countdown Timer -->
                <div class="hero connect-page">
                    <div class="container">
                        <div class="hero-body">
                            <div class="campaign campaign-0" data-wedding-date="<?php echo $Wedding_Date_ISO; ?>">
                                <div class="counter timer">
                                    <span class="title">Counting Days</span>
                                    <div class="counter-boxes">
                                        <div class="count-box">
                                            <h1 class="value day">0</h1>
                                            <span>Days</span>
                                        </div>
                                        <div class="count-box">
                                            <h1 class="value hour">0</h1>
                                            <span>Hours</span>
                                        </div>
                                        <div class="count-box">
                                            <h1 class="value minute">0</h1>
                                            <span>Minutes</span>
                                        </div>
                                        <div class="count-box">
                                            <h1 class="value second">0</h1>
                                            <span>Seconds</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Aturcara -->
            <div class="aturcara reveal fade-bottom">
                <h2 class="programme-title">PROGRAMME</h2>
                <div class="programme-content">
                    <div class="programme-item">
                        <p class="event-name"><?php echo $Programme_Event1_Name; ?> :</p>
                        <p class="event-time"><?php echo $Programme_Event1_Time; ?></p>
                    </div>
                    <div class="programme-item">
                        <p class="event-name"><?php echo $Programme_Event2_Name; ?> :</p>
                        <p class="event-time"><?php echo $Programme_Event2_Time; ?></p>
                    </div>
                </div>
            </div>
            <!-- Doa -->
            <div class="doa-info reveal fade-bottom">
                <img src="./images/Doa.png" alt="" class="doa-info reveal fade-bottom">
            </div>
            <!-- <div class="ucapan reveal fade-bottom">
                <div class="container">
                    <img src="./images/ucapan-bg.png" alt="">
                    <div class="content">
                        <p>Ya Allah, berkatilah majlis perkahwinan ini, limpahkan baraqah dan rahmat kepada kedua
                            mempelai ini,
                            Kurniakanlah mereka
                            zuriat yang soleh dan solehah. Kekalkanlah jodoh mereka di dunia dan di akhirat dan
                            sempurnakanlah
                            agama mereka dengan
                            berkat ikatan ini.</p>
                    </div>
                </div>
            </div> -->
            <!-- <img src="./images/divider.png" alt="" class="divider reveal fade-bottom"> -->
            
            <!-- Attendance Section -->
            <div class="attendance reveal fade-bottom">
                <h2 class="attendance-title">ATTENDANCE</h2>
                <div class="attendance-stats">
                    <?php
                    // Get attendance counts from database
                    $connection = mysqli_connect($servername, $username, $password, $database);
                    
                    if ($connection) {
                        // Get attendance counts
                        $query = mysqli_query($connection, "SELECT jumlah_kehadiran, jumlah_tidak_hadir FROM kehadiran WHERE id = 1");
                        
                        if ($query && mysqli_num_rows($query) > 0) {
                            $row = mysqli_fetch_assoc($query);
                            $attending = $row['jumlah_kehadiran'];
                            $notAttending = $row['jumlah_tidak_hadir'];
                        } else {
                            $attending = 0;
                            $notAttending = 0;
                        }
                        
                        mysqli_close($connection);
                    } else {
                        $attending = 0;
                        $notAttending = 0;
                    }
                    ?>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $attending; ?></div>
                        <div class="stat-label">Attending</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $notAttending; ?></div>
                        <div class="stat-label">Not Attending</div>
                    </div>
                </div>
            </div>
            
            <!-- Wishes Section -->
            <div class="wishes reveal fade-bottom">
                <h2 class="wishes-title">WISHES</h2>
                <div class="wishes-container">
                    <?php
                    // Reconnect to database for wishes
                    $connection = mysqli_connect($servername, $username, $password, $database);
                    $query = mysqli_query($connection, "SELECT * FROM ucapan_kahwin ORDER BY id DESC LIMIT 6");

                    if ($query && mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            $name = $row["nama_tetamu"];
                            $message = $row["ucapan_tetamu"];
                            
                            echo '<div class="wish-item">';
                            echo '<p class="wish-message">"' . htmlspecialchars($message) . '"</p>';
                            echo '<p class="wish-author">— ' . htmlspecialchars($name) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        // Sweet placeholder when no wishes exist
                        echo '<div class="no-wishes-placeholder">';
                        echo '<p>✨ No wishes yet! ✨</p>';
                        echo '<p class="sub-text">Be the first to share your beautiful wishes for the happy couple</p>';
                        echo '</div>';
                    }
                    
                    mysqli_close($connection);
                    ?>
                </div>
                <div class="wishes-buttons">
                    <button id="rsvp-wish-btn" class="wish-btn primary">
                        <i class='bx bx-check-circle'></i>
                        <span>RSVP NOW</span>
                    </button>
                    <button id="write-message-btn" class="wish-btn secondary">
                        <i class='bx bx-edit-alt'></i>
                        <span>WRITE A MESSAGE</span>
                    </button>
                </div>
            </div>
            <!-- Ucapan  -->
            <div class="thanks-info reveal fade-bottom">
                <img src="./images/ThanksSpeech.png" alt="" class="thanks-info reveal fade-bottom">
            </div>

            <!-- Branding Section -->
            <div class="branding reveal fade-bottom">
                <p class="created-by">Created by</p>
                <div class="brand-logo">
                    <img src="./images/Fotomovement.png" alt="Fotomovement" class="logo">
                </div>
            </div>
        </section>
    </div>

    <!-- Footer moved outside of card for proper fixed positioning -->
    <section class="footer">
        <ul class="menu">
            <li id="calendar-btn"><i class='bx bx-calendar'></i></li>
            <li id="location-btn"><i class='bx bx-map'></i></li>
            <li id="music-btn"><i class='bx bx-music'></i></li>
            <li id="rsvp-btn"><i class='bx bx-envelope'></i></li>
            <li id="contact-btn"><i class='bx bx-phone'></i></li>
        </ul>
    </section>

    <!-- Bottom Modal -->
    <div id="calendar-menu" class="toggle-menu">
            <div class="calendar">
            <h1>Calendar</h1>
            <p>
                <span><?php echo $Wedding_Date_Full; ?></span>
                <span>|</span>
                <span><?php echo $Wedding_Date_Hijri; ?></span>
            </p>
            <div class="button">
                <button class="google" onclick="addGoogleCalendar()">
                    <i class='bx bxl-google'></i>
                    <span>Add to Calendar</span>
                </button>
                <button class="apple" onclick="addAppleCalendar()">
                    <i class='bx bxl-apple'></i>
                    <span>Add to Calendar</span>
                </button>
            </div>
        </div>
    </div>

    <div id="location-menu" class="toggle-menu">
        <div class="location">
            <h1>Location</h1>
            <p><?php echo $Venue_Address_Line1; ?></p>
            <p><?php echo $Venue_Address_Line2; ?></p>
            <p><?php echo $Venue_Address_Line3; ?></p>
            <div class="button">
                <button class="google" onclick="openGoogleMapsWithAddress('<?php echo urlencode($Venue_Address_Line1 . ', ' . $Venue_Address_Line2 . ', ' . $Venue_Address_Line3); ?>')">
                    <i class='bx bxl-google'></i>
                    <span>Maps</span>
                </button>
                <button class="waze" onclick="openWazeWithAddress('<?php echo urlencode($Venue_Address_Line1 . ', ' . $Venue_Address_Line2 . ', ' . $Venue_Address_Line3); ?>')">
                    <i class="fa-brands fa-waze"></i>
                    <span>Waze</span>
                </button>
            </div>
        </div>
    </div>

    <div id="music-menu" class="toggle-menu">
        <div class="music">
            <h1>Music</h1>
            <p>Billie Eilish - Ocean Eyes</p>
            <!-- <p>(Piano Cover by Riyandi Kusuma)</p> -->
            <audio id="audio-player" controls autoplay loop>
                <source type="audio/mp3" src="./music/Billie Eilish - ocean eyes.mp3">
            </audio>
        </div>
    </div>

    <div id="rsvp-menu" class="toggle-menu">
        <div class="rsvp">
            <h1>RSVP</h1>
            <form id="form-rsvp" class="form-rsvp" action="process_rsvp.php" method="POST">
                <label for="rsvp-nama">Your Name</label>
                <input type="text" name="nama" id="rsvp-nama" placeholder="Full Name" required>

                <label for="rsvp-pax">Total Pax</label>
                <input type="number" name="jumlah_pax" id="rsvp-pax" placeholder="How many people?" min="1" max="20" required>

                <label for="rsvp-hubungan">Relationship with the Bride/Groom</label>
                <input type="text" name="hubungan" id="rsvp-hubungan" placeholder="E.g: Friend, Family, Colleague" required>

                <div class="button">
                    <button type="submit" name="status" value="hadir" class="btn-hadir">
                        <i class='bx bx-check'></i>
                        <span>Count Me In!</span>
                    </button>
                    <button type="submit" name="status" value="tidak_hadir" class="btn-tidak-hadir">
                        <i class='bx bx-x'></i>
                        <span>Sorry, Can't Make It</span>
                    </button>
                    <!-- <button type="button" class="tutup">
                        <i class='bx bx-x'></i>
                        <span>Close</span>
                    </button> -->
                </div>
            </form>
        </div>
    </div>

    <div id="contact-menu" class="toggle-menu">
        <div class="contact">
            <h1>Contact Persons</h1>
            <div class="content">
                <div class="person">
                    <div class="first-section">
                        <i class='bx bxs-user-circle'></i>
                        <div class="name">
                            <span>Mr Roslee</span>
                            <!-- <span>Groom's Father</span> -->
                        </div>
                    </div>
                    <div class="second-section">
                        <button onclick="makePhoneCall('+60193219794')"><i class='bx bx-phone'></i></button>
                        <button onclick="openWhatsApp('+60193219794')"><i class='bx bxl-whatsapp'></i></button>
                    </div>
                </div>
                <div class="person">
                    <div class="first-section">
                        <i class='bx bxs-user-circle'></i>
                        <div class="name">
                            <span>Amirul (Along)</span>
                            <!-- <span>Along</span> -->
                        </div>
                    </div>
                    <div class="second-section">
                        <button onclick="makePhoneCall('+60186626786')"><i class='bx bx-phone'></i></button>
                        <button onclick="openWhatsApp('+60186626786')"><i class='bx bxl-whatsapp'></i></button>
                    </div>
                </div>
                <div class="person">
                    <div class="first-section">
                        <i class='bx bxs-user-circle'></i>
                        <div class="name">
                            <span>Rashif (Angah)</span>
                            <!-- <span>Angah</span> -->
                        </div>
                    </div>
                    <div class="second-section">
                        <button onclick="makePhoneCall('+60193609094')"><i class='bx bx-phone'></i></button>
                        <button onclick="openWhatsApp('+60193609094')"><i class='bx bxl-whatsapp'></i></button>
                    </div>
                </div>
                <div class="person">
                    <div class="first-section">
                        <i class='bx bxs-user-circle'></i>
                        <div class="name">
                            <span>Rahimy (Amy)</span>
                            <!-- <span>Amy> -->
                        </div>
                    </div>
                    <div class="second-section">
                        <button onclick="makePhoneCall('+60166050181')"><i class='bx bx-phone'></i></button>
                        <button onclick="openWhatsApp('+60166050181')"><i class='bx bxl-whatsapp'></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ucapan-menu" class="toggle-menu">
        <div class="ucapan-tetamu">
            <h1>Send your wishes</h1>
            <form id="form-ucapan" class="form-ucapan" action="insert_message.php" method="POST">
                <label for="name">Your Name</label>
                <input type="text" name="name" placeholder="Your Name..." required>

                <label for="ucapan">Message</label>
                <textarea name="message" id="ucapan" cols="30" rows="10" placeholder="Congratulations on your wedding! Wishing you a lifetime of love and happiness..." required></textarea>

                <div class="button">
                    <button type="submit" class="hantar" id="hantar">
                        <i class='bx bxs-paper-plane'></i>
                        <span>Send</span>
                    </button>
                    <button class="tutup">
                        <i class='bx bx-x'></i>
                        <span>Close</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- This container will hold the success message and will be dynamically populated -->
    <div id="success-menu" class="toggle-menu"></div>


    <!-- Js Vendor -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tsparticles/1.18.11/tsparticles.min.js"> </script>

    <!-- Calendar Configuration from PHP -->
    <script src="./calendar_config.js.php"></script>
    
    <!-- Custom Js -->
    <script src="./js/main.js"></script>
</body>

</html>