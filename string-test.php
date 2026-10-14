<?php
require_once __DIR__ . '/helpers.php';

// Ambil input string dari GET parameter atau gunakan sampel default
$inputString = $_GET['text'] ?? '   Selamat Datang di Platform KursusKu Prototype!   ';

// Pemrosesan Manipulasi String PHP
$originalText = $inputString;
$trimmedText  = trim($inputString);
$lengthRaw    = strlen($originalText);
$lengthClean  = strlen($trimmedText);
$wordCount    = str_word_count($trimmedText);
$upperText    = strtoupper($trimmedText);
$lowerText    = strtolower($trimmedText);
$ucfirstText  = ucfirst(strtolower($trimmedText));
$ucwordsText  = ucwords(strtolower($trimmedText));
$reversedText = strrev($trimmedText);

// Pengujian Substring dan Replacement
$searchWord   = $_GET['search'] ?? 'KursusKu';
$replaceWord  = $_GET['replace'] ?? 'Platform Digital';
$replacedText = str_replace($searchWord, $replaceWord, $trimmedText);
$posSearch    = stripos($trimmedText, $searchWord);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>String Manipulation Test — KursusKu</title>
    
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
            --accent: #f59e0b;
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
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header Navigation Card */
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

        /* Interactive Form Input */
        .form-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
            align-items: end;
        }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
        }

        /* Stats Grid Cards */
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
        }

        .stat-card .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
        }

        .stat-card .value {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            margin-top: 4px;
        }

        /* Detail Results Grid */
        .results-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .results-grid { grid-template-columns: 1fr; }
        }

        .result-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .result-card h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
        }

        .code-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: #0f172a;
            word-break: break-all;
            margin-bottom: 12px;
        }

        .badge-info {
            background: var(--primary-light);
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER NAVIGATION -->
    <div class="header-card">
        <div class="header-title">
            <i class="fa-solid fa-font"></i>
            <div>
                <h1>String Test Laboratory</h1>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Pengujian Fungsi Manipulasi Teks & String PHP</p>
            </div>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
        </a>
    </div>

    <!-- FORM INPUT EKSPERIMEN -->
    <div class="form-card">
        <form method="GET" action="string-test.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="text">Teks Utama:</label>
                    <input type="text" id="text" name="text" class="form-control" value="<?= htmlspecialchars($originalText) ?>" required>
                </div>
                <div class="form-group">
                    <label for="search">Cari Kata:</label>
                    <input type="text" id="search" name="search" class="form-control" value="<?= htmlspecialchars($searchWord) ?>">
                </div>
                <div class="form-group">
                    <label for="replace">Ganti Dengan:</label>
                    <input type="text" id="replace" name="replace" class="form-control" value="<?= htmlspecialchars($replaceWord) ?>">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Uji Teks
                </button>
            </div>
        </form>
    </div>

    <!-- CARDS STATISTIK NATIVE -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Panjang Teks (Raw)</div>
            <div class="value"><?= $lengthRaw ?> <small style="font-size: 0.9rem; color: var(--text-muted);">karakter</small></div>
        </div>
        <div class="stat-card">
            <div class="label">Panjang Teks (Trimmed)</div>
            <div class="value"><?= $lengthClean ?> <small style="font-size: 0.9rem; color: var(--text-muted);">karakter</small></div>
        </div>
        <div class="stat-card">
            <div class="label">Jumlah Kata</div>
            <div class="value"><?= $wordCount ?> <small style="font-size: 0.9rem; color: var(--text-muted);">kata</small></div>
        </div>
        <div class="stat-card">
            <div class="label">Posisi Kata Cari</div>
            <div class="value">
                <?= $posSearch !== false ? 'Index ' . $posSearch : '<span style="color: #ef4444; font-size:1.1rem;">Tidak ditemukan</span>' ?>
            </div>
        </div>
    </div>

    <!-- HASIL DETAIL MANIPULASI -->
    <div class="results-grid">
        
        <!-- KOLOM 1: MENGUBAH FORMAT TEKS -->
        <div class="result-card">
            <h3><i class="fa-solid fa-text-height" style="color: var(--primary);"></i> Format Kapitalisasi</h3>
            
            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">UPPERCASE (strtoupper):</p>
            <div class="code-box"><?= htmlspecialchars($upperText) ?></div>

            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">lowercase (strtolower):</p>
            <div class="code-box"><?= htmlspecialchars($lowerText) ?></div>

            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">Capitalize First (ucfirst):</p>
            <div class="code-box"><?= htmlspecialchars($ucfirstText) ?></div>

            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">Title Case Each Word (ucwords):</p>
            <div class="code-box"><?= htmlspecialchars($ucwordsText) ?></div>
        </div>

        <!-- KOLOM 2: REMOVAL & REPLACEMENT -->
        <div class="result-card">
            <h3><i class="fa-solid fa-scissors" style="color: var(--primary);"></i> Trim & Penggantian</h3>
            
            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">Pembersihan Spasi Outter (trim):</p>
            <div class="code-box">"<?= htmlspecialchars($trimmedText) ?>"</div>

            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">Pembalikan Karakter (strrev):</p>
            <div class="code-box"><?= htmlspecialchars($reversedText) ?></div>

            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 4px;">Hasil Penggantian Kata (str_replace):</p>
            <div class="code-box" style="border-left: 4px solid var(--primary);"><?= htmlspecialchars($replacedText) ?></div>
        </div>

    </div>

</div>

</body>
</html>