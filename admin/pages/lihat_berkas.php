<?php

// Ambil users_id dari URL
$users_id = $_GET['id'];

// Query untuk mendapatkan berkas siswa berdasarkan users_id
$sql = "SELECT * FROM berkas WHERE users_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $users_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Ambil data siswa untuk informasi tambahan
$sql_siswa = "SELECT nama FROM siswa WHERE users_id = ?";
$stmt_siswa = $conn->prepare($sql_siswa);
$stmt_siswa->bind_param("i", $users_id);
$stmt_siswa->execute();
$result_siswa = $stmt_siswa->get_result();

if ($result_siswa->num_rows == 1) {
    $row_siswa = $result_siswa->fetch_assoc();
    $nama_siswa = $row_siswa['nama'];
} else {
    die("Data siswa tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Berkas Siswa</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 40px;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .btn-back {
            margin-bottom: 20px;
        }

        .table {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
        }

        .table td {
            text-align: center;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .alert {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Berkas: <?= htmlspecialchars($nama_siswa) ?></h2>
        </div>

        <a href="index.php?page=data_siswa" class="btn btn-secondary btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <?php if ($result->num_rows > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nama Berkas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td>Ijazah</td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['ijazah']) ?>" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>SKHUN</td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['skhun']) ?>" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Kartu Keluarga</td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['kk']) ?>" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>KTP Ayah</td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['ktp_ayah']) ?>" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>KTP Ibu</td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['ktp_ibu']) ?>" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Kartu Bantuan Sosial</td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['kbs']) ?>" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                Tidak ada berkas yang diunggah untuk siswa ini.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$stmt_siswa->close();
$conn->close();
?>