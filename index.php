<?php
require_once 'config/koneksi.php';
$query = "SELECT * FROM tb_absensi ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi Siswa</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .btn-tambah {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-tambah:hover {
            background-color: #45a049;
        }
        .btn-edit {
            background-color: #2196F3;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            margin-right: 5px;
        }
        .btn-edit:hover {
            background-color: #0b7dda;
        }
        .btn-hapus {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn-hapus:hover {
            background-color: #da190b;
        }
        .hadir {
            color: green;
            font-weight: bold;
        }
        .izin {
            color: orange;
            font-weight: bold;
        }
        .sakit {
            color: blue;
            font-weight: bold;
        }
        .alpa {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Data Absensi Siswa</h2>
    
    <a href="tambah_absensi.php" class="btn-tambah">+ Tambah Absensi</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                        <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td>
                            <?php 
                            $status = $row['status'];
                            switch($status) {
                                case 'Hadir':
                                    echo '<span class="hadir">✓ Hadir</span>';
                                    break;
                                case 'Izin':
                                    echo '<span class="izin">ℹ Izin</span>';
                                    break;
                                case 'Sakit':
                                    echo '<span class="sakit">⚕ Sakit</span>';
                                    break;
                                case 'Alpa':
                                    echo '<span class="alpa">✗ Alpa</span>';
                                    break;
                                default:
                                    echo $status;
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit_absensi.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            <a href="hapus_absensi.php?id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Belum ada data absensi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php 
if ($result) {
    $conn->close();
}
?>