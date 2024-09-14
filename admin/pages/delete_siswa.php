<?php

if (isset($_GET['id'])) {
    $users_id = $_GET['id'];

    // Ambil id siswa terkait user jika ada
    $sql_get_siswa_id = "SELECT id FROM siswa WHERE users_id='$users_id'";
    $result_siswa_id = $conn->query($sql_get_siswa_id);

    if ($result_siswa_id->num_rows > 0) {
        $row = $result_siswa_id->fetch_assoc();
        $siswa_id = $row['id'];

        // Ambil semua berkas yang terkait dengan siswa jika ada
        $sql_get_berkas = "SELECT * FROM berkas WHERE users_id='$users_id'";
        $result_berkas = $conn->query($sql_get_berkas);

        if ($result_berkas->num_rows > 0) {
            while ($row_berkas = $result_berkas->fetch_assoc()) {
                $ijazah = $row_berkas['ijazah'];
                $skhun = $row_berkas['skhun'];
                $kk = $row_berkas['kk'];
                $ktp_ayah = $row_berkas['ktp_ayah'];
                $ktp_ibu = $row_berkas['ktp_ibu'];
                $kbs = $row_berkas['kbs'];

                // Cek dan hapus berkas dari folder uploads
                foreach ([$ijazah, $skhun, $kk, $ktp_ayah, $ktp_ibu, $kbs] as $file) {
                    $file_path = __DIR__ . '/../../uploads/' . $file;  // Periksa path dengan __DIR__
                    if (file_exists($file_path)) {
                        if (unlink($file_path)) {
                            echo "Berkas dihapus: $file_path<br>";
                        } else {
                            echo "Gagal menghapus berkas: $file_path<br>";
                        }
                    } else {
                        echo "Berkas tidak ditemukan: $file_path<br>";
                    }
                }
            }
        }

        // Hapus data dari tabel berkas
        $sql_delete_berkas = "DELETE FROM berkas WHERE users_id='$users_id'";
        if ($conn->query($sql_delete_berkas) === TRUE) {
            // Hapus data orang tua yang terkait
            $sql_delete_orang_tua = "DELETE FROM orang_tua WHERE users_id='$users_id'";
            if ($conn->query($sql_delete_orang_tua) === TRUE) {
                // Hapus data siswa
                $sql_delete_siswa = "DELETE FROM siswa WHERE id='$siswa_id'";
                if ($conn->query($sql_delete_siswa) === TRUE) {
                    // Hapus juga pengguna terkait
                    $sql_delete_user = "DELETE FROM users WHERE id='$users_id'";
                    if ($conn->query($sql_delete_user) === TRUE) {
                        echo "Data siswa dan pengguna berhasil dihapus!";
                    } else {
                        echo "Error: " . $sql_delete_user . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $sql_delete_siswa . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sql_delete_orang_tua . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_delete_berkas . "<br>" . $conn->error;
        }
    } else {
        // Jika tidak ada siswa terkait, hapus langsung data pengguna
        $sql_delete_user = "DELETE FROM users WHERE id='$users_id'";
        if ($conn->query($sql_delete_user) === TRUE) {
            echo "Pengguna berhasil dihapus!";
        } else {
            echo "Error: " . $sql_delete_user . "<br>" . $conn->error;
        }
    }

    header("Location: index.php?page=data_siswa");
    exit;
} else {
    echo "ID pengguna tidak ditemukan.";
}
