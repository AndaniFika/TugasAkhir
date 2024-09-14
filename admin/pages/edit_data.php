<?php
// Ambil users_id dari URL dan lakukan validasi
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID pengguna tidak ditemukan.");
}
$users_id = intval($_GET['id']);

// Query untuk mendapatkan data siswa dan orang tua berdasarkan users_id
$sql = "SELECT o.id AS orang_tua_id, o.nama_ayah, o.alamat_ayah, o.telepon_ayah, o.pekerjaan_ayah, o.nama_ibu, o.alamat_ibu, o.telepon_ibu, o.pekerjaan_ibu, 
        s.id AS siswa_id, s.nama AS nama_siswa, s.nomor_induk, s.nisn, s.tempat_lahir, s.tanggal_lahir, s.jenis_kelamin, s.agama, 
        s.status_dalam_keluarga, s.anak_ke, s.alamat, s.telepon_hp, s.sekolah_asal, s.tahun_daftar
        FROM siswa s
        LEFT JOIN orang_tua o ON s.users_id = o.users_id
        WHERE s.users_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $users_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    die("Data siswa atau orang tua tidak ditemukan.");
}

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_siswa = $_POST['nama_siswa'];
    $nomor_induk = $_POST['nomor_induk'];
    $nisn = $_POST['nisn'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $status_dalam_keluarga = $_POST['status_dalam_keluarga'];
    $anak_ke = $_POST['anak_ke'];
    $alamat = $_POST['alamat'];
    $telepon_hp = $_POST['telepon_hp'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $tahun_daftar = $_POST['tahun_daftar'];

    $nama_ayah = $_POST['nama_ayah'];
    $alamat_ayah = $_POST['alamat_ayah'];
    $telepon_ayah = $_POST['telepon_ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan_ayah'];

    $nama_ibu = $_POST['nama_ibu'];
    $alamat_ibu = $_POST['alamat_ibu'];
    $telepon_ibu = $_POST['telepon_ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan_ibu'];

    // Update data siswa
    $sql_siswa = "UPDATE siswa SET nama=?, nomor_induk=?, nisn=?, tempat_lahir=?, tanggal_lahir=?, jenis_kelamin=?, agama=?, status_dalam_keluarga=?, anak_ke=?, alamat=?, telepon_hp=?, sekolah_asal=?, tahun_daftar=? WHERE users_id=?";
    $stmt_siswa = $conn->prepare($sql_siswa);
    $stmt_siswa->bind_param("sssssssssssssi", $nama_siswa, $nomor_induk, $nisn, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $status_dalam_keluarga, $anak_ke, $alamat, $telepon_hp, $sekolah_asal, $tahun_daftar, $users_id);
    $stmt_siswa->execute();

    // Update data orang tua
    $sql_orang_tua = "UPDATE orang_tua SET nama_ayah=?, alamat_ayah=?, telepon_ayah=?, pekerjaan_ayah=?, nama_ibu=?, alamat_ibu=?, telepon_ibu=?, pekerjaan_ibu=? WHERE users_id=?";
    $stmt_orang_tua = $conn->prepare($sql_orang_tua);
    $stmt_orang_tua->bind_param("ssssssssi", $nama_ayah, $alamat_ayah, $telepon_ayah, $pekerjaan_ayah, $nama_ibu, $alamat_ibu, $telepon_ibu, $pekerjaan_ibu, $users_id);
    $stmt_orang_tua->execute();

    // Cek apakah update berhasil
    if ($stmt_siswa->affected_rows > 0 || $stmt_orang_tua->affected_rows > 0) {
        header("Location: index.php?page=detail_siswa&id=" . $users_id);
        exit;
    } else {
        echo "<div class='alert alert-warning'>Tidak ada perubahan pada data.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .form-section h3 {
            margin-bottom: 20px;
        }

        .btn-back {
            margin-bottom: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 1.5rem;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="header">
            <h2 class="mb-4">Edit Data: <?= htmlspecialchars($row['nama_siswa']) ?></h2>
        </div>
        <a href="index.php?page=detail_siswa&id=<?= $users_id ?>" class="btn btn-secondary btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>

        <form method="POST">
            <div class="form-section">
                <h3>Data Siswa</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_siswa" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="<?= htmlspecialchars($row['nama_siswa']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nomor_induk" class="form-label">Nomor Induk</label>
                        <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="<?= htmlspecialchars($row['nomor_induk']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" value="<?= htmlspecialchars($row['nisn']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= htmlspecialchars($row['tempat_lahir']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($row['tanggal_lahir']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki" <?= $row['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $row['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="agama" class="form-label">Agama</label>
                        <input type="text" class="form-control" id="agama" name="agama" value="<?= htmlspecialchars($row['agama']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="status_dalam_keluarga" class="form-label">Status Dalam Keluarga</label>
                        <input type="text" class="form-control" id="status_dalam_keluarga" name="status_dalam_keluarga" value="<?= htmlspecialchars($row['status_dalam_keluarga']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="anak_ke" class="form-label">Anak Ke</label>
                        <input type="number" class="form-control" id="anak_ke" name="anak_ke" value="<?= htmlspecialchars($row['anak_ke']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($row['alamat']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telepon_hp" class="form-label">Telepon HP</label>
                        <input type="text" class="form-control" id="telepon_hp" name="telepon_hp" value="<?= htmlspecialchars($row['telepon_hp']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sekolah_asal" class="form-label">Sekolah Asal</label>
                        <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" value="<?= htmlspecialchars($row['sekolah_asal']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tahun_daftar" class="form-label">Tahun Daftar</label>
                        <select class="form-select" id="tahun_daftar" name="tahun_daftar" required>
                            <option value="">Pilih Tahun</option>
                            <?php
                            for ($i = 2000; $i <= date('Y'); $i++) {
                                echo '<option value="' . $i . '"' . ($row['tahun_daftar'] == $i ? ' selected' : '') . '>' . $i . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Data Orang Tua</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="<?= htmlspecialchars($row['nama_ayah']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="alamat_ayah" class="form-label">Alamat Ayah</label>
                        <input type="text" class="form-control" id="alamat_ayah" name="alamat_ayah" value="<?= htmlspecialchars($row['alamat_ayah']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telepon_ayah" class="form-label">Telepon Ayah</label>
                        <input type="text" class="form-control" id="telepon_ayah" name="telepon_ayah" value="<?= htmlspecialchars($row['telepon_ayah']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" value="<?= htmlspecialchars($row['pekerjaan_ayah']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="<?= htmlspecialchars($row['nama_ibu']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="alamat_ibu" class="form-label">Alamat Ibu</label>
                        <input type="text" class="form-control" id="alamat_ibu" name="alamat_ibu" value="<?= htmlspecialchars($row['alamat_ibu']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telepon_ibu" class="form-label">Telepon Ibu</label>
                        <input type="text" class="form-control" id="telepon_ibu" name="telepon_ibu" value="<?= htmlspecialchars($row['telepon_ibu']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" value="<?= htmlspecialchars($row['pekerjaan_ibu']) ?>" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>