<?php
include('koneksi/db.php');
include('layout/header.php');

// Fetch the current status of the registration setting
$sql = "SELECT setting_value FROM settings WHERE setting_key = 'Buka'";
$result = $conn->query($sql);
$registration_status = $result->fetch_assoc()['setting_value'];

// Redirect to index.php if registration is closed
if ($registration_status !== 'Buka') {
    header("Location: index.php");
    exit;
}

// Initialize error message variable
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'siswa'; // Automatically set role as 'siswa'

    // Prepare and execute the query to check if username is available
    $sql_check_username = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql_check_username);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result_check_username = $stmt->get_result();

    if ($result_check_username->num_rows > 0) {
        // Username already exists, set error message
        $error_message = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Prepare and execute the query to insert new user data
        $sql_insert_users = "INSERT INTO users (username, password, role, data_filled) VALUES (?, ?, ?, 0)";
        $stmt = $conn->prepare($sql_insert_users);
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            $users_id = $conn->insert_id;

            // Redirect to data entry form
            header("Location: form_data_siswa.php?users_id=$users_id");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!-- Remove navbar button -->
<style>
    header nav {
        display: none;
    }

    a {
        pointer-events: none;
        color: #999;
        text-decoration: none;
        cursor: default;
    }
</style>
<!-- End of remove navbar button -->

<div class="container-L">
    <h2>Registrasi</h2><br>
    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
</div>