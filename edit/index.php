<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Data Kecamatan</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(to right, #60a5fa, #3b82f6);
    padding: 40px;
    color: #fff;
}
h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 28px;
}
form {
    background: rgba(255,255,255,0.95);
    padding: 25px;
    border-radius: 15px;
    max-width: 500px;
    margin: auto;
    color: #000;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}
input[type=text], input[type=number] {
    width: 95%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
input[type=submit] {
    background: #2563eb;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    margin-top: 15px;
}
input[type=submit]:hover {
    background: #1d4ed8;
}
a {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
}
#informasi {
    text-align: center;
    color: red;
    margin-bottom: 10px;
}
</style>
</head>
<body>

<h2>Edit Data Kecamatan</h2>
<div id="informasi"></div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id = $_GET['id'];
$sql = "SELECT * FROM data_kecamatan WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<form action='edit.php' method='post' onsubmit='return validateForm()'>
            <input type='hidden' name='id' value='{$row['id']}'>
            
            <label>Kecamatan:</label>
            <input type='text' name='kecamatan' value='{$row['kecamatan']}' required>
            
            <label>Longitude:</label>
            <input type='text' name='longitude' value='{$row['longitude']}' required>
            
            <label>Latitude:</label>
            <input type='text' name='latitude' value='{$row['latitude']}' required>
            
            <label>Luas:</label>
            <input type='text' id='luas' name='luas' value='{$row['luas']}' required placeholder='contoh: 123.45 atau 123,45'>
            
            <label>Jumlah Penduduk:</label>
            <input type='number' id='jml' name='jumlah_penduduk' value='{$row['jumlah_penduduk']}' required>
            
            <input type='submit' value='Simpan'>
          </form>";
} else {
    echo "<p>Data tidak ditemukan!</p>";
}
$conn->close();
?>

<a href='../index.php'>← Kembali ke Halaman Utama</a>

<script>
function validateForm() {
    let luas = document.getElementById("luas").value.replace(',', '.');
    let jumlah = document.getElementById("jml").value;
    let msg = "";

    if (isNaN(luas) || parseFloat(luas) <= 0) msg = "⚠️ Luas harus angka lebih dari 0!";
    else if (isNaN(jumlah) || parseInt(jumlah) <= 0) msg = "⚠️ Jumlah penduduk harus angka lebih dari 0!";

    if (msg) {
        document.getElementById("informasi").innerText = msg;
        return false;
    }
    return true;
}
</script>

</body>
</html>
