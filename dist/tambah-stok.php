<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sorobayan Farma</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Sorobayan Farma</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div> -->
        </form>
        <!-- Navbar-->
        <?php
        include "nav/navbar.php";
        ?>
    </nav>

    <div id="layoutSidenav">

        <?php
        include "nav/sidenavbar.php";
        ?>

        <?php
        if (@$_GET['id']) {
            include "config/koneksi.php";

            $id = $_GET['id'];
            $query = "SELECT * FROM obat WHERE id_obat = '$id'";
            $obat = mysqli_fetch_array(mysqli_query($koneksi, $query));
        }
        ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Penyimpanan > Obat Tersedia > Form Item </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">*Semua kolom wajib diisi, kecuali disebutkan sebagai (opsional).</li>
                    </ol>
                    <form action="proses-tambah-stok.php" method="post">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3 mt-2">
                                    <label for="nama_obat" class="form-label">Nama Obat</label>
                                    <input name="nama_obat" type="text" class="form-control" id="nama_obat" value="<?= @$obat['nama_obat'] ?>">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3 mt-2">
                                    <label for="id" class="form-label">ID</label>
                                    <input name="id" type="number" class="form-control" id="id" value="<?= @$obat['id_obat'] ?>">
                                </div>
                            </div>
                            <div class="col">

                            </div>
                            <div class="col">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3 mt-2">
                                    <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                                    <input name="jumlah_stok" type="text" class="form-control" id="jumlah_stok">
                                </div>
                            </div>
                            <div class="col">

                            </div>
                            <div class="col">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="hidden" name="id_obat" value="<?= @$obat['id_obat'] ?>">
                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            <div class="col-4">

                            </div>
                            <div class="col">

                            </div>
                            <div class="col">

                            </div>
                        </div>
                </div>
                </form>
            </main>
            <?php
            include "footer/footer.php";
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>