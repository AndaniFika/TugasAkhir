<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Nunito', sans-serif;
        }

        .container {
            margin-top: 60px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-body {
            padding: 30px;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-label {
            font-weight: 600;
            color: #34495e;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        .form-select {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .alert {
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <!-- Change Password Form -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Ubah Password</h1>
                        <?php if (isset($_SESSION['message'])) : ?>
                            <div class="alert alert-info" role="alert">
                                <?php echo $_SESSION['message'];
                                unset($_SESSION['message']); ?>
                            </div>
                        <?php endif; ?>
                        <form action="index.php?page=proses_setting" method="post">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat ini:</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru:</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password Baru:</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Button Status Form -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Status Pendaftaran</h1>
                        <?php
                        // Check if the form has been submitted
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $status = $_POST['Buka'];
                            $sql = "UPDATE settings SET setting_value = ? WHERE setting_key = 'Buka'";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $status);
                            $stmt->execute();
                            $stmt->close();
                            echo "<div class='alert alert-success'>Status Pendaftaran Berhasil Diubah!!</div>";
                        }

                        // Fetch the current status
                        $sql = "SELECT setting_value FROM settings WHERE setting_key = 'Buka'";
                        $result = $conn->query($sql);
                        $current_status = $result->fetch_assoc()['setting_value'];
                        $conn->close();
                        ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="Buka" class="form-label">Pilih Status:</label>
                                <select name="Buka" id="Buka" class="form-select">
                                    <option value="Buka" <?= $current_status == 'Tutup' ? 'selected' : '' ?>>Buka</option>
                                    <option value="Tutup" <?= $current_status == 'Buka' ? 'selected' : '' ?>>Tutup</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>