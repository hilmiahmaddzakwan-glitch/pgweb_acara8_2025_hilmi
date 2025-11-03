<?php
$id = $_GET['id'];
$conn = new mysqli("localhost", "root", "", "pgweb_acara8");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$sql = "DELETE FROM data_kecamatan WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php?pesan=hapus");
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
