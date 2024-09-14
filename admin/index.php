<?php
ob_start(); // Mulai output buffering
session_start();

if (!isset($_SESSION['users_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include(__DIR__ . '/../koneksi/db.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Mendapatkan informasi pengguna yang login
$users_id = $_SESSION['users_id'];
$sql_users = "SELECT username, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql_users);
$stmt->bind_param("i", $users_id);
$stmt->execute();
$result_users = $stmt->get_result();
$users = $result_users->fetch_assoc();
$username = $users['username'];
$profile_picture = $users['profile_picture'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/icon.png" type="image/png">

    <title>Dashboard | Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="../assets/css/sb-admin-2.min.css">
    <link rel="stylesheet" href="../assets/css/conten_dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar {
            background: linear-gradient(135deg, #1cc88a, #17a673);
        }

        .sidebar .nav-item .nav-link {
            color: #f8f9fc;
        }

        .sidebar .nav-item .nav-link:hover {
            background-color: #2e59d9;
            color: #fff;
        }

        .sidebar-brand {
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.05rem;
            color: #fff;
        }

        .sidebar-brand:hover {
            color: #d1d3e2;
        }

        /* Navbar Styles */
        .topbar {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .navbar-nav .nav-item .nav-link .img-profile {
            border: 2px solid #1cc88a;
            box-shadow: 0px 0px 8px rgba(28, 200, 138, 0.4);
        }

        .navbar-nav .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Card Styles */
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Footer Styles */
        footer {
            background-color: #f8f9fc;
            border-top: 1px solid #e3e6f0;
        }

        footer span {
            font-size: 14px;
            color: #6c757d;
        }

        /* Scroll to Top Button */
        .scroll-to-top {
            background-color: #4e73df;
            border: none;
            color: #fff;
            font-size: 18px;
        }

        .scroll-to-top:hover {
            background-color: #224abe;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion sticky-sidebar" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="../assets/img/logo.png" alt="Logo" width="50" height="50">
                </div>
                <div class="sidebar-brand-text mx-3">Dashboard Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=dashboard_admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=data_siswa">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Data Siswa</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=pengumuman">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Pengumuman</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow sticky-top">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($username); ?></span>
                                <?php if ($users['profile_picture']) : ?>
                                    <img class="img-profile rounded-circle" src="../assets/admin/<?php echo htmlspecialchars($users['profile_picture']); ?>" alt="Profile Picture">
                                <?php endif; ?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="index.php?page=profile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="index.php?page=setting">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- panggil isi content -->
                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        $file = __DIR__ . '/pages/' . $page . '.php';
                        if (file_exists($file)) {
                            include $file;
                        } else {
                            echo "<p>Page not found.</p>";
                        }
                    } else {
                        include __DIR__ . '/pages/dashboard_admin.php';
                    }
                    ?>
                    <!-- end panggil isi content -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Mts Al-Muhajirin, Waihatu</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/chart-area-demo.js"></script>
    <script src="../assets/js/demo/chart-pie-demo.js"></script>

</body>

</html>

<?php
ob_end_flush();
?>