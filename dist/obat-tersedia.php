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
    <title>Dashboard - SB Admin</title>
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

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Penyimpanan > Obat Tersedia() </h1>
                    <ol class="breadcrumb mb=4">
                        <li class="breadcrumb-item active">List obat yang tersedia untuk dijual</li>
                    </ol>
                    <div class="row">
                        <div class="col-md-6 mb-4">

                        </div>

                        <div class="col-md-6 mb-4 d-flex justify-content-end">
                            <div>
                                <a href="tambah-item.php" class="btn btn-danger btn-lg">
                                    Tambah Item
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <?php
                            include "config/koneksi.php";
                            $obat = mysqli_query($koneksi, "SELECT * FROM obat");
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $id_obat = $_POST['id_obat'];
                                $jumlah_stok = $_POST['jumlah_stok'];

                                // Query untuk menambahkan stok
                                $query = "UPDATE obat SET stok = stok + $jumlah_stok WHERE id_obat = $id_obat";

                                if (mysqli_query($koneksi, $query)) {
                                    // Redirect kembali ke halaman sebelumnya setelah berhasil
                                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                                    exit();
                                } else {
                                    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
                                }
                            }
                            ?>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>ID Obat</th>
                                        <th>Kategori</th>
                                        <th>Detail</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>ID Obat</th>
                                        <th>Kategori</th>
                                        <th>Detail</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <!-- Data Obat -->
                                    <?php
                                    if (mysqli_num_rows($obat) > 0) {
                                        foreach ($obat as $key => $value) {
                                    ?>
                                            <tr>
                                                <td><?= $value['nama_obat'] ?></td>
                                                <td><?= $value['id_obat'] ?></td>
                                                <td><?= $value['kategori'] ?></td>
                                                <td>
                                                    <a href="detail-obat.php?id=<?= $value['id_obat'] ?>">Detail Obat</a>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahObat" data-id="<?= $value['id_obat'] ?>" data-nama="<?= $value['nama_obat'] ?>">
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

    <!-- Modal Tambah Stok -->
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