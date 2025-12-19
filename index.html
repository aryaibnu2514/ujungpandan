<?php 
require 'config.php'; 
if (!isLoggedIn()) header('Location: login.php');

$stmt = $pdo->query("SELECT * FROM lahan ORDER BY created_at DESC");
$lahan = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>SIG Lahan Pertanian - Ujungpandan, Jepara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; }
        #map { height: 70vh; width: 100%; }
        .sidebar { height: 70vh; overflow-y: auto; background: white; padding: 20px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .card-lahan { margin-bottom: 15px; padding: 15px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.2s; }
        .card-lahan:hover { transform: translateY(-2px); }
        .jenis-sawah { border-left: 5px solid #28a745; } .jenis-kebun { border-left: 5px solid #ffc107; } .jenis-ladang { border-left: 5px solid #dc3545; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold">SIG Ujungpandan</a>
            <div class="navbar-nav ms-auto">
                <?php if (isAdmin()): ?><a href="admin.php" class="nav-link">Admin Panel</a><?php endif; ?>
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <h5>Daftar Lahan Pertanian</h5>
                <?php foreach ($lahan as $item): ?>
                    <div class="card-lahan jenis-<?= $item['jenis'] ?>" onclick="flyToMarker(<?= $item['lat'] ?>, <?= $item['lng'] ?>)">
                        <h6><?= htmlspecialchars($item['nama_lahan']) ?></h6>
                        <small><strong>Jenis:</strong> <?= ucfirst($item['jenis']) ?> | <strong>Luas:</strong> <?= $item['luas_ha'] ?> Ha</small><br>
                        <small><strong>Pemilik:</strong> <?= htmlspecialchars($item['pemilik']) ?></small><br>
                        <small><strong>Toko Terdekat:</strong> <?= htmlspecialchars($item['toko_terdekat']) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-9">
                <div id="map"></div>
            </div>
        </div>
    </div>
    <script>
        var map = L.map('map').setView([-6.55, 110.65], 14); // Koordinat Desa Ujungpandan, Jepara
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        <?php foreach ($lahan as $item): ?>
            var marker<?= $item['id'] ?> = L.marker([<?= $item['lat'] ?>, <?= $item['lng'] ?>]).addTo(map)
                .bindPopup(`
                    <b><?= htmlspecialchars($item['nama_lahan']) ?></b><br>
                    Jenis: <?= ucfirst($item['jenis']) ?><br>
                    Luas: <?= $item['luas_ha'] ?> Ha<br>
                    Pemilik: <?= htmlspecialchars($item['pemilik']) ?><br>
                    Toko: <?= htmlspecialchars($item['toko_terdekat']) ?><br>
                    <i><?= htmlspecialchars($item['deskripsi']) ?></i>
                `);
        <?php endforeach; ?>

        function flyToMarker(lat, lng) {
            map.flyTo([lat, lng], 16);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
