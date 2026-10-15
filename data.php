<?php
/**
 * data.php - Master Data P6
 */
$coursesData = [
    'WEB-01' => ['name' => 'Web Dasar', 'fee' => 200000],
    'PHP-01' => ['name' => 'PHP Dasar', 'fee' => 250000],
    'PHP-02' => ['name' => 'PHP Lanjutan', 'fee' => 300000],
    'LAR-01' => ['name' => 'Laravel Fundamental', 'fee' => 350000],
    'DB-01'  => ['name' => 'MySQL Dasar', 'fee' => 275000]
];

$interestsData = [
    'frontend' => 'Frontend Development',
    'backend'  => 'Backend Development',
    'database' => 'Database Administration',
    'uiux'     => 'UI/UX Design'
];

$facilitiesData = [
    'cert' => ['name' => 'Sertifikat Cetak', 'fee' => 50000],
    'mod'  => ['name' => 'Modul Panduan Printed', 'fee' => 75000],
    'lab'  => ['name' => 'Akses Server Lab 24/7', 'fee' => 100000]
];

// Helper fungsi kecil untuk format Rupiah khusus pada tampilan visual
if (!function_exists('formatRupiahData')) {
    function formatRupiahData($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

// Jika file di-include oleh file lain (misal: register.php / process.php), hentikan render HTML di bawah
if (basename($_SERVER['SCRIPT_FILENAME']) !== 'data.php') {
    return;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Viewer — KursusKu</title>
    
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

        /* Header Navigation */
        .header-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px 30px;
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.08);
            border: 1px solid rgba(15, 118, 110, 0.1);
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 14px;
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

        /* Layout Grid */
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
            gap: 24px;
        }

        .data-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        .data-card:hover {
            transform: translateY(-4px);
        }

        .data-card h2 {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--text-dark);
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 10px;
        }

        .badge-count {
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .data-list {
            list-style: none;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 10px;
            font-size: 0.92rem;
        }

        .data-item:last-child {
            margin-bottom: 0;
        }

        .code-tag {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            background: #e2e8f0;
            color: #334155;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
        }

        .price-text {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            color: var(--primary);
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER NAVIGATION -->
    <div class="header-card">
        <div class="header-title">
            <i class="fa-solid fa-database"></i>
            <div>
                <h1>Master Data Inspector</h1>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Visualisasi Variabel Array Data P6 ($coursesData, $interestsData, $facilitiesData)</p>
            </div>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- DISPLAY CARDS -->
    <div class="data-grid">

        <!-- 1. DATA KURSUS -->
        <div class="data-card">
            <h2>
                <span><i class="fa-solid fa-graduation-cap" style="color: var(--primary); margin-right: 8px;"></i> Data Kursus</span>
                <span class="badge-count"><?= count($coursesData) ?> Items</span>
            </h2>
            <ul class="data-list">
                <?php foreach ($coursesData as $code => $course): ?>
                    <li class="data-item">
                        <div>
                            <span class="code-tag"><?= htmlspecialchars($code) ?></span>
                            <strong style="margin-left: 6px;"><?= htmlspecialchars($course['name']) ?></strong>
                        </div>
                        <span class="price-text"><?= formatRupiahData($course['fee']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- 2. DATA MINAT -->
        <div class="data-card">
            <h2>
                <span><i class="fa-solid fa-compass" style="color: var(--primary); margin-right: 8px;"></i> Kategori Minat</span>
                <span class="badge-count"><?= count($interestsData) ?> Items</span>
            </h2>
            <ul class="data-list">
                <?php foreach ($interestsData as $key => $title): ?>
                    <li class="data-item">
                        <span class="code-tag"><?= htmlspecialchars($key) ?></span>
                        <span style="font-weight: 600; color: #334155;"><?= htmlspecialchars($title) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- 3. DATA FASILITAS -->
        <div class="data-card">
            <h2>
                <span><i class="fa-solid fa-box-open" style="color: var(--primary); margin-right: 8px;"></i> Fasilitas Tambahan</span>
                <span class="badge-count"><?= count($facilitiesData) ?> Items</span>
            </h2>
            <ul class="data-list">
                <?php foreach ($facilitiesData as $key => $facility): ?>
                    <li class="data-item">
                        <div>
                            <span class="code-tag"><?= htmlspecialchars($key) ?></span>
                            <strong style="margin-left: 6px;"><?= htmlspecialchars($facility['name']) ?></strong>
                        </div>
                        <span class="price-text"><?= formatRupiahData($facility['fee']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

</div>

</body>
</html>