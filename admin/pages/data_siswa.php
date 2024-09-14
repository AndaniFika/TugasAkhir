<?php
// Initialize variables
$search = "";
$tahun_daftar_filter = "";

// Query to get distinct years from the database
$sql_tahun_daftar = "SELECT DISTINCT tahun_daftar FROM siswa ORDER BY tahun_daftar DESC";
$tahun_daftar_result = $conn->query($sql_tahun_daftar);

// Handle search and filter
if (isset($_GET['search']) || isset($_GET['tahun_daftar'])) {
    $search = $_GET['search'] ?? '';
    $tahun_daftar_filter = $_GET['tahun_daftar'] ?? '';

    $sql = "SELECT users.id AS user_id, users.username, siswa.id AS siswa_id, siswa.nama, siswa.nisn, siswa.tahun_daftar
            FROM users
            LEFT JOIN siswa ON users.id = siswa.users_id
            WHERE users.role = 'siswa' AND (users.username LIKE ? OR siswa.nama LIKE ? OR siswa.nisn LIKE ? OR siswa.tahun_daftar LIKE ?)";

    // Apply year filter if provided
    if (!empty($tahun_daftar_filter)) {
        $sql .= " AND siswa.tahun_daftar = ?";
    }

    // Add ORDER BY clause
    $sql .= " ORDER BY siswa.tahun_daftar DESC";

    $stmt = $conn->prepare($sql);
    $search_param = "%{$search}%";

    if (!empty($tahun_daftar_filter)) {
        $stmt->bind_param("sssss", $search_param, $search_param, $search_param, $search_param, $tahun_daftar_filter);
    } else {
        $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
    }
} else {
    $sql = "SELECT users.id AS user_id, users.username, siswa.id AS siswa_id, siswa.nama, siswa.nisn, siswa.tahun_daftar
            FROM users
            LEFT JOIN siswa ON users.id = siswa.users_id
            WHERE users.role = 'siswa'
            ORDER BY siswa.tahun_daftar DESC";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

// Check documents
$sql_berkas = "SELECT users_id FROM berkas GROUP BY users_id";
$berkas_result = $conn->query($sql_berkas);
$berkas_users = [];
while ($row = $berkas_result->fetch_assoc()) {
    $berkas_users[] = $row['users_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #212529;
            margin-bottom: 20px;
        }

        .form-select,
        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .btn {
            border-radius: 4px;
            border: 1px solid transparent;
        }

        .btn-outline-primary {
            border-color: #212529;
            color: #212529;
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            background-color: #212529;
            color: #ffffff;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #ffffff;
            border: 1px solid #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-success {
            background-color: #28a745;
            color: #ffffff;
            border: 1px solid #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            border: 1px solid #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #ffffff;
            border: 1px solid #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            background-color: #ffffff;
            /* White background for the table */
        }

        .table thead {
            background-color: #ffffff;
            /* White background for the table header */
            text-align: center;
            color: #212529;
        }

        .table thead th {
            border-bottom: 2px solid #000000;
            /* Black border under each column header */
        }

        .table tbody tr {
            border-bottom: 1px solid #000000;
            /* Black border for rows */
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #ffffff;
            /* White background for odd rows */
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #ffffff;
            /* White background for even rows */
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
            /* Light gray background on hover */
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .no-wrap {
            white-space: nowrap;
        }
    </style>


</head>

<body>
    <div class="container mt-5">
        <h1 class="h3 mb-5 text-center">Daftar Siswa</h1>
        <div class="row mb-3">
            <div class="col-md-4">
                <form class="d-flex" method="GET" action="index.php?page=data_siswa">
                    <input type="hidden" name="page" value="data_siswa">
                    <select class="form-select" name="tahun_daftar" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        <?php while ($tahun_row = $tahun_daftar_result->fetch_assoc()) : ?>
                            <option value="<?= htmlspecialchars($tahun_row['tahun_daftar']) ?>" <?= $tahun_daftar_filter == $tahun_row['tahun_daftar'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tahun_row['tahun_daftar']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </form>
            </div>
            <div class="col-md-8">
                <div class="d-flex justify-content-end">
                    <form class="d-flex" method="GET" action="index.php?page=data_siswa">
                        <input type="hidden" name="page" value="data_siswa">
                        <input type="text" class="form-control me-2" name="search" placeholder="Pencarian..." value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Tahun Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['nama'] ?? 'Data tidak ada') ?></td>
                            <td><?= htmlspecialchars($row['nisn'] ?? 'Data tidak ada') ?></td>
                            <td><?= htmlspecialchars($row['tahun_daftar'] ?? 'Data tidak ada') ?></td>
                            <td class="text-center">
                                <?php if ($row['siswa_id']) : ?>
                                    <a href="index.php?page=detail_siswa&id=<?= htmlspecialchars($row['user_id']) ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-eye"></i> Data</a>
                                <?php else : ?>
                                    <button class="btn btn-secondary btn-sm" disabled><i class="fa-solid fa-eye"></i> Data</button>
                                <?php endif; ?>
                                <?php if ($row['siswa_id'] && in_array($row['user_id'], $berkas_users)) : ?>
                                    <a href="index.php?page=lihat_berkas&id=<?= htmlspecialchars($row['user_id']) ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-eye"></i> Berkas</a>
                                <?php else : ?>
                                    <button class="btn btn-secondary btn-sm" disabled><i class="fa-solid fa-eye"></i> Berkas</button>
                                <?php endif; ?>
                                <a href="index.php?page=delete_siswa&id=<?= htmlspecialchars($row['user_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data siswa yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>