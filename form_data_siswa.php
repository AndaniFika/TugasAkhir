<?php
include('koneksi/db.php');
include('layout/header.php');

// Fetch the current status of the registration setting
$sql = "SELECT setting_value FROM settings WHERE setting_key = 'Buka'";
$result = $conn->query($sql);
$registration_status = $result->fetch_assoc()['setting_value'];

// Redirect to index.php if registration is closed
if ($registration_status !== 'Buka') {
    header("Location: index.php");
    exit;
}

$users_id = $_GET['users_id'];

// Ambil data pengguna dari tabel users berdasarkan users_id
$sql_users = "SELECT * FROM users WHERE id = ?";
$stmt_users = $conn->prepare($sql_users);
$stmt_users->bind_param('i', $users_id);
$stmt_users->execute();
$result_users = $stmt_users->get_result();

if ($result_users->num_rows > 0) {
    // Data pengguna ditemukan
    $row_users = $result_users->fetch_assoc();

    // Ambil tahun sekarang secara otomatis
    $tahun_daftar = date('Y');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ambil nilai dari form
        $nama = $_POST['nama'];
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

        $nama_ayah = $_POST['nama_ayah'];
        $alamat_ayah = $_POST['alamat_ayah'];
        $telepon_ayah = $_POST['telepon_ayah'];
        $pekerjaan_ayah = $_POST['pekerjaan_ayah'];
        $nama_ibu = $_POST['nama_ibu'];
        $alamat_ibu = $_POST['alamat_ibu'];
        $telepon_ibu = $_POST['telepon_ibu'];
        $pekerjaan_ibu = $_POST['pekerjaan_ibu'];

        // Ambil tanggal mendaftar dari form
        $tanggal_mendaftar = $_POST['tanggal_mendaftar'];

        // Cek apakah NISN sudah terdaftar
        $sql_check_nisn = "SELECT * FROM siswa WHERE nisn = ?";
        $stmt_check_nisn = $conn->prepare($sql_check_nisn);
        $stmt_check_nisn->bind_param('s', $nisn);
        $stmt_check_nisn->execute();
        $result_check_nisn = $stmt_check_nisn->get_result();

        if ($result_check_nisn->num_rows > 0) {
            // NISN sudah terdaftar
            echo "NISN sudah terdaftar. Silakan periksa kembali.";
        } else {
            // NISN belum terdaftar, lanjutkan penyimpanan data
            $sql_insert_siswa = "INSERT INTO siswa (nama, nomor_induk, nisn, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, status_dalam_keluarga, anak_ke, alamat, telepon_hp, sekolah_asal, tanggal_mendaftar, tahun_daftar, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert_siswa = $conn->prepare($sql_insert_siswa);
            $stmt_insert_siswa->bind_param('ssssssssissssii', $nama, $nomor_induk, $nisn, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $status_dalam_keluarga, $anak_ke, $alamat, $telepon_hp, $sekolah_asal, $tanggal_mendaftar, $tahun_daftar, $users_id);

            if ($stmt_insert_siswa->execute()) {
                $siswa_id = $stmt_insert_siswa->insert_id;

                // Simpan data orang tua
                $sql_insert_orang_tua = "INSERT INTO orang_tua (users_id, nama_ayah, alamat_ayah, telepon_ayah, pekerjaan_ayah, nama_ibu, alamat_ibu, telepon_ibu, pekerjaan_ibu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert_orang_tua = $conn->prepare($sql_insert_orang_tua);
                $stmt_insert_orang_tua->bind_param('issssssss', $users_id, $nama_ayah, $alamat_ayah, $telepon_ayah, $pekerjaan_ayah, $nama_ibu, $alamat_ibu, $telepon_ibu, $pekerjaan_ibu);

                if ($stmt_insert_orang_tua->execute()) {
                    // Update kolom data_filled pada tabel users menjadi 1
                    $sql_update_users = "UPDATE users SET data_filled = 1 WHERE id = ?";
                    $stmt_update_users = $conn->prepare($sql_update_users);
                    $stmt_update_users->bind_param('i', $users_id);
                    $stmt_update_users->execute();

                    // Redirect ke halaman index setelah selesai
                    header("Location: index.php");
                    exit;
                } else {
                    echo "Error: " . $stmt_insert_orang_tua->error;
                }
            } else {
                echo "Error: " . $stmt_insert_siswa->error;
            }
        }
    }
} else {
    // User tidak ditemukan
    die("User dengan ID tersebut tidak ditemukan");
}
?>




<style>
    header nav {
        display: none;
    }

    a {
        pointer-events: none;
        color: #999;
        /* Mengubah warna teks agar terlihat disabled */
        text-decoration: none;
        /* Optional: menghilangkan garis bawah */
        cursor: default;
        /* Optional: mengubah kursor saat diarahkan */
    }
</style>
<!-- end menghiangkan tombol navbar -->

<div class="container mt-5">
    <h2 class="mb-4 text-center">Input Data Siswa</h2>
    <form method="POST">
        <input type="hidden" name="tanggal_mendaftar" value="<?php echo date('Y-m-d'); ?>">
        <input type="hidden" name="tahun_daftar" value="<?php echo $tahun_daftar; ?>">

        <!-- Student Data -->
        <div class="mb-3">
            <h3>Data Siswa</h3>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama" class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Siswa" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nomor_induk" class="form-label">Nomor Induk SD/MI</label>
                <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" placeholder="Nomor Induk SD/MI" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" class="form-control" id="nisn" name="nisn" placeholder="NISN" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih jenis kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="agama" class="form-label">Agama</label>
                <select class="form-select" id="agama" name="agama" required>
                    <option value="">Pilih agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="status_dalam_keluarga" class="form-label">Status dalam Keluarga</label>
                <select class="form-select" id="status_dalam_keluarga" name="status_dalam_keluarga" required>
                    <option value="">Pilih status</option>
                    <option value="Kandung">Kandung</option>
                    <option value="Tiri">Tiri</option>
                    <option value="Angkat">Angkat</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="anak_ke" class="form-label">Anak ke-</label>
                <input type="number" class="form-control" id="anak_ke" name="anak_ke" placeholder="Anak ke-" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telepon_hp" class="form-label">Telepon / HP</label>
                <input type="text" class="form-control" id="telepon_hp" name="telepon_hp" placeholder="Telepon / HP" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="sekolah_asal" class="form-label">Sekolah Asal</label>
                <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" placeholder="Sekolah Asal" required>
            </div>
        </div>

        <!-- Parent Data -->
        <div class="mb-3">
            <h3>Data Orang Tua</h3>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_ayah" class="form-label">Nama Ayah</label>
                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Ayah" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="alamat_ayah" class="form-label">Alamat Ayah</label>
                <input type="text" class="form-control" id="alamat_ayah" name="alamat_ayah" placeholder="Alamat Ayah" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telepon_ayah" class="form-label">Telepon Ayah</label>
                <input type="text" class="form-control" id="telepon_ayah" name="telepon_ayah" placeholder="Telepon Ayah" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_ibu" class="form-label">Nama Ibu</label>
                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Ibu" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="alamat_ibu" class="form-label">Alamat Ibu</label>
                <input type="text" class="form-control" id="alamat_ibu" name="alamat_ibu" placeholder="Alamat Ibu" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telepon_ibu" class="form-label">Telepon Ibu</label>
                <input type="text" class="form-control" id="telepon_ibu" name="telepon_ibu" placeholder="Telepon Ibu" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Pekerjaan Ibu" required>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
    </form>
</div>

<?php
include('layout/footer.php');
?>