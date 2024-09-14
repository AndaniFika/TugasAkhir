<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        // Redirect ke halaman pengumuman setelah berhasil menambah pengumuman
        header("Location: index.php?page=pengumuman");
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengumuman</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        .container {
            padding: 20px;
            margin-top: 50px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #212529;
            margin-bottom: 20px;
        }

        .btn-secondary,
        .btn-success {
            border-radius: 4px;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-success {
            background-color: #28a745;
            border: 1px solid #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .form-label {
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="h3 mb-4 text-center">Tambah Pengumuman</h1>
        <a href="index.php?page=pengumuman" class="btn btn-secondary mb-4"><i class="fa-solid fa-arrow-rotate-left"></i> Kembali</a>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Pengumuman</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Judul Pengumuman" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Isi Pengumuman</label>
                <textarea class="form-control" id="content" name="content" rows="5" placeholder="Isi Pengumuman" required></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Tambah Pengumuman</button>
        </form>
    </div>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>