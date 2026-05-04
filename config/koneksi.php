<?php
// Mendefinisikan konstanta koneksi
define('DB_HOST', 'localhost');           // Server database
define('DB_USER', 'coffecooldev');        // Username (perbaiki ejaan)
define('DB_PASS', '1122334455667788');    // Password (tambah tanda kutip)
define('DB_NAME', 'db_absensi_siswa');    // Nama database (hilangkan spasi)

// Membuat koneksi (perbaiki: mysqli, bukan mysql)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set karakter
$conn->set_charset("utf8");

// echo "Koneksi berhasil!";
// ?>