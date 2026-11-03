<?php
$id = filter_var($_GET["id"] ?? "", FILTER_VALIDATE_INT);
if ($id === false || $id < 1) exit("ID tidak valid.");

$conn = new mysqli("localhost", "root", "", "pgweb_acara8");
if ($conn->connect_error) die("Koneksi gagal.");
$conn->set_charset("utf8mb4");

$stmt = $conn->prepare("DELETE FROM penduduk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$conn->close();
header("Location: index.php");
exit;