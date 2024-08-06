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
        <?php
        include "nav/navbar.php";
        ?>
    </nav>

    <div id="layoutSidenav">
        <?php
        include "nav/sidenavbar.php";
        include 'config/koneksi.php';

        // Query untuk obat terlaris musim hujan
        $queryHujan = "SELECT nama_obat, SUM(qty) AS total_qty
                       FROM `order`
                       WHERE MONTH(tanggal) IN (10, 11, 12, 1, 2, 3)
                       GROUP BY nama_obat
                       ORDER BY total_qty DESC
                       LIMIT 1;";
        $resultHujan = mysqli_query($koneksi, $queryHujan);
        $dataHujan = mysqli_fetch_array($resultHujan);
        $totalQtyHujan = $dataHujan['total_qty'];
        $namaObatHujan = $dataHujan['nama_obat'];

        // Query untuk obat terlaris musim kemarau
        $queryKemarau = "SELECT nama_obat, SUM(qty) AS total_qty
                         FROM `order`
                         WHERE MONTH(tanggal) IN (4, 5, 6, 7, 8, 9)
                         GROUP BY nama_obat
                         ORDER BY total_qty DESC
                         LIMIT 1;";
        $resultKemarau = mysqli_query($koneksi, $queryKemarau);
        $dataKemarau = mysqli_fetch_array($resultKemarau);
        $totalQtyKemarau = $dataKemarau['total_qty'];
        $namaObatKemarau = $dataKemarau['nama_obat'];
        ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Prediksi</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Gambaran umum tentang apa yang akan datang</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-3 d-flex align-items-stretch">
                            <div class="card border-info h-100 w-100">
                                <div class="card-body text-info text-center d-flex flex-column align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7" />
                                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
                                    </svg>
                                    <h5 class="card-title mt-3">
                                        <br>
                                    </h5>
                                    <p class="card-text" style="font-size: 20px;">Prediksi Obat Terlaris</p>
                                </div>
                                <div class="card-footer bg-info border-info text-center">
                                    <a href="prediksi-obat.php" class="medium text-black stretched-link">Lihat Prediksi Obat >></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-3 d-flex align-items-stretch">
                            <div class="card border-warning h-100 w-100">
                                <div class="card-body text-warning text-center d-flex flex-column align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" fill="#ffc107" class="bi bi-cloud-sun-fill" viewBox="0 0 16 16">
                                        <path d="M11.473 11a4.5 4.5 0 0 0-8.72-.99A3 3 0 0 0 3 16h8.5a2.5 2.5 0 0 0 0-5z" />
                                        <path d="M10.5 1.5a.5.5 0 0 0-1 0v1a.5.5 0 0 0 1 0zm3.743 1.964a.5.5 0 1 0-.707-.707l-.708.707a.5.5 0 0 0 .708.708zm-7.779-.707a.5.5 0 0 0-.707.707l.707.708a.5.5 0 1 0 .708-.708zm1.734 3.374a2 2 0 1 1 3.296 2.198q.3.423.516.898a3 3 0 1 0-4.84-3.225q.529.017 1.028.129m4.484 4.074c.6.215 1.125.59 1.522 1.072a.5.5 0 0 0 .039-.742l-.707-.707a.5.5 0 0 0-.854.377M14.5 6.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                    </svg>
                                    <h5 class="card-title mt-3"><br></h5>
                                    <p class="card-text" style="font-size: 20px;">Obat Terlaris Berdasarkan Musim</p>
                                </div>
                                <div class="card-footer bg-warning border-warning text-center">
                                    <a href="prediksi-cuaca2.php" class="medium text-black stretched-link">Lihat Detail Obat >></a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="container-fluid px-4 mt-4">
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Obat Terlaris Musim Hujan</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title">
                                                    <?= $totalQtyHujan ?>
                                                </h5>
                                                <p class="card-text">Obat Terjual (QTY)</p>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="card-title">
                                                    <?= $namaObatHujan ?>
                                                </h5>
                                                <p class="card-text">Nama Obat</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Obat Terlaris Musim Kemarau</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title">
                                                    <?= $totalQtyKemarau ?>
                                                </h5>
                                                <p class="card-text">Obat Terjual (QTY)</p>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="card-title">
                                                    <?= $namaObatKemarau ?>
                                                </h5>
                                                <p class="card-text">Nama Obat</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <?php
                    // Menghubungkan ke database
                    include 'config/koneksi.php';

                    // Query untuk mendapatkan prediksi obat terlaris berdasarkan rata-rata penjualan bulanan untuk musim hujan
                    $sql_hujan = "
                                    SELECT
                                        'Musim Hujan' AS musim,
                                        nama_obat,
                                        AVG(qty) AS prediksi_qty
                                    FROM (
                                        SELECT
                                            nama_obat,
                                            qty
                                        FROM
                                            `order`
                                        WHERE
                                            MONTH(tanggal) BETWEEN 10 AND 12 OR MONTH(tanggal) BETWEEN 1 AND 3
                                    ) AS sales
                                    GROUP BY
                                        nama_obat
                                    ORDER BY
                                        prediksi_qty DESC
                                    LIMIT 1;
                                    ";

                    // Query untuk mendapatkan prediksi obat terlaris berdasarkan rata-rata penjualan bulanan untuk musim kemarau
                    $sql_kemarau = "
                                    SELECT
                                        'Musim Kemarau' AS musim,
                                        nama_obat,
                                        AVG(qty) AS prediksi_qty
                                    FROM (
                                        SELECT
                                            nama_obat,
                                            qty
                                        FROM
                                            `order`
                                        WHERE
                                            MONTH(tanggal) BETWEEN 4 AND 9
                                    ) AS sales
                                    GROUP BY
                                        nama_obat
                                    ORDER BY
                                        prediksi_qty DESC
                                    LIMIT 1;
                                    ";

                    $result_hujan = $koneksi->query($sql_hujan);
                    $result_kemarau = $koneksi->query($sql_kemarau);
                    $musim_hujan = [];
                    $musim_kemarau = [];

                    if ($result_hujan->num_rows > 0) {
                        while ($row = $result_hujan->fetch_assoc()) {
                            $musim_hujan[] = $row;
                        }
                    }

                    if ($result_kemarau->num_rows > 0) {
                        while ($row = $result_kemarau->fetch_assoc()) {
                            $musim_kemarau[] = $row;
                        }
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Prediksi Obat Terlaris Musim Hujan</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title">
                                                    <?php
                                                    $row = $musim_hujan[0]; // Ambil baris pertama karena sudah diurutkan DESC
                                                    echo $row["nama_obat"];
                                                    ?>
                                                </h5>
                                                <p class="card-text">Nama Obat</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Prediksi Obat Terlaris Musim Kemarau</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title">
                                                    <?php
                                                    $row = $musim_kemarau[0]; // Ambil baris pertama karena sudah diurutkan DESC
                                                    echo $row["nama_obat"];
                                                    ?>
                                                </h5>
                                                <p class="card-text">Nama Obat</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
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