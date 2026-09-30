<?php
require_once __DIR__ . '/helpers.php';

$siteName = 'KursusKu';
$year     = date('Y');

// 1. Data Dummy Riwayat Transaksi Lama (P6)
$legacyHistoryData = [
    [
        'id'               => 'TRX001',
        'timestamp'        => '2026-09-28 10:15:00',
        'nama'             => 'Ahmad Santoso',
        'email'            => 'ahmad.santoso@example.com',
        'course'           => 'Laravel Fundamental',
        'participant_type' => 'Mahasiswa',
        'interests'        => ['Backend', 'PHP', 'MVC'],
        'grand_total'      => 380000,
        'source'           => 'Dummy P6 (Lama)'
    ],
    [
        'id'               => 'TRX002',
        'timestamp'        => '2026-09-29 14:30:00',
        'nama'             => 'Siti Aminah',
        'email'            => 'siti.aminah@example.com',
        'course'           => 'PHP Dasar',
        'participant_type' => 'Guru',
        'interests'        => ['Web Dasar', 'Backend'],
        'grand_total'      => 287500,
        'source'           => 'Dummy P6 (Lama)'
    ],
    [
        'id'               => 'TRX003',
        'timestamp'        => '2026-09-30 09:00:00',
        'nama'             => 'Budi Pratama',
        'email'            => 'budi.pratama@example.com',
        'course'           => 'Web Dasar',
        'participant_type' => 'Umum',
        'interests'        => ['Frontend', 'HTML/CSS'],
        'grand_total'      => 200000,
        'source'           => 'Dummy P6 (Lama)'
    ]
];

// 2. Ambil data pendaftar baru dari helper (jika ada)
$dynamicRegistrations = function_exists('getAllRegistrations') ? getAllRegistrations() : [];

// 3. Gabungkan Data Tanpa Menghilangkan/Mengurangi Data Lama
$allRegistrations = array_merge($dynamicRegistrations, $legacyHistoryData);

// Kalkulasi Statistik Ringkas
$totalTransaksi = count($allRegistrations);
$totalPendapatan = array_reduce($allRegistrations, function ($acc, $item) {
    return $acc + ($item['grand_total'] ?? $item['total_fee'] ?? $item['total'] ?? 0);
}, 0);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteName) ?> — Riwayat Transaksi & Pendaftaran</title>

    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- External Base Styles -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #115e59;
            --primary-light: #ccfbf1;
            --accent: #6366f1;
            --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 50%, #f3e8ff 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.6);
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
        }

        .history-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Header Title Section */
        .page-header {
            text-align: center;
            margin-bottom: 35px;
            position: relative;
        }

        .page-header .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: var(--primary);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.1);
            margin-bottom: 12px;
            border: 1px solid var(--glass-border);
        }

        .page-header h1 {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* Stats Cards Dashboard */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.green { background: #dcfce7; color: #15803d; }
        .stat-icon.blue { background: #dbeafe; color: #1d4ed8; }
        .stat-icon.purple { background: #f3e8ff; color: #6b21a8; }

        .stat-info .label { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; }
        .stat-info .value { font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-top: 2px; }

        /* Table Control & Filter */
        .table-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.07);
        }

        .table-header-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .search-box {
            position: relative;
            min-width: 280px;
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
            padding: 10px 14px 10px 40px;
            border-radius: 12px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            font-size: 0.88rem;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }

        /* Custom Table Styling */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .data-table-custom th {
            padding: 12px 16px;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }

        .data-table-custom tbody tr {
            background: #ffffff;
            border-radius: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .data-table-custom tbody tr:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            transform: scale(1.002);
        }

        .data-table-custom td {
            padding: 16px;
            vertical-align: middle;
            font-size: 0.9rem;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .data-table-custom td:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; border-left: 1px solid #f1f5f9; }
        .data-table-custom td:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; border-right: 1px solid #f1f5f9; }

        /* Badges & Chips */
        .badge-code {
            background: #f1f5f9;
            color: #334155;
            padding: 4px 8px;
            border-radius: 6px;
            font-family: monospace;
            font-weight: 700;
            font-size: 0.82rem;
        }

        .badge-type {
            display: inline-block;
            font-weight: 700;
            font-size: 0.78rem;
            padding: 3px 10px;
            border-radius: 20px;
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-tag-chip {
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 0.72rem;
            padding: 2px 8px;
            border-radius: 6px;
            margin-top: 4px;
            margin-right: 2px;
        }

        .badge-source-legacy {
            background: #fef3c7;
            color: #b45309;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .badge-source-dynamic {
            background: #dcfce7;
            color: #15803d;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .btn-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: gap 0.2s;
        }

        .btn-back-link:hover {
            gap: 12px;
            color: var(--primary-dark);
        }
    </style>
</head>

<body>

    <!-- NAVBAR UTAMA -->
    <header class="site-header">
        <div class="container nav-wrap">
            <a href="index.php" class="brand"><i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($siteName) ?></a>
            <nav class="navbar">
                <a href="index.php">Beranda</a>
                <a href="form-p5.php">Form P5</a>
                <a href="daftar-p6.php">Daftar P6</a>
                <a href="history.php" class="active">History</a>
            </nav>
        </div>
    </header>

    <main class="history-wrapper">
        
        <!-- HEADER KONTEN -->
        <div class="page-header">
            <span class="badge-pill"><i class="fa-solid fa-clock-rotate-left"></i> Data Terintegrasi P5 & P6</span>
            <h1>Riwayat Pendaftaran & Transaksi</h1>
            <p>Gabungan data dummy historis dengan data pendaftaran baru secara *real-time*.</p>
        </div>

        <!-- DASHBOARD RINGKASAN (STAT CARDS) -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-receipt"></i></div>
                <div class="stat-info">
                    <div class="label">Total pendaftaran</div>
                    <div class="value"><?= $totalTransaksi ?> Transaksi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-wallet"></i></div>
                <div class="stat-info">
                    <div class="label">Total Akumulasi Biaya</div>
                    <div class="value">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fa-solid fa-database"></i></div>
                <div class="stat-info">
                    <div class="label">Sumber Data</div>
                    <div class="value">Legacy + Sync Data</div>
                </div>
            </div>
        </div>

        <!-- MAIN TABLE CARD -->
        <div class="table-card">
            <div class="table-header-action">
                <div>
                    <h3 style="font-weight: 800; font-size: 1.2rem; color: #0f172a;">Daftar Transaksi Masuk</h3>
                    <p style="font-size: 0.85rem; color: #64748b;">Menampilkan seluruh data tanpa mengubah record sebelumnya.</p>
                </div>

                <!-- Input Pencarian Realtime Javascript -->
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Cari nama, kursus, atau ID..." onkeyup="filterTable()">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table-custom" id="historyTable">
                    <thead>
                        <tr>
                            <th>ID & Waktu</th>
                            <th>Nama / Email</th>
                            <th>Program Kursus</th>
                            <th>Tipe & Minat</th>
                            <th>Total Biaya</th>
                            <th>Sumber Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($allRegistrations)): ?>
                            <?php foreach ($allRegistrations as $row): ?>
                                <?php
                                    $id           = $row['id'] ?? 'TRX-UNKNOWN';
                                    $nama         = $row['nama'] ?? $row['name'] ?? '-';
                                    $email        = $row['email'] ?? 'tidak.ada@email.com';
                                    $course       = $row['course'] ?? $row['kursus'] ?? '-';
                                    $type         = $row['participant_type'] ?? $row['profession'] ?? $row['level'] ?? 'Umum';
                                    $interests    = $row['interests'] ?? [];
                                    $totalFee     = $row['grand_total'] ?? $row['total_fee'] ?? $row['total'] ?? 0;
                                    $source       = $row['source'] ?? 'Form P5/P6 Sync';
                                    $timestamp    = $row['timestamp'] ?? $row['date'] ?? date('Y-m-d');
                                    $isLegacy     = str_contains(strtolower($source), 'dummy') || str_contains(strtolower($source), 'lama');
                                ?>
                                <tr>
                                    <td>
                                        <span class="badge-code"><?= htmlspecialchars($id) ?></span><br>
                                        <small style="color: #94a3b8; font-size: 0.78rem; font-weight: 600; vertical-align: middle;">
                                            <i class="fa-regular fa-clock" style="margin-top: 4px;"></i> <?= htmlspecialchars($timestamp) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <strong style="color: #0f172a; font-weight: 700;"><?= htmlspecialchars($nama) ?></strong><br>
                                        <small style="color: #64748b; font-size: 0.8rem;"><?= htmlspecialchars($email) ?></small>
                                    </td>
                                    <td>
                                        <span style="font-weight: 700; color: #1e293b;"><?= htmlspecialchars($course) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge-type"><?= htmlspecialchars($type) ?></span>
                                        <?php if (!empty($interests) && is_array($interests)): ?>
                                            <div>
                                                <?php foreach ($interests as $interest): ?>
                                                    <span class="badge-tag-chip"><?= htmlspecialchars($interest) ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong style="color: #059669; font-size: 0.95rem;">
                                            Rp <?= number_format($totalFee, 0, ',', '.') ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <?php if ($isLegacy): ?>
                                            <span class="badge-source-legacy"><i class="fa-solid fa-box-archive"></i> <?= htmlspecialchars($source) ?></span>
                                        <?php else: ?>
                                            <span class="badge-source-dynamic"><i class="fa-solid fa-bolt"></i> <?= htmlspecialchars($source) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 40px; margin-bottom: 10px;"></i>
                                    <p>Belum ada riwayat pendaftaran tersimpan.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <a href="daftar-p6.php" class="btn-back-link">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Form Pendaftaran (P6)
                </a>
                <a href="form-p5.php" class="btn-back-link" style="color: #6366f1;">
                    Kembali ke Form P5 <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; <?= $year ?> <strong><?= htmlspecialchars($siteName) ?></strong>. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- JS FITUR PENCARIAN REALTIME -->
    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('historyTable');
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