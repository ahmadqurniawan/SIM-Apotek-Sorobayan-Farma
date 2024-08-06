<?php
include "config/koneksi.php";

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

$query = mysqli_query($koneksi, "
    SELECT MONTH(tanggal) as month, YEAR(tanggal) as year, SUM(qty) as total_qty 
    FROM `order` 
    WHERE tanggal BETWEEN '$startDate' AND '$endDate' 
    GROUP BY month, year
    ORDER BY year, month
");

$labels = [];
$sales = [];
while ($row = mysqli_fetch_array($query)) {
    $labels[] = date("F Y", mktime(0, 0, 0, $row['month'], 1, $row['year']));
    $sales[] = $row['total_qty'];
}

echo json_encode(['labels' => $labels, 'sales' => $sales]);
?>
