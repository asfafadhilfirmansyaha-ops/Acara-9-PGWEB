<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html"); exit;
}

$kecamatan = trim($_POST["kecamatan"] ?? "");
$longitude = filter_var($_POST["longitude"] ?? "", FILTER_VALIDATE_FLOAT);
$latitude = filter_var($_POST["latitude"] ?? "", FILTER_VALIDATE_FLOAT);
$luas = filter_var($_POST["luas"] ?? "", FILTER_VALIDATE_FLOAT);
$jumlah = filter_var($_POST["jumlah_penduduk"] ?? "", FILTER_VALIDATE_INT);

if ($kecamatan === "" || $longitude === false || $latitude === false ||
    $luas === false || $luas < 1 || $jumlah === false || $jumlah < 0 ||
    abs($longitude) > 180 || abs($latitude) > 90) {
    exit("Periksa kembali isian data.");
}

$conn = new mysqli("localhost", "root", "", "pgweb_acara8");
if ($conn->connect_error) die("Koneksi gagal.");
$conn->set_charset("utf8mb4");

$stmt = $conn->prepare("INSERT INTO penduduk
    (kecamatan, longitude, latitude, luas, jumlah_penduduk)
    VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sdddi", $kecamatan, $longitude, $latitude, $luas, $jumlah);
$stmt->execute();

$conn->close();
header("Location: ../index.php");
exit;