<?php
require_once 'config/koneksi.php';

// Ambil ID dari URL dan validasi
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;

// Cek apakah ID valid
if (!$id || $id <= 0) {
    // Jika ID tidak valid, redirect ke index
    header("Location: index.php?status=error");
    exit();
}

// Cek apakah data dengan ID tersebut ada
$check_stmt = $conn->prepare("SELECT id FROM tb_absensi WHERE id = ?");
$check_stmt->bind_param("i", $id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows == 0) {
    // Jika data tidak ditemukan
    $check_stmt->close();
    header("Location: index.php?status=notfound");
    exit();
}
$check_stmt->close();

// Hapus data menggunakan prepared statement
$stmt = $conn->prepare("DELETE FROM tb_absensi WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Jika berhasil dihapus
    header("Location: index.php?status=deleted");
} else {
    // Jika gagal dihapus
    header("Location: index.php?status=error");
}

$stmt->close();
$conn->close();
exit();
?>