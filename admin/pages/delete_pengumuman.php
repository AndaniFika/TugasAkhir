<?php

if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];

    // Query untuk menghapus pengumuman berdasarkan ID
    $sql_delete_announcement = "DELETE FROM announcements WHERE id='$announcement_id'";
    if ($conn->query($sql_delete_announcement) === TRUE) {
        echo "Pengumuman berhasil dihapus!";
    } else {
        echo "Error: " . $sql_delete_announcement . "<br>" . $conn->error;
    }
}

$conn->close();

// Redirect kembali ke halaman daftar pengumuman setelah menghapus
header("Location: index.php?page=pengumuman");
exit;
