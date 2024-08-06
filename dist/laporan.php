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
    <script type="text/javascript" src="chartjs/Chart.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Sorobayan Farma</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <?php
        include "nav/navbar.php";
        ?>
    </nav>
    <div id="layoutSidenav">
        <?php include "nav/sidenavbar.php"; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Laporan Penjualan Apotek</li>
                    </ol>
                </div>
                <div class="container-fluid px-4 mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="dateRangeForm">
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="tambah-laporan.php" class="btn btn-info btn-lg mt-4">
                                Tambah Laporan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="container-fluid px-4 mt-4">
                    <div class="row">
                        <div class="col-sm-12 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Penjualan
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart"></canvas>
                                </div>
                                <script>
                                    // Get current date and first date of the current year
                                    const today = new Date();
                                    const firstDayOfYear = new Date(today.getFullYear(), 0, 1);

                                    // Format date to YYYY-MM-DD
                                    function formatDate(date) {
                                        let day = date.getDate();
                                        let month = date.getMonth() + 1;
                                        const year = date.getFullYear();

                                        if (day < 10) {
                                            day = '0' + day;
                                        }
                                        if (month < 10) {
                                            month = '0' + month;
                                        }
                                        return `${year}-${month}-${day}`;
                                    }

                                    // Set default date values in the form
                                    document.getElementById('startDate').value = formatDate(firstDayOfYear);
                                    document.getElementById('endDate').value = formatDate(today);

                                    var ctx = document.getElementById("myChart").getContext('2d');
                                    var myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: [],
                                            datasets: [{
                                                label: 'Penjualan per Bulan',
                                                data: [],
                                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                borderColor: 'rgba(54, 162, 235, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });

                                    function fetchDataAndUpdateChart(startDate, endDate) {
                                        fetch(`fetch_data.php?startDate=${startDate}&endDate=${endDate}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                myChart.data.labels = data.labels;
                                                myChart.data.datasets[0].data = data.sales;
                                                myChart.update();
                                            })
                                            .catch(error => console.error('Error:', error));
                                    }

                                    document.getElementById('dateRangeForm').addEventListener('submit', function(event) {
                                        event.preventDefault();
                                        const startDate = document.getElementById('startDate').value;
                                        const endDate = document.getElementById('endDate').value;
                                        fetchDataAndUpdateChart(startDate, endDate);
                                    });

                                    // Fetch data for the initial load
                                    fetchDataAndUpdateChart(formatDate(firstDayOfYear), formatDate(today));
                                </script>
                            </div>
                        </div>
                        <div class="col-sm-12 d-flex mt-4">
                            <div class="card flex-fill">
                                <div class="card-header bg-transparent border">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table me-1"></i>
                                            Laporan Penjualan Apotek
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            include "config/koneksi.php";
                                            $order = mysqli_query($koneksi, "SELECT * FROM `order`");
                                            ?>
                                            <table id="datatablesSimple">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Nama Obat</th>
                                                        <th>Tanggal</th>
                                                        <th>Waktu</th>
                                                        <th>Kuantitas</th>
                                                        <th>Total Harga</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Nama Obat</th>
                                                        <th>Tanggal</th>
                                                        <th>Waktu</th>
                                                        <th>Kuantitas</th>
                                                        <th>Total Harga</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    if (mysqli_num_rows($order) > 0) {
                                                        foreach ($order as $key => $value) {
                                                    ?>
                                                            <tr>
                                                                <td><?= $value['id_order'] ?></td>
                                                                <td><?= $value['nama_obat'] ?></td>
                                                                <td><?= $value['tanggal'] ?></td>
                                                                <td><?= $value['time'] ?></td>
                                                                <td><?= $value['qty'] ?></td>
                                                                <td><?= $value['total_harga'] ?></td>
                                                                <td>
                                                                    <a href="detail-laporan.php?id=<?= $value['id_order'] ?>">Detail Laporan</a>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "footer/footer.php"; ?>
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