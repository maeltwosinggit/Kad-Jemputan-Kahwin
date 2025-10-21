<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Admin - Guest List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .stat-card {
            background: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            min-width: 150px;
            margin: 10px;
        }
        .stat-card.attending { background: #28a745; }
        .stat-card.not-attending { background: #dc3545; }
        .stat-card h3 { margin: 0; font-size: 2em; }
        .stat-card p { margin: 5px 0 0 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .status-hadir {
            background-color: #d4edda;
            color: #155724;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .status-tidak-hadir {
            background-color: #f8d7da;
            color: #721c24;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .timestamp {
            color: #666;
            font-size: 0.9em;
        }
        @media (max-width: 768px) {
            table { font-size: 0.9em; }
            .stats { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 RSVP Guest List</h1>
        
        <?php
        // Load configuration
        include 'config.php';
        
        // Connect to database
        $connection = mysqli_connect($servername, $username, $password, $database);
        
        if (!$connection) {
            die("Connection Failed: " . mysqli_connect_error());
        }
        
        // Get statistics
        $stats_query = "SELECT 
            COUNT(*) as total_responses,
            SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as total_attending,
            SUM(CASE WHEN status = 'tidak_hadir' THEN 1 ELSE 0 END) as total_not_attending,
            SUM(CASE WHEN status = 'hadir' THEN jumlah_pax ELSE 0 END) as total_pax_attending,
            SUM(CASE WHEN status = 'tidak_hadir' THEN jumlah_pax ELSE 0 END) as total_pax_not_attending
            FROM rsvp_guests";
            
        $stats_result = mysqli_query($connection, $stats_query);
        $stats = mysqli_fetch_assoc($stats_result);
        ?>
        
        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $stats['total_responses']; ?></h3>
                <p>Total Responses</p>
            </div>
            <div class="stat-card attending">
                <h3><?php echo $stats['total_attending']; ?></h3>
                <p>Will Attend (<?php echo $stats['total_pax_attending']; ?> pax)</p>
            </div>
            <div class="stat-card not-attending">
                <h3><?php echo $stats['total_not_attending']; ?></h3>
                <p>Cannot Attend (<?php echo $stats['total_pax_not_attending']; ?> pax)</p>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Jumlah Pax</th>
                    <th>Hubungan</th>
                    <th>Status</th>
                    <th>Tarikh Daftar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Get all RSVP entries
                $query = "SELECT * FROM rsvp_guests ORDER BY created_at DESC";
                $result = mysqli_query($connection, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status_class = $row['status'] == 'hadir' ? 'status-hadir' : 'status-tidak-hadir';
                        $status_text = $row['status'] == 'hadir' ? '✅ Hadir' : '❌ Tidak Hadir';
                        
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td><strong>" . htmlspecialchars($row['nama']) . "</strong></td>";
                        echo "<td>" . $row['jumlah_pax'] . " orang</td>";
                        echo "<td>" . htmlspecialchars($row['hubungan']) . "</td>";
                        echo "<td><span class='$status_class'>$status_text</span></td>";
                        echo "<td class='timestamp'>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center; color: #666;'>Tiada RSVP lagi.</td></tr>";
                }
                
                mysqli_close($connection);
                ?>
            </tbody>
        </table>
        
        <div style="margin-top: 30px; text-align: center; color: #666;">
            <p>📱 <a href="index.php">Kembali ke Kad Jemputan</a></p>
        </div>
    </div>
</body>
</html>