<?php

$user_id = $_SESSION['users_id'];

// Jika ada parameter id yang dikirimkan melalui URL
if (isset($_GET['id'])) {
    $berkas_id = $_GET['id'];

    // Query untuk mengambil data berkas berdasarkan id
    $sql = "SELECT * FROM berkas WHERE id = ? AND users_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $berkas_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $target_dir = "../uploads/";
            $allowed_extensions = array('pdf', 'docx', 'png', 'jpg', 'jpeg');

            // Fungsi untuk mendapatkan ekstensi berkas
            function getFileExtension($filename)
            {
                return pathinfo($filename, PATHINFO_EXTENSION);
            }

            // Mengelola upload berkas untuk setiap jenis berkas yang diubah
            $upload_success = true;
            $updated_files = [];

            // Helper function to handle file upload
            function handleFileUpload($file_key, $target_dir, $allowed_extensions, &$row)
            {
                if (!empty($_FILES[$file_key]['name'])) {
                    $file_name = $_FILES[$file_key]['name'];
                    $file_tmp = $_FILES[$file_key]['tmp_name'];
                    $file_ext = getFileExtension($file_name);

                    if (in_array(strtolower($file_ext), $allowed_extensions)) {
                        $target_file = $target_dir . basename($file_name);
                        if (move_uploaded_file($file_tmp, $target_file)) {
                            return $target_file;
                        } else {
                            echo "Gagal mengunggah $file_key.<br>";
                        }
                    } else {
                        echo "Hanya file dengan ekstensi yang diizinkan untuk $file_key.<br>";
                    }
                }
                return $row[$file_key];
            }

            $updated_files['ijazah'] = handleFileUpload('ijazah', $target_dir, $allowed_extensions, $row);
            $updated_files['skhun'] = handleFileUpload('skhun', $target_dir, $allowed_extensions, $row);
            $updated_files['kk'] = handleFileUpload('kk', $target_dir, $allowed_extensions, $row);
            $updated_files['ktp_ayah'] = handleFileUpload('ktp_ayah', $target_dir, $allowed_extensions, $row);
            $updated_files['ktp_ibu'] = handleFileUpload('ktp_ibu', $target_dir, $allowed_extensions, $row);
            $updated_files['kbs'] = handleFileUpload('kbs', $target_dir, $allowed_extensions, $row);

            if ($upload_success) {
                // Query untuk update data berkas di database
                $sql_update = "UPDATE berkas SET 
                                ijazah = ?, 
                                skhun = ?, 
                                kk = ?, 
                                ktp_ayah = ?, 
                                ktp_ibu = ?, 
                                kbs = ?
                              WHERE id = ? AND users_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ssssssii", $updated_files['ijazah'], $updated_files['skhun'], $updated_files['kk'], $updated_files['ktp_ayah'], $updated_files['ktp_ibu'], $updated_files['kbs'], $berkas_id, $user_id);

                if ($stmt_update->execute()) {
                    echo "Data berkas berhasil diupdate.";
                    header("Location: index.php?page=display_berkas");
                    exit;
                } else {
                    echo "Error: " . $stmt_update->error;
                }
            }
        }
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Data Berkas</title>
            <link rel="icon" href="../../assets/img/icon.png" type="image/png">
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f0f4f8;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }

                .container {
                    margin-top: 50px;
                    background-color: #fff;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                }

                h3 {
                    text-align: center;
                    margin-bottom: 30px;
                    font-weight: 600;
                    color: #333;
                }

                .table thead {
                    background-color: #007bff;
                    color: #fff;
                }

                .table th,
                .table td {
                    text-align: center;
                    vertical-align: middle;
                }

                .btn-primary {
                    background-color: #007bff;
                    border-color: #007bff;
                    width: 100%;
                    padding: 10px;
                    font-size: 16px;
                    font-weight: 500;
                    border-radius: 8px;
                    transition: background-color 0.3s ease;
                }

                .btn-primary:hover {
                    background-color: #0056b3;
                }

                .btn-success {
                    background-color: #28a745;
                    border-color: #28a745;
                    padding: 5px 12px;
                    border-radius: 5px;
                    transition: background-color 0.3s ease;
                }

                .btn-success:hover {
                    background-color: #218838;
                }

                input[type="file"] {
                    border: 2px dashed #ddd;
                    padding: 10px;
                    border-radius: 8px;
                    transition: border-color 0.3s ease;
                }

                input[type="file"]:hover {
                    border-color: #007bff;
                }

                .form-control-file {
                    margin: 0 auto;
                    width: 80%;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h3>Edit Data Berkas</h3>
                <form method="post" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jenis Berkas</th>
                                    <th>File Saat Ini</th>
                                    <th>Unggah Berkas Baru</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ijazah</td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['ijazah']) ?>" target="_blank" class="btn btn-success">Lihat</a>
                                    </td>
                                    <td><input type="file" name="ijazah" accept=".pdf,.docx" class="form-control-file"></td>
                                </tr>
                                <tr>
                                    <td>SKHUN</td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['skhun']) ?>" target="_blank" class="btn btn-success">Lihat</a>
                                    </td>
                                    <td><input type="file" name="skhun" accept=".pdf,.docx" class="form-control-file"></td>
                                </tr>
                                <tr>
                                    <td>KK</td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['kk']) ?>" target="_blank" class="btn btn-success">Lihat</a>
                                    </td>
                                    <td><input type="file" name="kk" accept=".pdf,.png,.jpg,.jpeg" class="form-control-file"></td>
                                </tr>
                                <tr>
                                    <td>KTP Ayah</td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['ktp_ayah']) ?>" target="_blank" class="btn btn-success">Lihat</a>
                                    </td>
                                    <td><input type="file" name="ktp_ayah" accept=".pdf,.png,.jpg,.jpeg" class="form-control-file"></td>
                                </tr>
                                <tr>
                                    <td>KTP Ibu</td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['ktp_ibu']) ?>" target="_blank" class="btn btn-success">Lihat</a>
                                    </td>
                                    <td><input type="file" name="ktp_ibu" accept=".pdf,.png,.jpg,.jpeg" class="form-control-file"></td>
                                </tr>
                                <tr>
                                    <td>Kartu Bantuan Sosial</td>
                                    <td>
                                        <a href="<?= htmlspecialchars($row['kbs']) ?>" target="_blank" class="btn btn-success">Lihat</a>
                                    </td>
                                    <td><input type="file" name="kbs" accept=".pdf,.docx" class="form-control-file"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
                </form>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>

        </html>


<?php
    } else {
        echo "Data berkas tidak ditemukan.";
    }
}

$conn->close();
?>