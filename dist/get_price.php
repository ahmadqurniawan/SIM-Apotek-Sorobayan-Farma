<?php
include "config/koneksi.php";

if (isset($_GET['nama_obat'])) {
    $nama_obat = $_GET['nama_obat'];
    $query = "SELECT harga FROM obat WHERE nama_obat = '$nama_obat'";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(['harga' => $row['harga']]);
    } else {
        echo json_encode(['error' => 'Failed to fetch price']);
    }
} else {
    echo json_encode(['error' => 'No medicine name provided']);
}
?>
