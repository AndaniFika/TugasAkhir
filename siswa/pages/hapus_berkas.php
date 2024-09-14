<?php

// Cek apakah pengguna sudah login
if (!isset($_SESSION['users_id'])) {
    header("Location: ../../login.php");
    exit;
}

$user_id = $_SESSION['users_id'];

$stmt->close(); // Menutup statement setelah selesai digunakan

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $berkas_id = $_POST['id'];

    // Ambil nama file dari database berdasarkan id
    $stmt = $conn->prepare("SELECT ijazah, skhun, kk, ktp_ayah, ktp_ibu, kbs FROM berkas WHERE users_id = ? AND id = ?");
    $stmt->bind_param("ii", $users_id, $berkas_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $files_to_delete = array($row['ijazah'], $row['skhun'], $row['kk'], $row['ktp_ayah'], $row['ktp_ibu'], $row['kbs']);

        // Hapus file fisik dari folder uploads
        foreach ($files_to_delete as $file) {
            if (!empty($file) && file_exists($file)) {
                unlink($file);
            }
        }

        // Hapus entri file dari database
        $stmt_delete = $conn->prepare("DELETE FROM berkas WHERE users_id = ? AND id = ?");
        $stmt_delete->bind_param("ii", $users_id, $berkas_id);
        if ($stmt_delete->execute()) {
            $_SESSION['upload_message'] = "Berkas berhasil dihapus.";
            header("Location: index.php?page=display_berkas");
            exit;
        } else {
            $_SESSION['upload_message'] = "Error: " . $stmt_delete->error;
        }

        $stmt_delete->close(); // Menutup statement setelah selesai digunakan
    } else {
        echo "Berkas tidak ditemukan.";
    }
    $stmt->close(); // Menutup statement setelah selesai digunakan
} else {
    echo "Aksi tidak valid.";
}

$conn->close(); // Menutup koneksi setelah semua selesai
