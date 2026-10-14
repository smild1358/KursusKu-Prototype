<?php
require_once __DIR__ . '/helpers.php';

// Definisi 5 Test Case Resmi Kalkulator Biaya (P3)
$testCases = [
    [
        'id'               => 1,
        'title'            => 'Skenario Normal 1 Peserta',
        'fee'              => 250000,
        'participant_count' => 1,
        'discount_percent' => 0,
        'admin_fee'        => 25000,
        'expected'         => 275000
    ],
    [
        'id'               => 2,
        'title'            => 'Skenario Diskon 10%',
        'fee'              => 250000,
        'participant_count' => 1,
        'discount_percent' => 10,
        'admin_fee'        => 25000,
        'expected'         => 250000
    ],
    [
        'id'               => 3,
        'title'            => 'Skenario Multi Peserta (2 Orang, 25%)',
        'fee'              => 250000,
        'participant_count' => 2,
        'discount_percent' => 25,
        'admin_fee'        => 25000,
        'expected'         => 400000
    ],
    [
        'id'               => 4,
        'title'            => 'Skenario Biaya Gratis / Nol',
        'fee'              => 0,
        'participant_count' => 1,
        'discount_percent' => 10,
        'admin_fee'        => 0,
        'expected'         => 0
    ],
    [
        'id'               => 5,
        'title'            => 'Skenario Kursus Eksekutif (3 Orang, 10%)',
        'fee'              => 2500000,
        'participant_count' => 3,
        'discount_percent' => 10,
        'admin_fee'        => 50000,
        'expected'         => 6800000
    ],
];

// Menghitung Eksekusi Test Case
$totalTests = count($testCases);
$passCount  = 0;
$failCount  = 0;

$testResults = [];

foreach ($testCases as $test) {
    $subtotal       = $test['fee'] * $test['participant_count'];
    $discountAmount = intdiv($subtotal * $test['discount_percent'], 100);
    
    // Khusus fee 0, total biaya adalah 0
    if ($test['fee'] === 0) {
        $actual = 0;
    } else {
        $actual = $subtotal - $discountAmount + $test['admin_fee'];
    }

    $isPassed = ($actual === $test['expected']);
    
    if ($isPassed) {
        $passCount++;
    } else {
        $failCount++;
    }

    $testResults[] = array_merge($test, [
        'subtotal' => $subtotal,
        'discount_amount' => $discountAmount,
        'actual'   => $actual,
        'passed'   => $isPassed
    ]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Fee Tests — KursusKu</title>
    
    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #0d625b;
            --primary-light: #ccfbf1;
            --bg-body: #f0fdf4;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #cbd5e1;
            --pass-color: #10b981;
            --pass-bg: #dcfce7;
            --fail-color: #ef4444;
            --fail-bg: #fee2e2;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
            color: var(--text-dark);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Navigation Header */
        .header-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px 30px;
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.08);
            border: 1px solid rgba(15, 118, 110, 0.1);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title i {
            font-size: 1.8rem;
            color: var(--primary);
            background: var(--primary-light);
            padding: 12px;
            border-radius: 12px;
        }

        .header-title h1 {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .btn-back {
            text-decoration: none;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--primary-light);
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: var(--primary);
            color: white;
        }

        /* Summary Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            text-align: center;
        }

        .stat-card .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
        }

        .stat-card .value {
            font-size: 1.8rem;
            font-weight: 800;
            margin-top: 4px;
        }

        /* Table Design */
        .table-card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            padding: 16px 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .mono-text {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
        }

        /* Status Badge */
        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-pass {
            background: var(--pass-bg);
            color: var(--pass-color);
        }

        .badge-fail {
            background: var(--fail-bg);
            color: var(--fail-color);
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER NAVIGATION -->
    <div class="header-card">
        <div class="header-title">
            <i class="fa-solid fa-calculator"></i>
            <div>
                <h1>Fee Calculator Unit Tests</h1>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Pengujian Otomatis Expected vs Actual (5 Test Case P3)</p>
            </div>
        </div>
        <a href="fee-calculator.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Buka Kalkulator Biaya
        </a>
    </div>

    <!-- STATS SUMMARY -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Total Test Cases</div>
            <div class="value" style="color: var(--text-dark);"><?= $totalTests ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Status Lolos (PASS)</div>
            <div class="value" style="color: var(--pass-color);"><?= $passCount ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Status Gagal (FAIL)</div>
            <div class="value" style="color: var(--fail-color);"><?= $failCount ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Tingkat Keberhasilan</div>
            <div class="value" style="color: var(--primary);"><?= round(($passCount / $totalTests) * 100) ?>%</div>
        </div>
    </div>

    <!-- TABLE TEST RESULTS -->
    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi Skenario</th>
                        <th>Biaya Dasar</th>
                        <th>Peserta</th>
                        <th>Diskon</th>
                        <th>Admin</th>
                        <th>Expected</th>
                        <th>Actual</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testResults as $row): ?>
                        <tr>
                            <td><strong>#<?= $row['id'] ?></strong></td>
                            <td>
                                <strong><?= htmlspecialchars($row['title']) ?></strong>
                            </td>
                            <td class="mono-text"><?= rupiah($row['fee']) ?></td>
                            <td><?= $row['participant_count'] ?> Orang</td>
                            <td><?= $row['discount_percent'] ?>%</td>
                            <td class="mono-text"><?= rupiah($row['admin_fee']) ?></td>
                            <td class="mono-text" style="color: #0284c7;"><?= rupiah($row['expected']) ?></td>
                            <td class="mono-text" style="color: var(--primary);"><?= rupiah($row['actual']) ?></td>
                            <td>
                                <?php if ($row['passed']): ?>
                                    <span class="badge-status badge-pass">
                                        <i class="fa-solid fa-circle-check"></i> PASS
                                    </span>
                                <?php else: ?>
                                    <span class="badge-status badge-fail">
                                        <i class="fa-solid fa-circle-xmark"></i> FAIL
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>