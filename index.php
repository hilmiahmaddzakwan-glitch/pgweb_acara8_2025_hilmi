<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kecamatan & Peta Sebaran</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 20px;
            background: #f0f4f8;
        }
        h1 {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 10px;
        }
        h2 {
            margin-top: 30px;
            color: #334155;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 10px 0;
            background: #2563eb;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn:hover {
            background: #1d4ed8;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #cbd5e1;
            text-align: center;
        }
        table th {
            background: #2563eb;
            color: white;
        }
        table tr:nth-child(even) {
            background: #f1f5f9;
        }
        #map-container {
            margin-top: 30px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        #map {
            height: 450px;
            border-radius: 10px;
            border: 2px solid white;
        }
        .success {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h1>Data Kecamatan & Peta Sebaran</h1>

<?php
$conn = new mysqli("localhost", "root", "", "pgweb_acara8");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Pesan sukses
if (isset($_GET['pesan'])) {
    $pesan = $_GET['pesan'];
    if ($pesan == 'berhasil') echo "<div class='success'>✅ Data berhasil diedit!</div>";
    if ($pesan == 'hapus') echo "<div class='success'>✅ Data berhasil dihapus!</div>";
    if ($pesan == 'tambah') echo "<div class='success'>✅ Data berhasil ditambahkan!</div>";
}
?>

<!-- Tombol Navigasi -->
<a href="input/index.html" class="btn">Tambah Data</a>

<!-- Tabel Data -->
<h2>Daftar Data Kecamatan</h2>
<table>
    <tr>
        <th>No</th>
        <th>Kecamatan</th>
        <th>Longitude</th>
        <th>Latitude</th>
        <th>Luas</th>
        <th>Jumlah Penduduk</th>
        <th>Aksi</th>
    </tr>

<?php
$sql = "SELECT * FROM data_kecamatan";
$result = $conn->query($sql);
$no = 1;
$koordinat = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['kecamatan']}</td>
                <td>{$row['longitude']}</td>
                <td>{$row['latitude']}</td>
                <td>{$row['luas']}</td>
                <td>{$row['jumlah_penduduk']}</td>
                <td>
                    <a href='edit/index.php?id={$row['id']}' class='btn' style='background:#facc15;'>Edit</a>
                    <a href='delete.php?id={$row['id']}' class='btn' style='background:#ef4444;' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                </td>
              </tr>";
        $koordinat[] = [
            'nama' => $row['kecamatan'],
            'lat' => $row['latitude'],
            'lng' => $row['longitude']
        ];
        $no++;
    }
} else {
    echo "<tr><td colspan='7'>Tidak ada data.</td></tr>";
}
$conn->close();
?>
</table>

<!-- Peta -->
<h2>Peta Sebaran Kecamatan</h2>
<div id="map-container">
    <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([-7.8, 110.4], 10);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
}).addTo(map);

var data = <?php echo json_encode($koordinat); ?>;
data.forEach(function(item){
    if(item.lat && item.lng){
        L.marker([item.lat, item.lng])
         .addTo(map)
         .bindPopup("<b>"+item.nama+"</b><br>Koordinat: "+item.lat+", "+item.lng);
    }
});
</script>

</body>
</html>
