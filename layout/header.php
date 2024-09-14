<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTs AL-MUHAJIRIN Waihatu</title>
    <link rel="stylesheet" type="text/css" href="layout/styles.css">
    <link rel="icon" href="assets/img/icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container">
            <a class="logo" href="index.php">
                <ul>
                    <li><img src="assets/img/logo.png" alt="Logo"></li>
                    <li>
                        <h1>MTs AL - MUHAJIRIN</h1>
                        <p>Waihatu</p>
                    </li>
                </ul>
            </a>
            <nav>
                <ul>
                    <li><a href="#profil">Profil</a></li>
                    <li><a href="#lokasi">Lokasi</a></li>
                    <li><a href="#pengumuman">Pengumuman</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </header>

</body>
<script>
    document.querySelector('.nav-toggle').addEventListener('click', function() {
        document.querySelector('header nav').classList.toggle('active');
    });
</script>

</html>