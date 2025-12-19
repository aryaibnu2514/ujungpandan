<?php 
require 'config.php'; 
if (!isAdmin()) header('Location: index.html');

// CREATE
if ($_POST && isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO lahan (nama_lahan, jenis, lat, lng, luas_ha, pemilik, deskripsi, toko_terdekat) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nama_lahan'], 
        $_POST['jenis'], 
        $_POST['lat'], 
        $_POST['lng'], 
        $_POST['luas_ha'], 
        $_POST['pemilik'], 
        $_POST['deskripsi'], 
        $_POST['toko_terdekat']
    ]);
    $success = "✅ Lahan baru berhasil ditambah!";
}

// UPDATE
if ($_POST && isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE lahan SET nama_lahan=?, jenis=?, lat=?, lng=?, luas_ha=?, pemilik=?, deskripsi=?, toko_terdekat=? WHERE id=?");
    $stmt->execute([
        $_POST['nama_lahan'], $_POST['jenis'], $_POST['lat'], $_POST['lng'], 
        $_POST['luas_ha'], $_POST['pemilik'], $_POST['deskripsi'], $_POST['toko_terdekat'],
        $_POST['id']
    ]);
    $success = "✅ Data lahan berhasil diupdate!";
}

// DELETE
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM lahan WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    $success = "✅ Data lahan berhasil dihapus!";
}

// EDIT MODE - Ambil data untuk diedit
$edit_id = isset($_GET['edit']) ? $_GET['edit'] : 0;
$edit_data = [];
if ($edit_id) {
    $stmt = $pdo->prepare("SELECT * FROM lahan WHERE id=?");
    $stmt->execute([$edit_id]);
    $edit_data = $stmt->fetch();
}

$stmt = $pdo->query("SELECT * FROM lahan ORDER BY created_at DESC");
$lahan = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Panel SIG Ujungpandan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f9fa; }
        .card { box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none; }
        .badge-sawah { background: #28a745 !important; } .badge-kebun { background: #ffc107 !important; } .badge-ladang { background: #dc3545 !important; }
        .btn-action { margin: 0 2px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>🗺️ Admin Panel SIG Lahan Pertanian</h2>
                    <a href="index.html" class="btn btn-primary btn-lg">← Lihat Peta</a>
                </div>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $success ?> <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- FORM CRUD (Tambah/Edit) -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5><?= $edit_id ? '✏️ Edit Lahan' : '➕ Tambah Lahan Baru' ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lahan</label>
                                    <input type="text" class="form-control" name="nama_lahan" 
                                           value="<?= $edit_data['nama_lahan'] ?? '' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Lahan</label>
                                    <select class="form-select" name="jenis" required>
                                        <option value="sawah" <?= ($edit_data['jenis']??'sawah')=='sawah'?'selected':'' ?>>🌾 Sawah</option>
                                        <option value="kebun" <?= ($edit_data['jenis']??'')=='kebun'?'selected':'' ?>>🌱 Kebun</option>
                                        <option value="ladang" <?= ($edit_data['jenis']??'')=='ladang'?'selected':'' ?>>🌾 Ladang</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Latitude (dari Google Maps)</label>
                                    <input type="number" step="any" class="form-control" name="lat" 
                                           value="<?= $edit_data['lat'] ?? '-6.552345' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Longitude (dari Google Maps)</label>
                                    <input type="number" step="any" class="form-control" name="lng" 
                                           value="<?= $edit_data['lng'] ?? '110.662123' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Luas (Hektar)</label>
                                    <input type="number" step="0.01" class="form-control" name="luas_ha" 
                                           value="<?= $edit_data['luas_ha'] ?? '' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pemilik</label>
                                    <input type="text" class="form-control" name="pemilik" 
                                           value="<?= $edit_data['pemilik'] ?? '' ?>" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Toko Terdekat</label>
                                    <input type="text" class="form-control" name="toko_terdekat" 
                                           value="<?= $edit_data['toko_terdekat'] ?? '' ?>" placeholder="Toko Pupuk Jepara">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" rows="3"><?= $edit_data['deskripsi'] ?? '' ?></textarea>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="<?= $edit_id ? 'update' : 'add' ?>" 
                                        class="btn btn-<?= $edit_id ? 'warning' : 'success' ?> btn-lg">
                                    <?= $edit_id ? '💾 Update Lahan' : '➕ Tambah Lahan' ?>
                                </button>
                                <?php if ($edit_id): ?>
                                    <a href="admin.php" class="btn btn-secondary btn-lg">❌ Batal Edit</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TABEL DATA LAHAN (READ + DELETE) -->
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between">
                        <h5>📋 Daftar Lahan (<?= count($lahan) ?>)</h5>
                        <a href="admin.php" class="btn btn-light btn-sm">🔄 Refresh</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lahan</th>
                                        <th>Jenis</th>
                                        <th>Koordinat</th>
                                        <th>Luas</th>
                                        <th>Pemilik</th>
                                        <th>Toko</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lahan as $index => $item): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><strong><?= htmlspecialchars($item['nama_lahan']) ?></strong></td>
                                        <td>
                                            <span class="badge badge-<?= $item['jenis'] ?> fs-6">
                                                <?= ucfirst($item['jenis']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= number_format($item['lat'], 6) ?><br>
                                                <?= number_format($item['lng'], 6) ?>
                                            </small>
                                        </td>
                                        <td><strong><?= $item['luas_ha'] ?> Ha</strong></td>
                                        <td><?= htmlspecialchars($item['pemilik']) ?></td>
                                        <td><?= htmlspecialchars($item['toko_terdekat']) ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="?edit=<?= $item['id'] ?>" class="btn btn-warning btn-action" title="Edit">
                                                    ✏️
                                                </a>
                                                <a href="?delete=<?= $item['id'] ?>" class="btn btn-danger btn-action" 
                                                   onclick="return confirm('Hapus lahan <?= $item['nama_lahan'] ?>?')" title="Hapus">
                                                    🗑️
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
