<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $user_id = $_SESSION['users_id'];

    // Periksa password lama
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($current_password, $user['password'])) {
                if ($new_password === $confirm_password) {
                    // Update password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query = "UPDATE users SET password = ? WHERE id = ?";
                    $stmt = $conn->prepare($update_query);
                    if ($stmt) {
                        $stmt->bind_param("si", $hashed_password, $user_id);
                        if ($stmt->execute()) {
                            $_SESSION['message'] = "Password Telah Diubah.";
                            // Pengalihan ke halaman dashboard
                            header("Location: index.php?page=setting");
                            exit;
                        } else {
                            $_SESSION['message'] = "Terjadi kesalahan saat memperbarui password.";
                        }
                    } else {
                        $_SESSION['message'] = "Terjadi kesalahan saat menyiapkan pernyataan pembaruan.";
                    }
                } else {
                    $_SESSION['message'] = "Password baru tidak cocok.";
                }
            } else {
                $_SESSION['message'] = "Password saat ini tidak benar.";
            }
        } else {
            $_SESSION['message'] = "User tidak ditemukan.";
        }
    } else {
        $_SESSION['message'] = "Error preparing select statement.";
    }
}

// Jika tidak ada pengalihan, kembali ke halaman form dengan pesan kesalahan
header("Location: index.php?page=setting");
exit;
