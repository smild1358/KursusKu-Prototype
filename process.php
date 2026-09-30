<?php
require_once __DIR__ . '/data.php';

$name       = trim($_POST['name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$courseCode = $_POST['course_code'] ?? '';
$profession = $_POST['profession'] ?? 'umum';
$interest   = $_POST['interest'] ?? '';
$selectedFac = $_POST['facilities'] ?? [];

// Validasi Sederhana
if (empty($name) || empty($email) || !isset($coursesData[$courseCode])) {
    die("Data pendaftaran tidak valid. <a href='register.php'>Kembali</a>");
}

$selectedCourse = $coursesData[$courseCode];
$baseFee        = $selectedCourse['fee'];

// Branching Diskon
$discountRate = 0;
if ($profession === 'mahasiswa') {
    $discountRate = 0.20; // 20%
} elseif ($profession === 'guru') {
    $discountRate = 0.15; // 15%
} else {
    $discountRate = 0.00; // 0%
}

$discountAmount = $baseFee * $discountRate;
$feeAfterDiscount = $baseFee - $discountAmount;

// Hitung Tambahan Fasilitas dengan Loop
$facilityTotal = 0;
$facilityNames = [];
foreach ($selectedFac as $facKey) {
    if (isset($facilitiesData[$facKey])) {
        $facilityTotal += $facilitiesData[$facKey]['fee'];
        $facilityNames[] = $facilitiesData[$facKey]['name'];
    }
}

$grandTotal = $feeAfterDiscount + $facilityTotal;
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Ringkasan Pendaftaran - Pertemuan 6</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; padding: 40px 20px; }
        .card { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; }
        h2 { color: #0f766e; }
        .summary-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .summary-table td, .summary-table th { padding: 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .total-row { font-weight: 800; font-size: 16px; color: #0f766e; background: #f0fdf4; }
    </style>
</head>
<body>

<div class="card">
    <h2>Ringkasan Transaksi & Biaya</h2>
    
    <table class="summary-table">
        <tr><th>Nama Pendaftar</th><td><?= htmlspecialchars($name) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($email) ?></td></tr>
        <tr><th>Kursus</th><td><?= htmlspecialchars($selectedCourse['name']) ?></td></tr>
        <tr><th>Biaya Dasar</th><td>Rp <?= number_format($baseFee, 0, ',', '.') ?></td></tr>
        <tr>
            <th>Status (Diskon)</th>
            <td><?= ucfirst($profession) ?> (<?= $discountRate * 100 ?>%)</td>
        </tr>
        <tr><th>Potongan Diskon</th><td>- Rp <?= number_format($discountAmount, 0, ',', '.') ?></td></tr>
        <tr>
            <th>Fasilitas Tambahan</th>
            <td>
                <?= !empty($facilityNames) ? implode(', ', $facilityNames) : 'Tidak Ada' ?>
                (+Rp <?= number_format($facilityTotal, 0, ',', '.') ?>)
            </td>
        </tr>
        <tr class="total-row">
            <th>Total Pembayaran</th>
            <td>Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
        </tr>
    </table>

    <br>
    <a href="register.php" style="color:#0f766e; text-decoration:none; font-weight:700;">&larr; Pendaftaran Baru</a> | 
    <a href="history.php" style="color:#0f766e; text-decoration:none; font-weight:700;">Lihat Riwayat &rarr;</a>
</div>

</body>
</html>