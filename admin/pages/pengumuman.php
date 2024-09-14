<?php

$sql = "SELECT * FROM announcements ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Pengumuman</title>
    <link rel="icon" href="../../assets/img/icon.png" type="image/png">
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

        .btn-primary {
            background-color: #007bff;
            border: 1px solid #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #00408d;
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

        td {
            vertical-align: top;
            /* Aligns text at the top for better readability */
        }

        .no-wrap {
            white-space: nowrap;
            /* Prevents wrapping for non-text content */
        }
    </style>

</head>

<body>

    <div class="container mt-5">
        <h1 class="h3 mb-5 text-center">Daftar Pengumuman</h1>

        <a href="index.php?page=input_pengumuman" class="btn btn-primary mb-4"><i class="fa-solid fa-square-plus"></i> Tambah</a>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Isi Pengumuman</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['content'])); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td class="text-center">
                                <a href="index.php?page=delete_pengumuman&id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>