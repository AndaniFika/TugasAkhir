<?php

$user_id = $_SESSION['users_id'];

// Cek apakah data sudah ada
$stmt = $conn->prepare("SELECT id FROM berkas WHERE users_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Jika data sudah ada, tampilkan pesan atau alihkan pengguna
    $_SESSION['upload_message'] = "Anda sudah mengunggah data. Tidak bisa mengunggah lagi.";
    header("Location: index.php?page=display_berkas");
    exit;
} else {
    // Jika data belum ada, tampilkan formulir unggahan
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "../uploads/";
        $allowed_extensions = array('pdf', 'docx', 'png', 'jpg', 'jpeg');
        $upload_success = true;
        $file_paths = array();

        // Function to handle file upload
        function handleFileUpload($file_key, $allowed_extensions, $target_dir, &$file_paths, &$upload_success)
        {
            if (!empty($_FILES[$file_key]['name'])) {
                $file_name = $_FILES[$file_key]['name'];
                $file_tmp = $_FILES[$file_key]['tmp_name'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $unique_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . time() . '.' . $file_ext; // Tambahkan timestamp pada nama file

                if (in_array($file_ext, $allowed_extensions)) {
                    $target_file = $target_dir . basename($unique_file_name);
                    if (move_uploaded_file($file_tmp, $target_file)) {
                        $file_paths[$file_key] = $target_file;
                    } else {
                        echo "Gagal mengunggah $file_key.<br>";
                        $upload_success = false;
                    }
                } else {
                    echo "Ekstensi file $file_key tidak diizinkan.<br>";
                    $upload_success = false;
                }
            }
        }

        // Handle each file upload
        handleFileUpload('ijazah', ['pdf', 'docx'], $target_dir, $file_paths, $upload_success);
        handleFileUpload('skhun', ['pdf', 'docx'], $target_dir, $file_paths, $upload_success);
        handleFileUpload('kk', ['pdf', 'png', 'jpg', 'jpeg'], $target_dir, $file_paths, $upload_success);
        handleFileUpload('ktp_ayah', ['pdf', 'png', 'jpg', 'jpeg'], $target_dir, $file_paths, $upload_success);
        handleFileUpload('ktp_ibu', ['pdf', 'png', 'jpg', 'jpeg'], $target_dir, $file_paths, $upload_success);
        handleFileUpload('kbs', ['pdf', 'docx'], $target_dir, $file_paths, $upload_success);

        // If all uploads are successful, insert data into the database
        if ($upload_success) {
            $stmt = $conn->prepare("INSERT INTO berkas (users_id, ijazah, skhun, kk, ktp_ayah, ktp_ibu, kbs) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $user_id, $file_paths['ijazah'], $file_paths['skhun'], $file_paths['kk'], $file_paths['ktp_ayah'], $file_paths['ktp_ibu'], $file_paths['kbs']);

            if ($stmt->execute()) {
                $_SESSION['upload_message'] = "Data berkas berhasil diupload.";
                header("Location: index.php?page=display_berkas");
                exit;
            } else {
                $_SESSION['upload_message'] = "Error: " . $stmt->error;
            }

            $stmt->close(); // Menutup statement setelah selesai digunakan
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload Berkas</title>
        <link rel="icon" href="../../assets/img/icon.png" type="image/png">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container mt-5">
            <h2 class="mb-4 text-center">Upload Berkas</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="ijazah" class="form-label">Ijazah (PDF, DOCX):</label>
                    <input type="file" class="form-control" id="ijazah" name="ijazah" accept=".pdf,.docx" required>
                </div>
                <div class="mb-3">
                    <label for="skhun" class="form-label">SKHUN (PDF, DOCX):</label>
                    <input type="file" class="form-control" id="skhun" name="skhun" accept=".pdf,.docx" required>
                </div>
                <div class="mb-3">
                    <label for="kk" class="form-label">Kartu Keluarga (PDF, PNG, JPG, JPEG):</label>
                    <input type="file" class="form-control" id="kk" name="kk" accept=".pdf,.png,.jpg,.jpeg" required>
                </div>
                <div class="mb-3">
                    <label for="ktp_ayah" class="form-label">KTP Ayah (PDF, PNG, JPG, JPEG):</label>
                    <input type="file" class="form-control" id="ktp_ayah" name="ktp_ayah" accept=".pdf,.png,.jpg,.jpeg" required>
                </div>
                <div class="mb-3">
                    <label for="ktp_ibu" class="form-label">KTP Ibu (PDF, PNG, JPG, JPEG):</label>
                    <input type="file" class="form-control" id="ktp_ibu" name="ktp_ibu" accept=".pdf,.png,.jpg,.jpeg" required>
                </div>
                <div class="mb-3">
                    <label for="kbs" class="form-label">Kartu Bantuan Sosial (PDF, DOCX):</label>
                    <input type="file" class="form-control" id="kbs" name="kbs" accept=".pdf,.docx" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
}
$conn->close(); // Menutup koneksi setelah semua selesai
ob_end_flush(); // Akhiri output buffering dan kirim semua output yang tertunda
?>