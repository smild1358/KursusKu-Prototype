<?php
$siteName = 'KursusKu';
$year     = date('Y');

// Data Test Matrix dari Pertemuan 6
$testMatrix = [
    [
        'no'       => 1,
        'skenario' => 'Mahasiswa, Web Dasar, 1 paket',
        'actual'   => 'Rp 240.000',
        'expected' => 'Rp 240.000',
        'status'   => 'PASS',
        'kat'      => 'Kalkulasi Harga'
    ],
    [
        'no'       => 2,
        'skenario' => 'Guru, PHP Dasar, 1 paket',
        'actual'   => 'Rp 340.000',
        'expected' => 'Rp 340.000',
        'status'   => 'PASS',
        'kat'      => 'Kalkulasi Harga'
    ],
    [
        'no'       => 3,
        'skenario' => 'Umum, Laravel Dasar, 1 paket',
        'actual'   => 'Rp 500.000',
        'expected' => 'Rp 500.000',
        'status'   => 'PASS',
        'kat'      => 'Kalkulasi Harga'
    ],
    [
        'no'       => 4,
        'skenario' => 'Mahasiswa, Web Dasar, 2 paket',
        'actual'   => 'Rp 480.000',
        'expected' => 'Rp 480.000',
        'status'   => 'PASS',
        'kat'      => 'Kalkulasi Harga'
    ],
    [
        'no'       => 5,
        'skenario' => 'Nama kosong',
        'actual'   => 'Nama wajib diisi.',
        'expected' => 'Nama wajib diisi.',
        'status'   => 'PASS',
        'kat'      => 'Validasi Input'
    ],
    [
        'no'       => 6,
        'skenario' => 'Email tidak valid',
        'actual'   => 'Email tidak valid.',
        'expected' => 'Email tidak valid.',
        'status'   => 'PASS',
        'kat'      => 'Validasi Input'
    ],
    [
        'no'       => 7,
        'skenario' => 'Minat kosong',
        'actual'   => 'Belum memilih minat.',
        'expected' => 'Belum memilih minat.',
        'status'   => 'PASS',
        'kat'      => 'Validasi Input'
    ],
    [
        'no'       => 8,
        'skenario' => '3 minat',
        'actual'   => 'Frontend, Backend, Database',
        'expected' => 'Frontend, Backend, Database',
        'status'   => 'PASS',
        'kat'      => 'Opsi Pilihan'
    ],
    [
        'no'       => 9,
        'skenario' => 'Metode offline',
        'actual'   => 'Tatap Muka',
        'expected' => 'Tatap Muka',
        'status'   => 'PASS',
        'kat'      => 'Opsi Pilihan'
    ],
    [
        'no'       => 10,
        'skenario' => 'Metode hybrid',
        'actual'   => 'Hybrid',
        'expected' => 'Hybrid',
        'status'   => 'PASS',
        'kat'      => 'Opsi Pilihan'
    ],
    [
        'no'       => 11,
        'skenario' => 'GET process.php',
        'actual'   => 'Redirect ke register.php',
        'expected' => 'Redirect ke register.php',
        'status'   => 'PASS',
        'kat'      => 'Keamanan/Routing'
    ],
    [
        'no'       => 12,
        'skenario' => 'Tambah fasilitas',
        'actual'   => 'Dirender otomatis dengan foreach',
        'expected' => 'Dirender otomatis dengan foreach',
        'status'   => 'PASS',
        'kat'      => 'Dinamis UI'
    ]
];

// Perhitungan Ringkasan Pengujian Otomatis
$totalTest = count($testMatrix);
$passCount = count(array_filter($testMatrix, fn($item) => strtoupper($item['status']) === 'PASS'));
$failCount = $totalTest - $passCount;
$successRate = $totalTest > 0 ? round(($passCount / $totalTest) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteName) ?> — Test Matrix Pertemuan 6</title>

    <!-- Font Google & FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #115e59;
            --primary-light: #ccfbf1;
            --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 50%, #f3e8ff 100%);
            --glass-bg: rgba(255, 255, 255, 0.88);
            --glass-border: rgba(255, 255, 255, 0.7);
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --pass-color: #10b981;
            --pass-bg: #ecfdf5;
            --fail-color: #ef4444;
            --fail-bg: #fef2f2;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            background-attachment: fixed;
            color: var(--text-dark);
            min-height: 100vh;
            margin: 0;
        }

        .matrix-wrapper {
            max-width: 1150px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Page Header Title */
        .header-section {
            text-align: center;
            margin-bottom: 35px;
        }

        .evidence-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: var(--primary);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.08);
            border: 1px solid var(--glass-border);
            margin-bottom: 12px;
        }

        .header-section h1 {
            font-size: 2.3rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
            margin: 0 0 8px 0;
        }

        .header-section p {
            color: var(--text-muted);
            font-size: 0.98rem;
            margin: 0;
        }

        /* Stats Bar / Dashboard Summary */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .stat-icon.total { background: #e0f2fe; color: #0284c7; }
        .stat-icon.pass { background: var(--pass-bg); color: var(--pass-color); }
        .stat-icon.rate { background: #f3e8ff; color: #7e22ce; }

        .stat-meta .label { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
        .stat-meta .value { font-size: 1.4rem; font-weight: 800; color: var(--text-dark); margin-top: 2px; }

        /* Table Card Container */
        .table-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.06);
        }

        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .search-box {
            position: relative;
            min-width: 260px;
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box input {
            width: 100%;
            padding: 9px 14px 9px 40px;
            border-radius: 12px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            font-size: 0.88rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
        }

        .filter-group {
            display: flex;
            gap: 8px;
        }

        .btn-filter {
            padding: 6px 14px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-filter.active, .btn-filter:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        /* Custom Table Styling */
        .table-responsive {
            overflow-x: auto;
        }

        .matrix-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .matrix-table th {
            padding: 12px 16px;
            font-size: 0.78rem;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background: rgba(241, 245, 249, 0.7);
            border-bottom: 2px solid #e2e8f0;
        }

        .matrix-table th:first-child { border-radius: 10px 0 0 10px; }
        .matrix-table th:last-child { border-radius: 0 10px 10px 0; }

        .matrix-table tbody tr {
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .matrix-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
        }

        .matrix-table td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 0.88rem;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .matrix-table td:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            border-left: 1px solid #f1f5f9;
            font-weight: 700;
            color: var(--text-muted);
            width: 50px;
            text-align: center;
        }

        .matrix-table td:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            border-right: 1px solid #f1f5f9;
            text-align: right;
            width: 100px;
        }

        /* Category Chip & Status Badge */
        .cat-chip {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--primary);
            background: var(--primary-light);
            padding: 2px 8px;
            border-radius: 6px;
            margin-bottom: 4px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 30px;
            letter-spacing: 0.05em;
        }

        .status-badge.pass {
            background: var(--pass-bg);
            color: var(--pass-color);
            border: 1px solid #a7f3d0;
        }

        .status-badge.fail {
            background: var(--fail-bg);
            color: var(--fail-color);
            border: 1px solid #fecaca;
        }

        /* Footer Navigation Link */
        .footer-action {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: gap 0.2s ease;
        }

        .back-link:hover {
            gap: 12px;
            color: var(--primary-dark);
        }
    </style>
</head>

<body>

    <!-- NAVBAR SYSTEM -->
    <header class="site-header">
        <div class="container nav-wrap">
            <a href="index.php" class="brand"><i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($siteName) ?></a>
            <nav class="navbar">
                <a href="index.php">Beranda</a>
                <a href="form-p5.php">Form P5</a>
                <a href="daftar-p6.php">Daftar P6</a>
                <a href="history.php">History</a>
                <a href="test-matrix.php" class="active">Test Matrix</a>
            </nav>
        </div>
    </header>

    <main class="matrix-wrapper">

        <!-- HEADER SECTION -->
        <div class="header-section">
            <span class="evidence-tag"><i class="fa-solid fa-flask-vial"></i> Evidence Week 06</span>
            <h1>Test Matrix Pertemuan 6</h1>
            <p>Hasil uji validasi skenario, penanganan input, kalkulasi harga, dan fungsionalitas sistem.</p>
        </div>

        <!-- STATS DASHBOARD -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fa-solid fa-list-check"></i></div>
                <div class="stat-meta">
                    <div class="label">Total Pengujian</div>
                    <div class="value"><?= $totalTest ?> Skenario</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pass"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-meta">
                    <div class="label">Status Lolos (PASS)</div>
                    <div class="value"><?= $passCount ?> Skenario</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon rate"><i class="fa-solid fa-chart-line"></i></div>
                <div class="stat-meta">
                    <div class="label">Tingkat Keberhasilan</div>
                    <div class="value"><?= $successRate ?>%</div>
                </div>
            </div>
        </div>

        <!-- MAIN TABLE CARD -->
        <div class="table-card">
            
            <div class="table-actions">
                <div>
                    <h3 style="margin:0; font-size: 1.15rem; font-weight:800; color: #0f172a;">Rincian Kasus Uji</h3>
                    <p style="margin: 3px 0 0 0; font-size: 0.85rem; color: #64748b;">Verifikasi kesesuaian antara hasil Aktual vs Ekspektasi[cite: 8].</p>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" placeholder="Cari skenario / data..." onkeyup="filterTable()">
                    </div>
                </div>
            </div>

            <!-- TABLE MATRIX -->
            <div class="table-responsive">
                <table class="matrix-table" id="matrixTable">
                    <thead>
                        <tr>
                            <th style="text-align: center;">NO</th>
                            <th>SKENARIO</th>
                            <th>ACTUAL</th>
                            <th>EXPECTED</th>
                            <th style="text-align: right;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testMatrix as $row): ?>
                            <?php $isPass = strtoupper($row['status']) === 'PASS'; ?>
                            <tr>
                                <td><?= $row['no'] ?></td>
                                <td>
                                    <span class="cat-chip"><?= htmlspecialchars($row['kat']) ?></span><br>
                                    <strong style="color: #0f172a;"><?= htmlspecialchars($row['skenario']) ?></strong>
                                </td>
                                <td>
                                    <span style="color: #334155; font-family: monospace; font-size: 0.88rem;">
                                        <?= htmlspecialchars($row['actual']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="color: #334155; font-family: monospace; font-size: 0.88rem;">
                                        <?= htmlspecialchars($row['expected']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge <?= $isPass ? 'pass' : 'fail' ?>">
                                        <i class="fa-solid <?= $isPass ? 'fa-check' : 'fa-xmark' ?>"></i>
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- FOOTER NAVIGATION -->
            <div class="footer-action">
                <a href="daftar-p6.php" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Form Register P6
                </a>
                <a href="history.php" class="back-link" style="color: #6366f1;">
                    Lihat Riwayat Transaksi <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

        </div>

    </main>

    <!-- FOOTER SYSTEM -->
    <footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; <?= $year ?> <strong><?= htmlspecialchars($siteName) ?></strong>. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- INTERACTIVE SCRIPT -->
    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('matrixTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let rowText = tr[i].textContent || tr[i].innerText;
                if (rowText.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
</body>

</html>