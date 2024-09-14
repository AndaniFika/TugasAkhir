<?php
session_start();
include('layout/header.php');
?>

<section class="foto">
    <img class="foto" src="assets/img/foto.jpg" alt="Penerimaan Siswa Baru">
</section>

<?php
include 'koneksi/db.php';

// Fetch the current status of the "Daftar" button
$sql = "SELECT setting_value FROM settings WHERE setting_key = 'Buka'";
$result = $conn->query($sql);
$daftar_button_status = $result->fetch_assoc()['setting_value'];
$conn->close();
?>

<section class="daftar">
    <h2 class="font1">PENERIMAAN PESERTA DIDIK BARU</h2>
    <h2 class="font2">Selamat Datang</h2>
    <h2 class="font3">Calon Siswa Baru.</h2>
    <h2 class="font4">MTs AL-MUHAJIRIN Waihatu</h2>

    <?php if ($daftar_button_status == 'Buka') : ?>
        <a href="register.php">Daftar</a>
    <?php else : ?>
        <a href="#" onclick="return false;" style="opacity: 0.5; cursor: not-allowed;">Daftar</a>
    <?php endif; ?>

    <a class="login" href="login.php">Masuk</a>
</section>

<section id="profil" class="section">
    <div class="container">
        <h3 class="text-center">Profil Sekolah</h3>
        <div class="d-flex justify-content-center">
            <div class="col-lg-12 col-md-10 col-sm-12"> <!-- Ubah dari col-lg-6 menjadi col-lg-8 -->
                <div class="card p-3">
                    <?php
                    include 'koneksi/db.php';

                    $sql = "SELECT nama, foto, npsn, sejarah FROM profil ORDER BY id DESC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="d-flex align-items-center">';
                            echo '<img src="assets/profile/' . $row["foto"] . '" class="img-fluid rounded" alt="Foto Kepala Sekolah" style="max-width: 150px; margin-right: 20px;">';
                            echo '<div class="text-container">';
                            echo '<div class="info-item">';
                            echo '<h6>Nama Kepala Sekolah:</h6>';
                            echo '<p>' . $row["nama"] . '</p>';
                            echo '</div>';
                            echo '<div class="info-item">';
                            echo '<h6>NPSN Sekolah:</h6>';
                            echo '<p>' . $row["npsn"] . '</p>';
                            echo '</div>';
                            echo '<div class="info-item">';
                            echo '<h6>Sejarah:</h6>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<p>' . $row["sejarah"] . '</p>';
                        }
                    } else {
                        echo " ";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="lokasi" class="section">
    <div class="container">
        <h3>Lokasi</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.26403157846!2d128.3304226737438!3d-3.284606341073041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d6c69c8d73e9bb9%3A0x86fac56bc4a639e4!2sMts%20Almuhajirin%20Waihatu!5e0!3m2!1sen!2sid!4v1719583818436!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<!-- pengumuman -->
<section id="pengumuman" class="section">
    <div class="container"><br><br>
        <h3>Pengumuman</h3>
        <?php
        include('koneksi/db.php');

        $sql = "SELECT * FROM announcements ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='announcement'>";
                echo "<h5>" . htmlspecialchars($row["title"]) . "</h5>";
                echo "<p class='content'>" . nl2br(htmlspecialchars($row["content"])) . "</p>";
                echo "<p><small>Diposting pada: " . $row["created_at"] . "</small></p>";
                echo "</div>";
                echo "<hr>";
            }
        } else {
            echo "Belum ada pengumuman.";
        }
        $conn->close();
        ?>
    </div>
</section>
<!-- end pengumuman -->

<?php include 'layout/footer.php';  // Memanggil footer 
?>