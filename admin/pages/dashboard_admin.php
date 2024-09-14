<?php
// Mengambil jumlah siswa dari tabel 'siswa'
$sql_siswa = "SELECT COUNT(*) as total_siswa FROM siswa";
$result_siswa = $conn->query($sql_siswa);
$total_siswa = 0;

if ($result_siswa && $row_siswa = $result_siswa->fetch_assoc()) {
    $total_siswa = $row_siswa['total_siswa'];
}

// Mengambil jumlah pengguna dengan role 'siswa' dari tabel 'users'
$sql_users = "SELECT COUNT(*) as total_users_siswa FROM users WHERE role = 'siswa'";
$result_users = $conn->query($sql_users);
$total_users_siswa = 0;

if ($result_users && $row_users = $result_users->fetch_assoc()) {
    $total_users_siswa = $row_users['total_users_siswa'];
}

// Mengambil jumlah berkas dari tabel 'berkas'
$sql_berkas = "SELECT COUNT(*) as total_berkas FROM berkas";
$result_berkas = $conn->query($sql_berkas);
$total_berkas = 0;

if ($result_berkas && $row_berkas = $result_berkas->fetch_assoc()) {
    $total_berkas = $row_berkas['total_berkas'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../../styles.css">
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            color: #4A90E2;
            margin-bottom: 40px;
            letter-spacing: 1.5px;
        }

        .dashboard-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .dashboard-box {
            width: 270px;
            height: 180px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            margin: 20px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            position: relative;
            padding: 20px;
            color: #fff;
        }

        /* Warna latar belakang untuk setiap kotak dashboard */
        .box-siswa {
            background: linear-gradient(135deg, #FF8C00, #FFD700);
        }

        .box-users-siswa {
            background: linear-gradient(135deg, #42A5F5, #1E90FF);
        }

        .box-berkas {
            background: linear-gradient(135deg, #66BB6A, #32CD32);
        }

        .dashboard-box:hover {
            transform: scale(1.1);
            box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.2);
        }

        .dashboard-box h2 {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: #fff;
        }

        .dashboard-box p {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .dashboard-box .icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 2.5rem;
            opacity: 0.3;
        }

        /* Add subtle hover animation */
        .dashboard-box::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 15px;
            opacity: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: opacity 0.3s ease-in-out;
        }

        .dashboard-box:hover::after {
            opacity: 1;
        }

        /* Animasi loading */
        .loading-spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsif */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .dashboard-box {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Selamat Datang, Admin</h1>

        <!-- Loading Animation -->
        <div id="loading" class="loading-spinner"></div>

        <!-- Kotak jumlah siswa, jumlah pengguna dengan role 'siswa', dan jumlah berkas -->
        <div class="dashboard-container" style="display: none;" id="dashboardContent">
            <div class="dashboard-box box-siswa">
                <i class="fas fa-users icon"></i>
                <h2>Jumlah Siswa</h2>
                <p class="total-siswa"><?php echo $total_siswa; ?></p>
            </div>
            <div class="dashboard-box box-users-siswa">
                <i class="fas fa-user-graduate icon"></i>
                <h2>Pengguna (Siswa)</h2>
                <p class="total-users-siswa"><?php echo $total_users_siswa; ?></p>
            </div>
            <div class="dashboard-box box-berkas">
                <i class="fas fa-folder icon"></i>
                <h2>Jumlah Berkas</h2>
                <p class="total-berkas"><?php echo $total_berkas; ?></p>
            </div>
        </div>
    </div>

    <!-- Script to hide loading animation after 1 second -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('dashboardContent').style.display = 'flex';
            }, 1000);
        };
    </script>
</body>

</html>