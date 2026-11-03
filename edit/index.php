<?php
$id = filter_var($_GET["id"] ?? "", FILTER_VALIDATE_INT);
if ($id === false || $id < 1) exit("ID tidak valid.");

$conn = new mysqli("localhost", "root", "", "pgweb_acara8");
if ($conn->connect_error) die("Koneksi gagal.");
$conn->set_charset("utf8mb4");

$row = $conn->query("SELECT * FROM penduduk WHERE id = $id")->fetch_assoc();
if (!$row) exit("Data tidak ditemukan.");

function h($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, "UTF-8");
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Form Edit</title></head>
<body>
<h2>Form Edit</h2>

<form action="edit.php" method="post" onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?= $id ?>">
    Kecamatan:<br>
    <input name="kecamatan" value="<?= h($row['kecamatan']) ?>" required><br>
    Longitude:<br>
    <input type="number" name="longitude" value="<?= h($row['longitude']) ?>" min="-180" max="180" step="any" required><br>
    Latitude:<br>
    <input type="number" name="latitude" value="<?= h($row['latitude']) ?>" min="-90" max="90" step="any" required><br>
    Luas:<br>
    <input type="number" name="luas" id="luas" value="<?= h($row['luas']) ?>" min="1" step="any" required><br>
    Jumlah Penduduk:<br>
    <input type="number" name="jumlah_penduduk" value="<?= h($row['jumlah_penduduk']) ?>" min="0" step="1" required><br><br>
    <input type="submit" value="Submit">
</form>

<p id="informasi"></p>
<a href="../index.php">Kembali</a>

<script>
function validateForm() {
    let luas = Number(document.getElementById("luas").value);
    if (!Number.isFinite(luas) || luas < 1) {
        document.getElementById("informasi").textContent =
            "Luas harus berupa angka minimal 1.";
        return false;
    }
    return true;
}
</script>
</body>
</html>