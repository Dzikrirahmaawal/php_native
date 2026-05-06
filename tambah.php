<?php
require_once 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas = trim($_POST['kelas']);
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    
    $query = "INSERT INTO tb_absensi (nama_siswa, kelas, tanggal, status) 
              VALUES ('$nama_siswa', '$kelas', '$tanggal', '$status')";
    
    if ($conn->query($query)) {
        header("Location: index.php?status=success");
        exit();
    } else {
        $error = "Gagal menambahkan data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Absensi Siswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h2 {
            margin: 0;
            font-size: 28px;
        }
        
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }
        
        .error {
            background: #f44336;
            color: white;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-submit {
            flex: 1;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .btn-submit:hover {
            background: #45a049;
        }
        
        .btn-back {
            flex: 1;
            background: #6c757d;
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        
        .btn-back:hover {
            background: #5a6268;
        }
        
        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>📝 Tambah Data Absensi</h2>
        <p>Isi form di bawah untuk menambahkan data absensi siswa</p>
    </div>
    
    <div class="content">
        <?php if (isset($error)): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa *</label>
                <input type="text" id="nama_siswa" name="nama_siswa" required 
                       placeholder="Masukkan nama lengkap siswa">
            </div>
            
            <div class="form-group">
                <label for="kelas">Kelas *</label>
                <input type="text" id="kelas" name="kelas" required 
                       placeholder="Contoh: X RPL 1, XI TKJ 2, XII MM 3">
            </div>
            
            <div class="form-group">
                <label for="tanggal">Tanggal *</label>
                <input type="date" id="tanggal" name="tanggal" required 
                       value="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group">
                <label for="status">Status Kehadiran *</label>
                <select id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Hadir">✓ Hadir</option>
                    <option value="Izin">ℹ Izin</option>
                    <option value="Sakit">⚕ Sakit</option>
                    <option value="Alpa">✗ Alpa</option>
                </select>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn-submit">💾 Simpan Data</button>
                <a href="index.php" class="btn-back">↩ Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>