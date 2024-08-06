    <?php
    session_start();

    // Periksa apakah user sudah login
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $id_obat = $_POST['id_obat'] ?? null;
        $jumlah_stok = $_POST['jumlah_stok'] ?? null;
        $nama_obat = $_POST['nama_obat'] ?? null;
        $stok = $_POST['stok'] ?? null;
        $qty = $_POST['jumlah_stok'] ?? null;
        $tanggal = $_POST['tanggal'] ?? null;

        // Debug: Cek apakah data sudah diterima dengan benar
        if (empty($id_obat) || empty($jumlah_stok)) {
            die('Error: ID obat atau jumlah stok tidak ada. id_obat: ' . $id_obat . ', jumlah_stok: ' . $jumlah_stok);
        }

        // Lakukan koneksi ke database
        include "config/koneksi.php";

        // Debug: Cek apakah koneksi berhasil
        if (!$koneksi) {
            die('Error: Koneksi ke database gagal. ' . mysqli_connect_error());
        }

        // Query untuk menambahkan data ke tabel pemasukan_obat
        $query1 = "INSERT INTO pemasukan_obat (id_obat, nama_obat, tanggal, qty) 
        VALUES ('$id_obat', '$nama_obat', '$tanggal', '$qty')";

        // Eksekusi query1
        if (mysqli_query($koneksi, $query1)) {
            // Query untuk menambahkan stok
            $query = "UPDATE obat SET stok = stok + ? WHERE id_obat = ?";

            // Prepare statement
            if ($stmt = mysqli_prepare($koneksi, $query)) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "ii", $jumlah_stok, $id_obat);

                // Execute statement
                if (mysqli_stmt_execute($stmt)) {
                    // Tutup statement
                    mysqli_stmt_close($stmt);

                    // Tutup koneksi
                    mysqli_close($koneksi);

                    // Redirect kembali ke halaman sebelumnya setelah berhasil dengan alert
                    echo '<script>alert("Stok berhasil ditambahkan"); window.location.href = "penyimpanan.php";</script>';
                    exit();
                } else {
                    echo '<script>alert("Gagal menambahkan stok"); window.location.href = "penyimpanan.php";</script>';
                }

                // Close statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($koneksi);
            }
        } else {
            echo "Error executing query1: " . mysqli_error($koneksi);
        }

        // Close connection
        mysqli_close($koneksi);
    }
