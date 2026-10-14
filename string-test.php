<?php
// Set timezone & variabel pendukung
date_default_timezone_set('Asia/Jakarta');
$siteName  = 'KursusKu';
$pageTitle = 'Eksperimen Fungsi String PHP';

/* ============================================================================
 * LOGIKA PENGOLEHAN STRING (SESUAI MODUL PRAKTIKUM PERTEMUAN 4)
 * ============================================================================ */

// 1. Teks Mentah Contoh (Sengaja Diberi Spasi Luar untuk Uji trim())
$rawNameInput = $_GET['text'] ?? '   Laravel Fundamental & Web Dev   ';

// 2. Pemrosesan Fungsi String Bawaan PHP
$cleanName  = trim($rawNameInput);                  // Menghapus spasi di awal/akhir
$upperName  = strtoupper($cleanName);               // Mengubah ke huruf kapital
$lowerName  = strtolower($cleanName);               // Mengubah ke huruf kecil
$lengthByte = strlen($cleanName);                   // Menghitung panjang string dalam byte
$shortTitle = substr($cleanName, 0, 7);             // Mengambil 7 karakter pertama
$replaced   = str_replace('Web', 'App', $cleanName);// Mengganti kata 'Web' menjadi 'App'
$slugified  = strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\- ]/', '', $cleanName))); // Membuat URL Slug
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - <?= $siteName ?></title>

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-main: #0a0e1a;
            --surface: #121829;
            --card-bg: rgba(26, 34, 56, 0.75);
            --border: rgba(255, 255, 255, 0.12);
            --primary: #ec4899;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-light);
            line-height: 1.6;
            padding: 30px 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        /* INPUT FORM CARD */
        .input-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            margin-bottom: 30px;
        }

        .input-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .text-input {
            flex: 1;
            min-width: 260px;
            padding: 12px 16px;
            background: #060913;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: #fff;
            font-family: 'Fira Code', monospace;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .text-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.3);
        }

        /* GRID RESULTS */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }

        .function-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .function-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .fn-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .fn-name {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--accent);
        }

        .fn-badge {
            background: rgba(236, 72, 153, 0.15);
            color: var(--primary);
            border: 1px solid rgba(236, 72, 153, 0.3);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .fn-output {
            background: #060913;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 12px 16px;
            font-family: 'Fira Code', monospace;
            font-size: 0.9rem;
            color: #38bdf8;
            word-break: break-all;
            min-height: 48px;
            display: flex;
            align-items: center;
        }

        .fn-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 10px;
        }

        /* SUMMARY TABLE */
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }

        .table-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .summary-table th, .summary-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .summary-table th {
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        /* FOOTER NAV */
        .nav-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-link:hover {
            color: var(--primary);
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- HEADER -->
        <header class="header">
            <h1><i class="fa-solid fa-font"></i> <?= $pageTitle ?></h1>
            <p>Pengujian Manipulasi Teks & Fungsi Bawaan PHP (Sub-CPMK3 Web III)</p>
        </header>

        <!-- INPUT TESTING FORM -->
        <div class="input-card">
            <form method="GET" action="string-test.php" class="input-form">
                <input type="text" name="text" class="text-input" placeholder="Ketik teks untuk diuji..." value="<?= htmlspecialchars($rawNameInput) ?>" required>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-wand-magic-sparkles"></i> Uji Teks</button>
            </form>
            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 10px;">
                <i class="fa-solid fa-circle-info"></i> Teks mentah asli yang dikirim: <code class="code-font" style="color: #fbbf24;"><?= var_export($rawNameInput, true) ?></code>
            </div>
        </div>

        <!-- GRID HASIL FUNGSI STRING -->
        <div class="cards-grid">
            <!-- 1. TRIM -->
            <div class="function-card">
                <div class="fn-top">
                    <span class="fn-name code-font">trim($text)</span>
                    <span class="fn-badge">Pembersih Spasi</span>
                </div>
                <div class="fn-output"><?= htmlspecialchars($cleanName) ?></div>
                <div class="fn-desc">Menghapus spasi kososng di awal dan akhir teks mentah[cite: 85, 86].</div>
            </div>

            <!-- 2. STRTTOUPPER -->
            <div class="function-card">
                <div class="fn-top">
                    <span class="fn-name code-font">strtoupper($text)</span>
                    <span class="fn-badge">Huruf Kapital</span>
                </div>
                <div class="fn-output"><?= htmlspecialchars($upperName) ?></div>
                <div class="fn-desc">Mengubah seluruh huruf menjadi kapital/UPPERCASE[cite: 85, 86].</div>
            </div>

            <!-- 3. STRTOLOWER -->
            <div class="function-card">
                <div class="fn-top">
                    <span class="fn-name code-font">strtolower($text)</span>
                    <span class="fn-badge">Huruf Kecil</span>
                </div>
                <div class="fn-output"><?= htmlspecialchars($lowerName) ?></div>
                <div class="fn-desc">Mengubah seluruh karakter menjadi huruf kecil/lowercase[cite: 85, 86].</div>
            </div>

            <!-- 4. STRLEN -->
            <div class="function-card">
                <div class="fn-top">
                    <span class="fn-name code-font">strlen($text)</span>
                    <span class="fn-badge">Panjang String</span>
                </div>
                <div class="fn-output"><?= $lengthByte ?> Karakter (Byte)</div>
                <div class="fn-desc">Menghitung jumlah total karakter setelah dibersihkan[cite: 85, 86].</div>
            </div>

            <!-- 5. SUBSTR -->
            <div class="function-card">
                <div class="fn-top">
                    <span class="fn-name code-font">substr($text, 0, 7)</span>
                    <span class="fn-badge">Potong String</span>
                </div>
                <div class="fn-output"><?= htmlspecialchars($shortTitle) ?></div>
                <div class="fn-desc">Mengambil Sebagian karakter dari indeks 0 sebanyak 7[cite: 85, 86].</div>
            </div>

            <!-- 6. STR_REPLACE -->
            <div class="function-card">
                <div class="fn-top">
                    <span class="fn-name code-font">str_replace()</span>
                    <span class="fn-badge">Ganti Kata</span>
                </div>
                <div class="fn-output"><?= htmlspecialchars($replaced) ?></div>
                <div class="fn-desc">Mengganti kata "Web" menjadi "App" di dalam teks[cite: 86].</div>
            </div>
        </div>

        <!-- TABLE REFERENCE -->
        <div class="table-card">
            <div class="table-title">
                <i class="fa-solid fa-book" style="color: var(--primary);"></i>
                Referensi Fungsi String Paling Sering Digunakan di KursusKu
            </div>
            <div style="overflow-x: auto;">
                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Fungsi PHP</th>
                            <th>Kegunaan Utama</th>
                            <th>Contoh Kasus Proyek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code class="code-font" style="color: var(--accent);">trim()</code></td>
                            <td>Pembersihan spasi luar pendaftaran[cite: 85, 86]</td>
                            <td>Sanitasi nama lengkap & email pendaftar[cite: 15]</td>
                        </tr>
                        <tr>
                            <td><code class="code-font" style="color: var(--accent);">htmlspecialchars()</code></td>
                            <td>Pencegahan XSS Scripting Injection[cite: 15, 43]</td>
                            <td>Output Escaping sebelum data ditampilkan di HTML[cite: 15, 43]</td>
                        </tr>
                        <tr>
                            <td><code class="code-font" style="color: var(--accent);">substr()</code></td>
                            <td>Pengambilan potongan string[cite: 85, 86]</td>
                            <td>Membuat singkatan / ID Transaksi Otomatis[cite: 86]</td>
                        </tr>
                        <tr>
                            <td><code class="code-font" style="color: var(--accent);">implode()</code></td>
                            <td>Penggabungan Array menjadi Teks[cite: 15]</td>
                            <td>Menggabungkan pilihan Checkbox Minat[cite: 11, 15]</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FOOTER NAVIGASI -->
        <div class="nav-footer">
            <a href="index.php" class="btn-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda Proyek</a>
            <a href="test-functions.php" class="btn-link">Unit Test Function <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

</body>
</html>