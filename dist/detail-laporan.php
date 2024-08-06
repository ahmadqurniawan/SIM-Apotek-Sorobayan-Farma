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
        include 'config/koneksi.php';

        if (@$_GET['id']) {
            $id = $_GET['id'];

            // Query untuk mengambil detail order berdasarkan ID
            $queryOrder = "SELECT * FROM `order` WHERE id_order = '$id'";
            $resultOrder = mysqli_query($koneksi, $queryOrder);
            $order = mysqli_fetch_array($resultOrder);
        }
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Laporan > Detail Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Detail Tentang Laporan</li>
                    </ol>

                    <div class="row">
                        <div class="col-md-6 mb-4">

                        </div>

                        <div class="col-md-6 mb-4 d-flex justify-content-end">
                            <div>
                                <a href="tambah-laporan.php?id=<?= $order['id_order'] ?>" class="btn btn-primary btn-lg">Edit </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid px-4 mt-4">
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Tentang</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title"><?= $order['id_order'] ?></h5>
                                                <p class="card-text">ID Order</p>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="card-title"><?= $order['nama_obat'] ?></h5>
                                                <p class="card-text">Nama Obat</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header bg-transparent border">
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4">Keterangan Waktu</div>
                                        <div class="col-4"></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-3">
                                                <h5 class="card-title"><?= $order['tanggal'] ?></h5>
                                                <p class="card-text">Tanggal</p>
                                            </div>
                                            <div class="col-3">

                                            </div>
                                            <div class="col-3">
                                                <h5 class="card-title"><?= $order['time'] ?></h5>
                                                <p class="card-text">Waktu</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid px-4 mt-4">
                    <div class="row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Kuantitas</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="card-text"><?= $order['qty'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-4">
                            <div class="card">
                                <div class="card-header bg-transparent border">Total Harga</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="card-text"><?= $order['total_harga'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-3 mt-4">
                            <a class="btn btn-outline-danger" href="act/order-act.php?id_order=<?= $order['id_order'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>Hapus Laporan</a>
                        </div>
                    </div>
                </div>
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