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
    <title>Sorobayan Farma - Prediksi Obat Terlaris</title>
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
        <?php include "nav/sidenavbar.php"; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Obat Terlaris</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Obat terlaris berdasarkan musim di Indonesia</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Obat Terlaris Berdasarkan Musim Hujan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Musim</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Menghubungkan ke database
                                    include '<config/koneksi.php';

                                    // Query untuk mendapatkan 5 obat terlaris dari setiap musim
                                    $sql = "
                                    SELECT
                                        musim,
                                        nama_obat,
                                        total_qty
                                    FROM (
                                        SELECT
                                            nama_obat,
                                            CASE
                                                WHEN MONTH(tanggal) BETWEEN 10 AND 12 OR MONTH(tanggal) BETWEEN 1 AND 3 THEN 'Musim Hujan'
                                                WHEN MONTH(tanggal) BETWEEN 4 AND 9 THEN 'Musim Kemarau'
                                            END AS musim,
                                            SUM(qty) AS total_qty,
                                            ROW_NUMBER() OVER(PARTITION BY musim ORDER BY SUM(qty) DESC) AS row_num
                                        FROM
                                            `order`
                                        GROUP BY
                                            nama_obat, musim
                                    ) AS ranked
                                    WHERE row_num <= 25
                                    ORDER BY
                                        musim, total_qty DESC;
                                    ";

                                    $result = $koneksi->query($sql);
                                    $musim_hujan = [];
                                    $musim_kemarau = [];

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row["musim"] == "Musim Hujan") {
                                                $musim_hujan[] = $row;
                                            } else {
                                                $musim_kemarau[] = $row;
                                            }
                                        }
                                    }

                                    foreach ($musim_hujan as $row) {
                                        echo "<tr><td>" . $row["musim"] . "</td><td>" . $row["nama_obat"] . "</td><td>" . $row["total_qty"] . "</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Obat Terlaris Berdasarkan Musim Kemarau
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple2" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Musim</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($musim_kemarau as $row) {
                                        echo "<tr><td>" . $row["musim"] . "</td><td>" . $row["nama_obat"] . "</td><td>" . $row["total_qty"] . "</td></tr>";
                                    }

                                    $koneksi->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "footer/footer.php"; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var datatablesSimple1 = document.getElementById('datatablesSimple1');
            var datatablesSimple2 = document.getElementById('datatablesSimple2');
            if (datatablesSimple1) {
                new simpleDatatables.DataTable(datatablesSimple1, {
                    searchable: true,
                    fixedHeight: true,
                    perPage: 5,
                });
            }
            if (datatablesSimple2) {
                new simpleDatatables.DataTable(datatablesSimple2, {
                    searchable: true,
                    fixedHeight: true,
                    perPage: 5,
                });
            }
        });
    </script>
</body>

</html>
