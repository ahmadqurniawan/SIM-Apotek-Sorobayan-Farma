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
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Penyimpanan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Obat-obat yang tersedia</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-3 d-flex align-items-stretch">
                            <div class="card border-success h-100 w-100">
                                <div class="card-body text-success text-center d-flex flex-column align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" fill="currentColor" class="bi bi-prescription2" viewBox="0 0 16 16">
                                        <path d="M7 6h2v2h2v2H9v2H7v-2H5V8h2z" />
                                        <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v10.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 14.5V4a1 1 0 0 1-1-1zm2 3v10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V4zM3 3h10V1H3z" />
                                    </svg>
                                    <h5 class="card-title mt-3"></h5>
                                    <p class="card-text">Kategori</p>
                                </div>
                                <div class="card-footer bg-success border-success text-center">
                                    <a href="kategori-obat.php" class="medium text-black stretched-link">Cek Kategori
                                        >></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-3 d-flex align-items-stretch">
                            <div class="card border-info h-100 w-100">
                                <div class="card-body text-info text-center d-flex flex-column align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7" />
                                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
                                    </svg>
                                    <h5 class="card-title mt-3"></h5>
                                    <p class="card-text">Obat Tersedia</p>
                                </div>
                                <div class="card-footer bg-info border-info text-center">
                                    <a href="obat-tersedia.php" class="medium text-black stretched-link">Cek Penyimpanan
                                        >></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-3 d-flex align-items-stretch">
                            <div class="card border-danger h-100 w-100">
                                <div class="card-body text-danger text-center d-flex flex-column align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                        <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z" />
                                        <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                    </svg>
                                    <h5 class="card-title mt-3"></h5>
                                    <p class="card-text">Stok Obat Menipis</p>
                                </div>
                                <div class="card-footer bg-danger border-danger text-center">
                                    <a href="stok-obat-menipis.php" class="medium text-black stretched-link">Selesaikan
                                        >></a>
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