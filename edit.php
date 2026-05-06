<?php
require_once 'config/koneksi.php';

// Ambil ID dari URL dan validasi
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;

// Jika ID tidak valid, redirect ke index
if (!$id || $id <= 0) {
    header("Location: index.php");
    exit();
}

// Ambil data lama dari database
$stmt = $conn->prepare("SELECT * FROM tb_absensi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$data = $result->fetch_assoc();
$stmt->close();

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas = trim($_POST['kelas']);
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    
    // Validasi data tidak kosong
    if (empty($nama_siswa) || empty($kelas) || empty($tanggal) || empty($status)) {
        $error = "Semua field harus diisi!";
    } else {
        // Update data menggunakan prepared statement
        $stmt = $conn->prepare("UPDATE tb_absensi 
                                SET nama_siswa = ?, 
                                    kelas = ?, 
                                    tanggal = ?, 
                                    status = ? 
                                WHERE id = ?");
        $stmt->bind_param("ssssi", $nama_siswa, $kelas, $tanggal, $status, $id);
        
        if ($stmt->execute()) {
            header("Location: index.php?status=updated");
            exit();
        } else {
            $error = "Gagal mengupdate data: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Absensi Siswa</title>
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
            background: linear-gradient(135deg, #2196F3 0%, #0b7dda 100%);
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
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
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
            background: #2196F3;
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
            background: #0b7dda;
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
        
        .info-card {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .info-card strong {
            color: #1976d2;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>✏️ Edit Data Absensi</h2>
        <p>Update data absensi siswa</p>
    </div>
    
    <div class="content">
        <?php if (isset($error)): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="info-card">
            <strong>ℹ️ ID Data:</strong> <?php echo $data['id']; ?> | 
            <strong>Tanggal Input:</strong> <?php echo date('d-m-Y', strtotime($data['tanggal'])); ?>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa *</label>
                <input type="text" id="nama_siswa" name="nama_siswa" required 
                       value="<?php echo htmlspecialchars($data['nama_siswa']); ?>">
            </div>
            
            <div class="form-group">
                <label for="kelas">Kelas *</label>
                <input type="text" id="kelas" name="kelas" required 
                       value="<?php echo htmlspecialchars($data['kelas']); ?>">
            </div>
            
            <div class="form-group">
                <label for="tanggal">Tanggal *</label>
                <input type="date" id="tanggal" name="tanggal" required 
                       value="<?php echo $data['tanggal']; ?>">
            </div>
            
            <div class="form-group">
                <label for="status">Status Kehadiran *</label>
                <select id="status" name="status" required>
                    <option value="Hadir" <?php echo $data['status'] == 'Hadir' ? 'selected' : ''; ?>>✓ Hadir</option>
                    <option value="Izin" <?php echo $data['status'] == 'Izin' ? 'selected' : ''; ?>>ℹ Izin</option>
                    <option value="Sakit" <?php echo $data['status'] == 'Sakit' ? 'selected' : ''; ?>>⚕ Sakit</option>
                    <option value="Alpa" <?php echo $data['status'] == 'Alpa' ? 'selected' : ''; ?>>✗ Alpa</option>
                </select>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn-submit">💾 Update Data</button>
                <a href="index.php" class="btn-back">↩ Kembali</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>