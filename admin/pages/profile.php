<?php
// Ambil data pengguna berdasarkan ID
$users_id = $_SESSION['users_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $users_id);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Jika ada foto profil yang di-upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = basename($_FILES['profile_picture']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        // Validasi tipe file
        if (in_array($file_ext, $allowed_ext)) {
            // Gunakan nama file yang unik untuk menghindari bentrokan
            $unique_file_name = uniqid() . '.' . $file_ext;
            $file_path = '../assets/admin/' . $unique_file_name;

            if (move_uploaded_file($file_tmp, $file_path)) {
                // Hapus foto profil lama jika ada
                if (!empty($users['profile_picture'])) {
                    $old_file_path = '../assets/admin/' . $users['profile_picture'];
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }

                // Update nama file foto baru di database
                $update_query = "UPDATE users SET profile_picture = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("si", $unique_file_name, $users_id);
                $stmt->execute();
                header("Location: index.php?page=profile");
                exit;
            } else {
                $error = "Failed to upload file.";
            }
        } else {
            $error = "Invalid file type.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-top: 50px;
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3436;
        }

        .form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: #636e72;
        }

        .img-thumbnail {
            border-radius: 50%;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .img-thumbnail:hover {
            transform: scale(1.1);
        }

        .form-control {
            padding: 10px;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: #00b894;
            border-color: #00b894;
            font-size: 1rem;
            font-weight: 600;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #00cec9;
        }

        .alert-danger {
            font-size: 0.95rem;
            margin-bottom: 20px;
            border-radius: 8px;
            padding: 12px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin-top: 30px;
            }

            .img-thumbnail {
                width: 120px;
            }
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Profile</h2>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <label class="form-label">Profile Picture:</label>
                        <?php if ($users['profile_picture']) : ?>
                            <img src="../assets/admin/<?php echo htmlspecialchars($users['profile_picture']); ?>" alt="Profile Picture" class="img-thumbnail mb-3" width="150">
                        <?php else: ?>
                            <img src="../assets/img/default-profile.png" alt="Default Profile" class="img-thumbnail mb-3" width="150">
                        <?php endif; ?>
                        <input type="file" name="profile_picture" accept="image/*" class="form-control mt-3">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Profile Picture</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>