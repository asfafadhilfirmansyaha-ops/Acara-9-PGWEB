<?php
$conn = new mysqli("localhost", "root", "", "pgweb_acara8");
if ($conn->connect_error) die("Koneksi gagal.");
$conn->set_charset("utf8mb4");

$result = $conn->query("SELECT * FROM penduduk ORDER BY id");

function h($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, "UTF-8");
}

echo "<a href='input/index.html'>Input</a>";
echo "<table border='1'><tr>
      <th>Kecamatan</th><th>Longitude</th><th>Latitude</th>
      <th>Luas</th><th>Jumlah Penduduk</th>
      <th colspan='2'>Aksi</th></tr>";
git pull origin main --no-rebase --allow-unrelated-histories --no-edit
while ($row = $result->fetch_assoc()) {
    $id = (int) $row["id"];
    echo "<tr>
          <td>" . h($row["kecamatan"]) . "</td>
          <td>" . h($row["longitude"]) . "</td>
          <td>" . h($row["latitude"]) . "</td>
          <td>" . h($row["luas"]) . "</td>
          <td>" . h($row["jumlah_penduduk"]) . "</td>
          <td><a href='delete.php?id=$id'>hapus</a></td>
          <td><a href='edit/index.php?id=$id'>edit</a></td>
          </tr>";
}
echo "</table>";
$conn->close();