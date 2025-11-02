<?php
$kecamatan = $_POST['kecamatan'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$luas = $_POST['luas'];
$jumlah_penduduk = $_POST['jumlah_penduduk'];

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

// Simpan data ke tabel
$sql = "INSERT INTO data_kecamatan (kecamatan, longitude, latitude, luas, jumlah_penduduk)
        VALUES ('$kecamatan', '$longitude', '$latitude', '$luas', '$jumlah_penduduk')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../index.php?pesan=sukses");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
