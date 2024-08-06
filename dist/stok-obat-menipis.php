<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Proses form jika method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_obat = $_POST['id_obat'];
    $jumlah_stok = $_POST['jumlah_stok'];

    // Lakukan validasi atau proses penyimpanan
    // Misalnya, jika validasi gagal atau penyimpanan ke database gagal
    $simpan_berhasil = true; // Ganti ini dengan logika validasi atau penyimpanan

    if ($simpan_berhasil) {
        // Redirect kembali ke halaman sebelumnya setelah berhasil
        echo '<script>alert("Stok berhasil ditambahkan"); window.location.href = "obat-tersedia.php";</script>';
        exit();
    } else {
        // Jika gagal, kembali ke halaman sebelumnya dengan pesan error
        echo '<script>alert("Gagal menambahkan stok"); window.history.back();</script>';
    }
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
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
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
                    <h1 class="mt-4">Penyimpanan > Stok Obat Menipis</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">List obat dengan stok di bawah 15</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-body">
                            <?php
                            include "config/koneksi.php";

                            // // Query untuk mendapatkan obat dengan stok di bawah 15 setelah dikurangi qty dari tabel order
                            // $query = "SELECT obat.id_obat, obat.nama_obat, obat.stok - COALESCE(SUM(`order`.qty), 0) AS sisa_stok
                            //             FROM obat
                            //             LEFT JOIN `order` ON obat.nama_obat = `order`.nama_obat
                            //             GROUP BY obat.nama_obat
                            //             HAVING sisa_stok < 15";

                            // Query untuk mengambil detail obat berdasarkan ID
                            $queryObat = "SELECT * FROM obat WHERE stok < 15";
                            $resultObat = mysqli_query($koneksi, $queryObat);
                            $obat = mysqli_fetch_array($resultObat);

                            ?>
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data Obat -->
                                    <?php
                                    if (mysqli_num_rows($resultObat) > 0) {
                                        while ($row = mysqli_fetch_assoc($resultObat)) {
                                    ?>
                                            <tr>
                                                <td><?= $row['id_obat'] ?></td>
                                                <td><?= $row['nama_obat'] ?></td>
                                                <td><?= $row['stok'] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahObat" data-id="<?= $row['id_obat'] ?>" data-nama="<?= $row['nama_obat'] ?>">
                                                        Tambah Stok
                                                    </button>
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
            </main>
            <?php
            include "footer/footer.php";
            ?>
        </div>
    </div>

    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="modalTambahObat" tabindex="-1" aria-labelledby="modalTambahObatLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahObatLabel">Tambah Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="proses-tambah-stok.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_obat" id="id_obat">
                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_stok" class="form-label">Jumlah Stok yang Ditambahkan</label>
                            <input type="text" class="form-control" id="jumlah_stok" name="jumlah_stok" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        var modalTambahObat = document.getElementById('modalTambahObat');
        modalTambahObat.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var idObat = button.getAttribute('data-id');
            var namaObat = button.getAttribute('data-nama');

            var modalIdObatInput = modalTambahObat.querySelector('#id_obat');
            var modalNamaObatInput = modalTambahObat.querySelector('#nama_obat');

            modalIdObatInput.value = idObat;
            modalNamaObatInput.value = namaObat;
        });
    </script>
</body>

</html>