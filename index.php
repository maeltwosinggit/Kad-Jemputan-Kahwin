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
            </div>
        </section>

        <!-- Event Info Section -->
        <section class="info">
            <!-- <img src="./images/assalamualaikum-3.png" alt="" class="assalamualaikum reveal fade-bottom"> -->
            <div class="event-info reveal fade-bottom">
                <div class="one">
                    <p>With Joy and Gratitude to Almighty God</p>
                    <div class="parent">
                        <p><?php echo $Parents_Male_1; ?></p>
                        <p>&</p>
                        <p><?php echo $Parents_Female_1; ?></p>
                    </div>
                    <p>cordially invite</p>
                    <p>Yang Berbahagia Tan Sri | Puan Sri | Dato’ Seri | Datin Seri | Dato’| Datin | Mr. | Mrs. | Miss</p>
                    <p>to the wedding reception of our son and daughter</p>
                </div>
                <div class="two">
                    <p><?php echo $Lelaki_Long; ?></p>
                    <p>&</p>
                    <p><?php echo $Perempuan_Long; ?></p>
                </div>
                <div class="three">
                    <p class="title">Venue</p>
                    <p><?php echo $Venue_Address_Line1; ?></p>
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
            </div>
            <!-- Aturcara & Countdown Section -->
            <div class="countdown reveal fade-bottom">
                <!-- Countdown Timer -->
                <div class="hero connect-page">
                    <div class="container">
                        <div class="hero-body">
                            <div class="campaign campaign-0" data-wedding-date="<?php echo $Wedding_Date_ISO; ?>">
                                <div class="counter timer">
                                    <span class="title">Menghitung hari</span>
                                    <div class="counter-boxes">
                                        <div class="count-box">
                                            <h1 class="value day">0</h1>
                                            <span>Hari</span>
                                        </div>
                                        <div class="count-box">
                                            <h1 class="value hour">0</h1>
                                            <span>Jam</span>
                                        </div>
                                        <div class="count-box">
                                            <h1 class="value minute">0</h1>
                                            <span>Minit</span>
                                        </div>
                                        <div class="count-box">
                                            <h1 class="value second">0</h1>
                                            <span>Saat</span>
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
                <p class="title">aturcara majlis</p>
                <div class="one">
                    <p>Kehadiran Tetamu</p>
                    <p>11:30 Pagi</p>
                </div>
                <div class="two">
                    <p>Ketibaan Pengantin</p>
                    <p>1:00 Petang</p>
                </div>
                <div class="three">
                    <p>Makan Beradab</p>
                    <p>1:30 Petang</p>
                </div>
                <div class="four">
                    <p>Majlis Bersurai</p>
                    <p>4:00 Petang</p>
                </div>
            </div>
            <div class="ucapan reveal fade-bottom">
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
            </div>
            <img src="./images/divider.png" alt="" class="divider reveal fade-bottom">
            <div class="rsvp">
                <h2 class="reveal fade-bottom">Ucapan</h2>
                <div class="container-message reveal fade-bottom">
                    <?php
                    $query = mysqli_query($connection, "SELECT * FROM ucapan_kahwin");

                    if ($query) {
                        $hasData = false; // Flag to indicate if there is data

                        while ($row = mysqli_fetch_assoc($query)) {
                            $hasData = true;
                            $id = $row["id"];
                            $name = $row["nama_tetamu"];
                            $message = $row["ucapan_tetamu"];

                            echo '<div class="content">';
                            echo '<p class="name">' . $name . '</p>';
                            echo '<p class="message">' . $message . '</p>';
                            echo '</div>';
                        }

                        if (!$hasData) { // If there's no data, display dummy content
                            echo '<div class="content-empty">';
                            echo '<p class="empty-message">Tiada ucapan lagi. Silalah beri ucapan kepada dua mempelai ini!</p>';
                            echo '</div>';
                        }
                    } else {
                        // Handle error with the query
                        echo "Error querying the database: " . mysqli_error($connection);
                    }

                    mysqli_close($connection);

                    ?>
                    <!-- <div class="content">
                        <p class="name">Anonymous</p>
                        <p class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin auctor velit
                            in tincidunt vehicula. Nam fermentum
                            finibus
                            purus, id vulputate nibh rhoncus vel.</p>
                    </div> -->
                </div>
                <div class="beri-ucapan-button reveal fade-bottom">
                    <button id="kehadiran-btn">
                        <i class='bx bxs-check-square'></i>
                        <span>Sahkan Kehadiran</span>
                    </button>
                    <button id="ucapan-btn">
                        <i class='bx bxs-pen'></i>
                        <span>Berikan Ucapan</span>
                    </button>
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
            <h1>Lokasi</h1>
            <p>10A Jalan Seri Ampang 2</p>
            <p>Kampung Pisang</p>
            <p>47300 Subang, Selangor</p>
            <div class="button" onclick="openGoogleMaps()">
                <button class="google">
                    <i class='bx bxl-google'></i>
                    <span>Maps</span>
                </button>
                <button class="waze" onclick="openWaze()">
                    <i class="fa-brands fa-waze"></i>
                    <span>Waze</span>
                </button>
            </div>
        </div>
    </div>

    <div id="music-menu" class="toggle-menu">
        <div class="music">
            <h1>Lagu</h1>
            <p>Beautiful in White x Canon in D</p>
            <p>(Piano Cover by Riyandi Kusuma)</p>
            <audio id="audio-player" controls autoplay loop>
                <source type="audio/mp3" src="./music/Beautiful in White x Canon in D (Piano Cover by Riyandi Kusuma).mp3">
            </audio>
        </div>
    </div>

    <div id="rsvp-menu" class="toggle-menu">
        <div class="rsvp">
            <h1>RSVP - Sahkan Kehadiran</h1>
            <form id="form-rsvp" class="form-rsvp" action="process_rsvp.php" method="POST">
                <label for="rsvp-nama">Nama Anda</label>
                <input type="text" name="nama" id="rsvp-nama" placeholder="Nama Penuh" required>

                <label for="rsvp-pax">Jumlah Pax</label>
                <input type="number" name="jumlah_pax" id="rsvp-pax" placeholder="Berapa orang?" min="1" max="20" required>

                <label for="rsvp-hubungan">Hubungan dengan Pengantin</label>
                <input type="text" name="hubungan" id="rsvp-hubungan" placeholder="Cth: Kawan, Keluarga, Rakan Kerja" required>

                <div class="button">
                    <button type="submit" name="status" value="hadir" class="btn-hadir">
                        <i class='bx bx-check'></i>
                        <span>Hadir</span>
                    </button>
                    <button type="submit" name="status" value="tidak_hadir" class="btn-tidak-hadir">
                        <i class='bx bx-x'></i>
                        <span>Tidak Hadir</span>
                    </button>
                    <button type="button" class="tutup">
                        <i class='bx bx-x'></i>
                        <span>Tutup</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="contact-menu" class="toggle-menu">
        <div class="contact">
            <h1>Hubungi</h1>
            <div class="content">
                <div class="person">
                    <div class="first-section">
                        <i class='bx bxs-user-circle'></i>
                        <div class="name">
                            <span>Ali</span>
                            <span>Bapa Pengantin Lelaki</span>
                        </div>
                    </div>
                    <div class="second-section">
                        <button onclick="makePhoneCall('+60123456789')"><i class='bx bx-phone'></i></button>
                        <button onclick="openWhatsApp('+60123456789')"><i class='bx bxl-whatsapp'></i></button>
                    </div>
                </div>
                <div class="person">
                    <div class="first-section">
                        <i class='bx bxs-user-circle'></i>
                        <div class="name">
                            <span>Miya Kasim</span>
                            <span>Ibu Pengantin Lelaki</span>
                        </div>
                    </div>
                    <div class="second-section">
                        <button onclick="makePhoneCall('+60123456789')"><i class='bx bx-phone'></i></button>
                        <button onclick="openWhatsApp('+60123456789')"><i class='bx bxl-whatsapp'></i></button>
                    </div>
                </div>
                <div class="person">
                    <div class="first-section">
                        <i class='bx bxs-user-circle'></i>
                        <div class="name">
                            <span>Xavier Hunter</span>
                            <span>Adik Pengantin Lelaki</span>
                        </div>
                    </div>
                    <div class="second-section">
                        <button onclick="makePhoneCall('+60123456789')"><i class='bx bx-phone'></i></button>
                        <button onclick="openWhatsApp('+60123456789')"><i class='bx bxl-whatsapp'></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ucapan-menu" class="toggle-menu">
        <div class="ucapan-tetamu">
            <h1>Sampaikan Ucapan</h1>
            <form id="form-ucapan" class="form-ucapan" action="insert_message.php" method="POST">
                <label for="name">Nama Anda</label>
                <input type="text" name="name" placeholder="Uzumaki Naruto" required>

                <label for="ucapan">Ucapan</label>
                <textarea name="message" id="ucapan" cols="30" rows="10" placeholder="Selemat pengantin baru..." required></textarea>

                <div class="button">
                    <button type="submit" class="hantar" id="hantar">
                        <i class='bx bxs-paper-plane'></i>
                        <span>Hantar</span>
                    </button>
                    <button class="tutup">
                        <i class='bx bx-x'></i>
                        <span>Tutup</span>
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

    <!-- Custom Js -->
    <script src="./js/main.js"></script>
</body>

</html>