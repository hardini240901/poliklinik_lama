<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once("koneksi.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Poliklinik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <?php
                    if (!isset($_SESSION["role"])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?page=pendaftaranPasienBaru">Daftar Pasien Baru</a>
                </li>
                <?php
                    }
                ?>
                <?php
                    if (isset($_SESSION['role'])){
                        $role = $_SESSION['role'];
                        if($role == "admin"){

                        
                ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Master Data</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="index.php?page=obat">Obat</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="index.php?page=dokter">Dokter</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="index.php?page=poliklinik">Poli</a>
                                </li>
                            </ul>
                        </li>
                <?php
                        }
            
                        if ($role == "dokter"){
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Master Data</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="index.php?page=periksa">Periksa</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="index.php?page=riwayatpasien">Riwayat Pasien</a>
                                </li>
                            </ul>
                        </li>
                <?php
                        }
                        if ($role == "pasien"){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=daftarPoliklinik">Daftar Poli</a>
                        </li>
                <?php
                        }
                    }
                ?>
            </ul>

            <?php
                if (isset($_SESSION['role'])) {
                    // Jika pengguna sudah login, tampilkan tombol "Logout"
                ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="Logout.php">Logout (<?php echo $_SESSION['name'] ?>)</a>
                        </li>
                    </ul>
                <?php
                } else {
                    // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
                ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php?page=loginAdmin">Admin</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=loginDokter">Dokter</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php
                }
            ?>

        </div>
    </div>
    </nav>
    <main role="main" class="container">
        <?php
        
            if (isset($_GET['page'])) {
                include($_GET['page'] . ".php");
            } else {
                echo "<br><h2>Selamat Datang di Poliklinik Udinus";

                if (isset($_SESSION['role'])) {
                    //jika sudah login tampilkan username
                    echo ", " . $_SESSION['name'] . "</h2><hr>";
                } else {
                    echo "</h2><hr>Silakan Login untuk menggunakan Website. Jika belum memiliki akun silakan Register / Mendaftar terlebih dahulu.";
                }
            }
        ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>