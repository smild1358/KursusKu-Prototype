<?php
/**
 * test-functions.php - Testing Otomatis 6 Test Case (Week 04)
 */
require_once __DIR__ . '/helpers.php';

$tests = [
    ['rupiah(250000)', rupiah(250000), 'Rp 250.000'],
    ['statusKursus(25, 25)', statusKursus(25, 25), 'Penuh'],
    ['statusKursus(30, 29)', statusKursus(30, 29), 'Tersedia'],
    ['sisaKursi(20, 0)', sisaKursi(20, 0), 20],
    ['sisaKursi(25, 25)', sisaKursi(25, 25), 0],
    ['formatTanggal("2026-09-15")', formatTanggal('2026-09-15'), '15-09-2026']
];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unit Testing Functions - KursusKu Week 04</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; color: #0f172a; padding: 40px 20px; }
        .card { max-width: 750px; margin: auto; background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        h1 { color: #0f766e; font-size: 22px; margin-bottom: 8px; }
        p { color: #64748b; font-size: 14px; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #f1f5f9; color: #334155; }
        .badge { padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; display: inline-block; }
        .badge-pass { background: #dcfce7; color: #15803d; }
        .badge-fail { background: #fee2e2; color: #b91c1c; }
    </style>
</head>
<body>

<div class="card">
    <h1><i class="fa-solid fa-vial"></i> Unit Testing Functions (Week 04)</h1>
    <p>Pengujian otomatis untuk 4 fungsi pada <code>helpers.php</code>[cite: 4].</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pengujian</th>
                <th>Actual</th>
                <th>Expected</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tests as $i => [$name, $actual, $expected]): ?>
                <?php $passed = ($actual === $expected); ?>
                <tr>
                    <td><strong><?= $i + 1 ?></strong></td>
                    <td><code><?= htmlspecialchars($name) ?></code></td>
                    <td><?= htmlspecialchars((string)$actual) ?></td>
                    <td><?= htmlspecialchars((string)$expected) ?></td>
                    <td>
                        <span class="badge <?= $passed ? 'badge-pass' : 'badge-fail' ?>">
                            <?= $passed ? 'PASS' : 'FAIL' ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="index.php" style="color:#0f766e; font-weight:600; text-decoration:none;">&larr; Kembali ke Katalog Utama</a>
</div>

</body>
</html>