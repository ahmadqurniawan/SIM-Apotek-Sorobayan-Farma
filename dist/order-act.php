<?php
include "../config/koneksi.php";

if (isset($_POST['submit'])) {
    $id_order = $_POST['id_order'];
    $nama_obat = $_POST['nama_obat'];
    $total_harga = $_POST['total_harga'];
    $qty = $_POST['qty'];
    $tanggal = $_POST['tanggal'];
    $time = $_POST['time'];

    // Fetch the current stock of the specified medicine
    $obatQuery = "SELECT stok FROM obat WHERE nama_obat = '$nama_obat'";
    $obatResult = mysqli_query($koneksi, $obatQuery);
    $obat = mysqli_fetch_assoc($obatResult);
    
    if ($obat) {
        $currentStok = $obat['stok'];

        // Check if there is enough stock
        if ($currentStok >= $qty) {
            // Update the stock
            $newStok = $currentStok - $qty;
            $updateStokQuery = "UPDATE obat SET stok = $newStok WHERE nama_obat = '$nama_obat'";
            mysqli_query($koneksi, $updateStokQuery);

            // Insert or update the order
            if ($id_order) {
                $query = "UPDATE `order` SET nama_obat='$nama_obat', total_harga='$total_harga', qty='$qty', tanggal='$tanggal', time='$time' WHERE id_order='$id_order'";
            } else {
                $query = "INSERT INTO `order` (nama_obat, total_harga, qty, tanggal, time) VALUES ('$nama_obat', '$total_harga', '$qty', '$tanggal', '$time')";
            }
            mysqli_query($koneksi, $query);

            echo "Order processed and stock updated successfully.";
        } else {
            echo "Not enough stock available.";
        }
    } else {
        echo "Medicine not found.";
    }
}
?>
