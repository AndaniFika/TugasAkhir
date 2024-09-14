<?php

// Ambil data siswa dari database
$user_id = $_SESSION['users_id'];
$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $user_name = htmlspecialchars($user['username']); // Ganti dengan nama siswa jika ada kolom nama
} else {
    $user_name = "Siswa";
}

// Cek koneksi database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil pengumuman
$sql_announcements = "SELECT * FROM announcements ORDER BY id DESC";
$result_announcements = $conn->query($sql_announcements);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .announcement-card {
            margin-bottom: 20px;
        }

        .announcement-content {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .header {
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header mb-4">
            <h2>Selamat datang, <?php echo $user_name; ?></h2>
        </div>

        <div class="container">
            <h3 class="text-center mb-4">Pengumuman</h3>
            <div class="row">
                <?php while ($row = $result_announcements->fetch_assoc()) : ?>
                    <div class="col-md-12">
                        <div class="card announcement-card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Diposting: <?php echo htmlspecialchars($row['created_at']); ?></h6>
                                <p class="card-text announcement-content"><?php echo htmlspecialchars($row['content']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>