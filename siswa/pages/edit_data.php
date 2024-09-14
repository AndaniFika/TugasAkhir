<?php

$user_id = $_SESSION['users_id'];

// Ambil data siswa dari database
$sql_siswa = "SELECT * FROM siswa WHERE users_id='$user_id'";
$result_siswa = $conn->query($sql_siswa);

if ($result_siswa->num_rows == 1) {
    $row_siswa = $result_siswa->fetch_assoc();
    $siswa_id = $row_siswa['id'];
    $siswa_nama = $row_siswa['nama'];
    $siswa_nomor_induk = $row_siswa['nomor_induk'];
    $siswa_nisn = $row_siswa['nisn'];
    $siswa_tempat_lahir = $row_siswa['tempat_lahir'];
    $siswa_tanggal_lahir = $row_siswa['tanggal_lahir'];
    $siswa_jenis_kelamin = $row_siswa['jenis_kelamin'];
    $siswa_agama = $row_siswa['agama'];
    $siswa_status_dalam_keluarga = $row_siswa['status_dalam_keluarga'];
    $siswa_anak_ke = $row_siswa['anak_ke'];
    $siswa_alamat = $row_siswa['alamat'];
    $siswa_telepon_hp = $row_siswa['telepon_hp'];
    $siswa_sekolah_asal = $row_siswa['sekolah_asal'];
} else {
    echo "Data siswa tidak ditemukan.";
    exit;
}

// Ambil data orang tua dari database
$sql_orang_tua = "SELECT * FROM orang_tua WHERE users_id='$user_id'";
$result_orang_tua = $conn->query($sql_orang_tua);

if ($result_orang_tua->num_rows == 1) {
    $row_orang_tua = $result_orang_tua->fetch_assoc();
    $orang_tua_nama_ayah = $row_orang_tua['nama_ayah'];
    $orang_tua_alamat_ayah = $row_orang_tua['alamat_ayah'];
    $orang_tua_telepon_ayah = $row_orang_tua['telepon_ayah'];
    $orang_tua_pekerjaan_ayah = $row_orang_tua['pekerjaan_ayah'];
    $orang_tua_nama_ibu = $row_orang_tua['nama_ibu'];
    $orang_tua_alamat_ibu = $row_orang_tua['alamat_ibu'];
    $orang_tua_telepon_ibu = $row_orang_tua['telepon_ibu'];
    $orang_tua_pekerjaan_ibu = $row_orang_tua['pekerjaan_ibu'];
} else {
    echo "Data orang tua tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_siswa_nama = $_POST['siswa_nama'];
    $new_siswa_nomor_induk = $_POST['siswa_nomor_induk'];
    $new_siswa_nisn = $_POST['siswa_nisn'];
    $new_siswa_tempat_lahir = $_POST['siswa_tempat_lahir'];
    $new_siswa_tanggal_lahir = $_POST['siswa_tanggal_lahir'];
    $new_siswa_jenis_kelamin = $_POST['siswa_jenis_kelamin'];
    $new_siswa_agama = $_POST['siswa_agama'];
    $new_siswa_status_dalam_keluarga = $_POST['siswa_status_dalam_keluarga'];
    $new_siswa_anak_ke = $_POST['siswa_anak_ke'];
    $new_siswa_alamat = $_POST['siswa_alamat'];
    $new_siswa_telepon_hp = $_POST['siswa_telepon_hp'];
    $new_siswa_sekolah_asal = $_POST['siswa_sekolah_asal'];

    $new_orang_tua_nama_ayah = $_POST['orang_tua_nama_ayah'];
    $new_orang_tua_alamat_ayah = $_POST['orang_tua_alamat_ayah'];
    $new_orang_tua_telepon_ayah = $_POST['orang_tua_telepon_ayah'];
    $new_orang_tua_pekerjaan_ayah = $_POST['orang_tua_pekerjaan_ayah'];
    $new_orang_tua_nama_ibu = $_POST['orang_tua_nama_ibu'];
    $new_orang_tua_alamat_ibu = $_POST['orang_tua_alamat_ibu'];
    $new_orang_tua_telepon_ibu = $_POST['orang_tua_telepon_ibu'];
    $new_orang_tua_pekerjaan_ibu = $_POST['orang_tua_pekerjaan_ibu'];

    // Update data siswa
    $sql_update_siswa = "UPDATE siswa SET nama = '$new_siswa_nama', nomor_induk = '$new_siswa_nomor_induk', nisn = '$new_siswa_nisn', tempat_lahir = '$new_siswa_tempat_lahir', tanggal_lahir = '$new_siswa_tanggal_lahir', jenis_kelamin = '$new_siswa_jenis_kelamin', agama = '$new_siswa_agama', status_dalam_keluarga = '$new_siswa_status_dalam_keluarga', anak_ke = '$new_siswa_anak_ke', alamat = '$new_siswa_alamat', telepon_hp = '$new_siswa_telepon_hp', sekolah_asal = '$new_siswa_sekolah_asal' WHERE users_id = '$user_id'";
    if ($conn->query($sql_update_siswa) === TRUE) {
        // Update data orang tua
        $sql_update_orang_tua = "UPDATE orang_tua SET nama_ayah = '$new_orang_tua_nama_ayah', alamat_ayah = '$new_orang_tua_alamat_ayah', telepon_ayah = '$new_orang_tua_telepon_ayah', pekerjaan_ayah = '$new_orang_tua_pekerjaan_ayah', nama_ibu = '$new_orang_tua_nama_ibu', alamat_ibu = '$new_orang_tua_alamat_ibu', telepon_ibu = '$new_orang_tua_telepon_ibu', pekerjaan_ibu = '$new_orang_tua_pekerjaan_ibu' WHERE users_id = '$user_id'";
        if ($conn->query($sql_update_orang_tua) === TRUE) {
            header("Location: index.php?page=edit_data");
            exit;
        } else {
            echo "Error updating parent data: " . $conn->error;
        }
    } else {
        echo "Error updating student data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <div class="container mt-5">
        <h3 class="mb-4">Edit Data Siswa</h3>
        <div class="form-section">
            <form method="POST">
                <div class="mb-3">
                    <h3>Data Siswa</h3>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_nama" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="siswa_nama" name="siswa_nama" value="<?php echo htmlspecialchars($siswa_nama); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="siswa_nomor_induk" class="form-label">Nomor Induk</label>
                        <input type="text" class="form-control" id="siswa_nomor_induk" name="siswa_nomor_induk" value="<?php echo htmlspecialchars($siswa_nomor_induk); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="siswa_nisn" name="siswa_nisn" value="<?php echo htmlspecialchars($siswa_nisn); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="siswa_tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="siswa_tempat_lahir" name="siswa_tempat_lahir" value="<?php echo htmlspecialchars($siswa_tempat_lahir); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="siswa_tanggal_lahir" name="siswa_tanggal_lahir" value="<?php echo htmlspecialchars($siswa_tanggal_lahir); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="siswa_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="siswa_jenis_kelamin" name="siswa_jenis_kelamin" required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki" <?php if ($siswa_jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php if ($siswa_jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_agama" class="form-label">Agama</label>
                        <select class="form-select" id="siswa_agama" name="siswa_agama" required>
                            <option value="">Pilih agama</option>
                            <option value="Islam" <?php if ($siswa_agama == 'Islam') echo 'selected'; ?>>Islam</option>
                            <option value="Kristen" <?php if ($siswa_agama == 'Kristen') echo 'selected'; ?>>Kristen</option>
                            <option value="Katolik" <?php if ($siswa_agama == 'Katolik') echo 'selected'; ?>>Katolik</option>
                            <option value="Hindu" <?php if ($siswa_agama == 'Hindu') echo 'selected'; ?>>Hindu</option>
                            <option value="Konghucu" <?php if ($siswa_agama == 'Konghucu') echo 'selected'; ?>>Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="siswa_status_dalam_keluarga" class="form-label">Status dalam Keluarga</label>
                        <select class="form-select" id="siswa_status_dalam_keluarga" name="siswa_status_dalam_keluarga" required>
                            <option value="">Pilih status dalam keluarga</option>
                            <option value="Kandung" <?php if ($siswa_status_dalam_keluarga == 'Kandung') echo 'selected'; ?>>Kandung</option>
                            <option value="Tiri" <?php if ($siswa_status_dalam_keluarga == 'Tiri') echo 'selected'; ?>>Tiri</option>
                            <option value="Angkat" <?php if ($siswa_status_dalam_keluarga == 'Angkat') echo 'selected'; ?>>Angkat</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_anak_ke" class="form-label">Anak ke</label>
                        <input type="number" class="form-control" id="siswa_anak_ke" name="siswa_anak_ke" value="<?php echo htmlspecialchars($siswa_anak_ke); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="siswa_alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="siswa_alamat" name="siswa_alamat" required><?php echo htmlspecialchars($siswa_alamat); ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_telepon_hp" class="form-label">Telepon HP</label>
                        <input type="text" class="form-control" id="siswa_telepon_hp" name="siswa_telepon_hp" value="<?php echo htmlspecialchars($siswa_telepon_hp); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="siswa_sekolah_asal" class="form-label">Sekolah Asal</label>
                        <input type="text" class="form-control" id="siswa_sekolah_asal" name="siswa_sekolah_asal" value="<?php echo htmlspecialchars($siswa_sekolah_asal); ?>" required>
                    </div>
                </div>
        </div>
        <div class="form-section">

            <div class="mb-3">
                <h3>Data Ayah</h3>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_nama_ayah" class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control" id="orang_tua_nama_ayah" name="orang_tua_nama_ayah" value="<?php echo htmlspecialchars($orang_tua_nama_ayah); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_alamat_ayah" class="form-label">Alamat Ayah</label>
                    <textarea class="form-control" id="orang_tua_alamat_ayah" name="orang_tua_alamat_ayah" required><?php echo htmlspecialchars($orang_tua_alamat_ayah); ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_telepon_ayah" class="form-label">Telepon Ayah</label>
                    <input type="text" class="form-control" id="orang_tua_telepon_ayah" name="orang_tua_telepon_ayah" value="<?php echo htmlspecialchars($orang_tua_telepon_ayah); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                    <input type="text" class="form-control" id="orang_tua_pekerjaan_ayah" name="orang_tua_pekerjaan_ayah" value="<?php echo htmlspecialchars($orang_tua_pekerjaan_ayah); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <h3>Data Ibu</h3>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control" id="orang_tua_nama_ibu" name="orang_tua_nama_ibu" value="<?php echo htmlspecialchars($orang_tua_nama_ibu); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_alamat_ibu" class="form-label">Alamat Ibu</label>
                    <textarea class="form-control" id="orang_tua_alamat_ibu" name="orang_tua_alamat_ibu" required><?php echo htmlspecialchars($orang_tua_alamat_ibu); ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_telepon_ibu" class="form-label">Telepon Ibu</label>
                    <input type="text" class="form-control" id="orang_tua_telepon_ibu" name="orang_tua_telepon_ibu" value="<?php echo htmlspecialchars($orang_tua_telepon_ibu); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="orang_tua_pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                    <input type="text" class="form-control" id="orang_tua_pekerjaan_ibu" name="orang_tua_pekerjaan_ibu" value="<?php echo htmlspecialchars($orang_tua_pekerjaan_ibu); ?>" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>