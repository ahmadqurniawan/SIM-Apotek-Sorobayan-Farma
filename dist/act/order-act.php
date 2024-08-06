<?php

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

include "../config/koneksi.php";

$tanggal = $_POST['tanggal'] ?? null;
$time = $_POST['time'] ?? null;
$nama_obat = $_POST['nama_obat'] ?? null;
$qty = $_POST['qty'] ?? null;
$total_harga = $_POST['total_harga'] ?? null;

if (@$_GET['id_order']) {
    $id = $_GET['id_order'];

    // Select the data from the order table
    $result = mysqli_query($koneksi, "SELECT * FROM `order` WHERE id_order = '$id'") or die(mysqli_error($koneksi));
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id_order = $row['id_order'];
        $tanggal = $row['tanggal'];
        $time = $row['time'];
        $nama_obat = $row['nama_obat'];
        $qty = $row['qty'];
        $total_harga = $row['total_harga'];

        // Insert the data into order_sampah table
        $query = "INSERT INTO order_sampah (id_order, tanggal, `time`, nama_obat, qty, total_harga) 
                  VALUES ('$id_order', '$tanggal', '$time', '$nama_obat', '$qty', '$total_harga')";
        mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

        // Delete the record from the order table
        mysqli_query($koneksi, "DELETE FROM `order` WHERE id_order = '$id'") or die(mysqli_error($koneksi));

        header('Location: ../laporan.php');
    }
} elseif (@$_POST['id_order']) {
    $id = $_POST['id_order'];
    $query = "UPDATE `order` SET
        tanggal = '$tanggal',
        `time` = '$time',
        nama_obat = '$nama_obat',
        qty = '$qty',
        total_harga = '$total_harga'
        WHERE id_order = '$id'
    ";
    mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
    header('Location: ../laporan.php');
} else {
    $query = "INSERT INTO `order` (tanggal, `time`, nama_obat, qty, total_harga) 
                VALUES ('$tanggal', '$time', '$nama_obat', '$qty', '$total_harga')";
    mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
    header('Location: ../laporan.php');
}

?>