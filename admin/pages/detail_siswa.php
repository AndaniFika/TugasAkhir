<?php

// Ambil users_id dari URL dan pastikan valid
$users_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mendapatkan data siswa dan orang tua berdasarkan users_id
$sql = "SELECT o.nama_ayah, o.alamat_ayah, o.telepon_ayah, o.pekerjaan_ayah, o.nama_ibu, o.alamat_ibu, o.telepon_ibu, o.pekerjaan_ibu, 
               s.nama AS nama_siswa, s.nomor_induk, s.nisn, s.tempat_lahir, s.tanggal_lahir, s.jenis_kelamin, s.agama, 
               s.status_dalam_keluarga, s.anak_ke, s.alamat, s.telepon_hp, s.sekolah_asal, s.tanggal_mendaftar, s.tahun_daftar
        FROM siswa s
        LEFT JOIN orang_tua o ON s.users_id = o.users_id
        WHERE s.users_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $users_id);
$stmt->execute();
$result = $stmt->get_result();

// Pastikan data ditemukan dan variabel $row didefinisikan
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    // Jika data tidak ditemukan, tampilkan pesan kesalahan
    $row = [];
    echo "Data siswa atau orang tua tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 1.5rem;
            margin: 0;
        }

        .btn-secondary,
        .btn-warning {
            margin: 5px;
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
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .alert {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="header">
            <h2>Detail Siswa: <?= htmlspecialchars($row['nama_siswa']) ?></h2>
        </div>
        <div class="d-flex justify-content-between mb-4">
            <a href="index.php?page=data_siswa" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <a href="index.php?page=edit_data&id=<?= $users_id ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
        </div>
        <h3>Data Siswa</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                    </tr>
                    <tr>
                        <td>Nomor Induk</td>
                        <td><?= htmlspecialchars($row['nomor_induk']) ?></td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td><?= htmlspecialchars($row['nisn']) ?></td>
                    </tr>
                    <tr>
                        <td>Tempat Lahir</td>
                        <td><?= htmlspecialchars($row['tempat_lahir']) ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td><?= htmlspecialchars($row['tanggal_lahir']) ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td><?= htmlspecialchars($row['agama']) ?></td>
                    </tr>
                    <tr>
                        <td>Status Dalam Keluarga</td>
                        <td><?= htmlspecialchars($row['status_dalam_keluarga']) ?></td>
                    </tr>
                    <tr>
                        <td>Anak ke</td>
                        <td><?= htmlspecialchars($row['anak_ke']) ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                    </tr>
                    <tr>
                        <td>Telepon/HP</td>
                        <td><?= htmlspecialchars($row['telepon_hp']) ?></td>
                    </tr>
                    <tr>
                        <td>Sekolah Asal</td>
                        <td><?= htmlspecialchars($row['sekolah_asal']) ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Mendaftar</td>
                        <td><?= htmlspecialchars($row['tanggal_mendaftar']) ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Daftar</td>
                        <td><?= htmlspecialchars($row['tahun_daftar']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <h3>Data Orang Tua</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td>Nama Ayah</td>
                        <td><?= htmlspecialchars($row['nama_ayah']) ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Ayah</td>
                        <td><?= htmlspecialchars($row['alamat_ayah']) ?></td>
                    </tr>
                    <tr>
                        <td>Telepon Ayah</td>
                        <td><?= htmlspecialchars($row['telepon_ayah']) ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan Ayah</td>
                        <td><?= htmlspecialchars($row['pekerjaan_ayah']) ?></td>
                    </tr>
                    <tr>
                        <td>Nama Ibu</td>
                        <td><?= htmlspecialchars($row['nama_ibu']) ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Ibu</td>
                        <td><?= htmlspecialchars($row['alamat_ibu']) ?></td>
                    </tr>
                    <tr>
                        <td>Telepon Ibu</td>
                        <td><?= htmlspecialchars($row['telepon_ibu']) ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan Ibu</td>
                        <td><?= htmlspecialchars($row['pekerjaan_ibu']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>