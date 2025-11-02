<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil parameter jika ada pesan sukses
$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';

$sql = "SELECT * FROM data_kecamatan";
$result = $conn->query($sql);

echo "<a href='input/index.html'>Input</a><br><br>";

if ($result->num_rows > 0) {
    echo "<table border='1px'>
    <tr>
        <th>Kecamatan</th>
        <th>Longitude</th>
        <th>Latitude</th>
        <th>Luas</th>
        <th>Jumlah Penduduk</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . $row["kecamatan"] . "</td>
            <td>" . $row["longitude"] . "</td>
            <td>" . $row["latitude"] . "</td>
            <td align='right'>" . $row["luas"] . "</td>
            <td align='right'>" . $row["jumlah_penduduk"] . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "Belum ada data.";
}

// Tampilkan pesan sukses jika ada
if ($pesan == "sukses") {
    echo "<p>Data berhasil disimpan!</p>";
}

$conn->close();
?>
