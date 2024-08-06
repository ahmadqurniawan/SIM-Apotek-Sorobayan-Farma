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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">

        <?php
        session_start(); // Mulai session di awal file

        include "nav/sidenavbar.php";
        include "config/koneksi.php";

        $message = "";

        // Cek apakah ada penanda data tersimpan
        if (!isset($_SESSION['data_saved'])) {
            include "config/koneksi.php";

            // $nama_obat = $_POST['nama_obat'] ?? null;
            // $kategori = $_POST['kategori'] ?? null;
            // $stok = $_POST['stok'] ?? null;
            // $pedoman_pemakaian = $_POST['pedoman_pemakaian'] ?? null;
            // $efek_samping = $_POST['efek_samping'] ?? null;
            // $harga = $_POST['harga'] ?? null;

            // if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //     // $query = "INSERT INTO obat_sampah (nama_obat, kategori, stok, pedoman_pemakaian, efek_samping, harga) 
            //     //             VALUES ('$nama_obat', '$kategori', '$stok', '$pedoman_pemakaian', '$efek_samping', '$harga')";
            //     // $id = $_GET['id_obat'];
            //     // mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
            //     // mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat = '$id'") or die (mysqli_error($koneksi));
            //     // header('Location: ../obat-tersedia.php');

            //     $id = $_POST['id_obat'];

            //     // Select the data from the obat table
            //     $result = mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat = '$id'") or die(mysqli_error($koneksi));
            //     $row = mysqli_fetch_assoc($result);

            //     if ($row) {
            //         $id_obat = $row['id_obat'];
            //         $nama_obat = $row['nama_obat'];
            //         $kategori = $row['kategori'];
            //         $stok = $row['stok'];
            //         $pedoman_pemakaian = $row['pedoman_pemakaian'];
            //         $efek_samping = $row['efek_samping'];
            //         $harga = $row['harga'];

            //         // Insert the data into obat_sampah table
            //         $query = "INSERT INTO obat_sampah (id_obat, nama_obat, kategori, stok, pedoman_pemakaian, efek_samping, harga) 
            //       VALUES ('$id_obat', '$nama_obat', '$kategori', '$stok', '$pedoman_pemakaian', '$efek_samping', '$harga')";
            //         mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

            //         // Delete the record from the obat table
            //         mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat = '$id'") or die(mysqli_error($koneksi));
            //         // header('Location: obat-tersedia.php');
            //     }
            // } elseif (@$_POST['id_obat']) {
            //     $id = $_POST['id_obat'];
            //     $query = "UPDATE obat SET
            //     nama_obat = '$nama_obat',
            //     kategori = '$kategori',
            //     stok = '$stok',
            //     pedoman_pemakaian = '$pedoman_pemakaian',
            //     efek_samping = '$efek_samping',
            //     harga = '$harga'
            //     WHERE id_obat = '$id'";
            //     mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
            //     // header('Location: obat-tersedia.php');
            // } else {
            //     $query = "INSERT INTO obat (nama_obat, kategori, stok, pedoman_pemakaian, efek_samping, harga) 
            //     VALUES ('$nama_obat', '$kategori', '$stok', '$pedoman_pemakaian', '$efek_samping', '$harga')";
            //     mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
            //     // header('Location: obat-tersedia.php');
            // }

            // Jika metode request adalah POST (form disubmit)
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $tanggal = $_POST['tanggal'] ?? null;
                $time = $_POST['time'] ?? null;
                $nama_obat = $_POST['nama_obat'] ?? null;
                $qty = $_POST['qty'] ?? null;
                $total_harga = $_POST['total_harga'] ?? null;
                $nama_obat = $_POST['nama_obat'] ?? null;
                $kategori = $_POST['kategori'] ?? null;
                $stok = $_POST['stok'] ?? null;
                $pedoman_pemakaian = $_POST['pedoman_pemakaian'] ?? null;
                $efek_samping = $_POST['efek_samping'] ?? null;
                $harga = $_POST['harga'] ?? null;
                $qty = $_POST['qty'] ?? null;
                $id_order = $_POST['id_order'] ?? null;

                $query = "INSERT INTO `order` (tanggal, `time`, nama_obat, qty, total_harga) 
                VALUES ('$tanggal', '$time', '$nama_obat', '$qty', '$total_harga')";
                mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

                // Cek jika ada kolom yang kosong
                if (empty($nama_obat) || empty($qty) || empty($_POST['tanggal']) || empty($_POST['time'])) {
                    $message = "Semua kolom harus diisi.";
                } else {
                    // Cek stok obat
                    $stok_query = "SELECT stok FROM obat WHERE nama_obat = '$nama_obat'";
                    $stok_result = mysqli_query($koneksi, $stok_query);
                    $stok_data = mysqli_fetch_assoc($stok_result);

                    if ($stok_data['stok'] <= 0) {
                        $message = "Stok obat kosong. Tidak bisa memperbarui stok.";
                    } else if ($stok_data['stok'] < $qty) {
                        $message = "Stok obat tidak mencukupi.";
                    } else {
                        // Update stok obat
                        $update_stok_query = "UPDATE obat SET stok = stok - $qty WHERE nama_obat = '$nama_obat'";
                        $result = mysqli_query($koneksi, $update_stok_query);

                        if ($result) {
                            $message = "Stok obat berhasil diperbarui.";

                            // Proses penyimpanan data order
                            $order_query = "UPDATE `order` SET 
                            nama_obat = '$nama_obat', 
                            total_harga = total_harga, 
                            qty = '$qty', 
                            tanggal = '" . $_POST['tanggal'] . "', 
                            time = '" . $_POST['time'] . "' 
                            WHERE id_order = '$id_order'";

                            if (mysqli_query($koneksi, $order_query)) {
                                $_SESSION['data_saved'] = true; // Set penanda data tersimpan
                                echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil ditambah',
                                }).then(function() {
                                    window.location = 'tambah-laporan.php'; // Ganti dengan halaman yang sesuai
                                });
                              </script>";
                                exit; // Keluar dari skrip PHP setelah mengarahkan
                            } else {
                                $message = "Gagal memperbarui data order: " . mysqli_error($koneksi);
                            }
                        } else {
                            $message = "Gagal memperbarui stok obat: " . mysqli_error($koneksi);
                        }
                    }
                }
            }
        }

        // Hapus penanda setelah pemrosesan selesai (opsional)
        unset($_SESSION['data_saved']);

        // Ambil data order jika ada parameter id yang diberikan
        if (@$_GET['id']) {
            $id = $_GET['id'];
            $query = "SELECT * FROM `order` WHERE id_order = '$id'";
            $order = mysqli_fetch_array(mysqli_query($koneksi, $query));
        }
        ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Laporan > Tambah Laporan </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">*Semua kolom wajib diisi, kecuali disebutkan sebagai
                            (opsional).</li>
                    </ol>
                    <?php
                    if (!empty($message)) {
                        echo '<div class="alert alert-danger">' . $message . '</div>';
                    }
                    ?>
                    <form action="" method="post" onsubmit="return validateForm()">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3 mt-2">
                                    <label for="nama_obat" class="form-label">Nama Obat</label>
                                    <input name="nama_obat" type="text" class="form-control" id="nama_obat" value="<?= @$order['nama_obat'] ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3 mt-2">
                                    <label for="total_harga" class="form-label">Total Harga</label>
                                    <input name="total_harga" type="number" class="form-control" id="total_harga" value="<?= @$order['total_harga'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="qty" class="form-label">Kuantitas</label>
                                    <input name="qty" type="number" class="form-control" id="qty" value="<?= @$order['qty'] ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input name="tanggal" type="date" class="form-control" id="tanggal" value="<?= @$order['tanggal'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-5">
                                <label for="time" class="form-label">Waktu</label>
                                <input name="time" type="time" class="form-control" id="time" value="<?= @$order['time'] ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <input type="hidden" name="id_order" value="<?= @$order['id_order'] ?>">
                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const namaObatInput = document.getElementById("nama_obat");
            const qtyInput = document.getElementById("qty");
            const totalHargaInput = document.getElementById("total_harga");

            async function updateTotalHarga() {
                const namaObat = namaObatInput.value;
                const qty = qtyInput.value;
                if (namaObat && qty) {
                    try {
                        const response = await fetch(`get_price.php?nama_obat=${namaObat}`);
                        const data = await response.json();
                        if (data.harga) {
                            const totalHarga = data.harga * qty;
                            totalHargaInput.value = totalHarga;
                        } else {
                            console.error(data.error);
                        }
                    } catch (error) {
                        console.error("Error fetching price:", error);
                    }
                }
            }

            namaObatInput.addEventListener("change", updateTotalHarga);
            qtyInput.addEventListener("input", updateTotalHarga);
        });

        function validateForm() {
            const namaObat = document.getElementById("nama_obat").value;
            const qty = document.getElementById("qty").value;
            const tanggal = document.getElementById("tanggal").value;
            const time = document.getElementById("time").value;

            if (namaObat.trim() === "" || qty.trim() === "" || tanggal.trim() === "" || time.trim() === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Semua kolom harus diisi!',
                });
                return false;
            }

            return true;
        }
    </script>
</body>

</html>