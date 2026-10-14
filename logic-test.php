<?php
// Set timezone & variabel pendukung
date_default_timezone_set('Asia/Jakarta');
$siteName  = 'KursusKu';
$pageTitle = 'Uji Logika & Perbandingan PHP';

/* ============================================================================
 * LOGIKA PERBANDINGAN & OPERATOR LOGIKA (SESUAI PERTEMUAN 4)
 * ============================================================================ */

// 1. Ambil nilai input dari form GET atau gunakan default
$quota      = isset($_GET['quota']) ? (int)$_GET['quota'] : 30;
$registered = isset($_GET['registered']) ? (int)$_GET['registered'] : 18;
$isOnline   = isset($_GET['online']) ? (bool)$_GET['online'] : true;

// 2. Evaluasi Kondisi Perbandingan (Comparison)
$isFull     = $registered >= $quota; // Logika status Penuh
$hasSeat    = $registered < $quota;  // Logika sisa kursi tersedia[cite: 81]

// 3. Evaluasi Operator Logika (&&, ||, !)
$canRegister  = !$isFull && $hasSeat;                       // AND & NOT[cite: 80]
$isAlmostFull = ($registered / $quota) >= 0.8 && !$isFull;  // Kampanye hampir penuh[cite: 80]
$isSpecialRow = $isOnline || $hasSeat;                      // OR[cite: 80]
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
            --bg-dark: #080d1a;
            --surface: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --border: rgba(255, 255, 255, 0.12);
            --primary: #10b981;
            --secondary: #3b82f6;
            --danger: #ef4444;
            --warning: #f59e0b;
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
            background-color: var(--bg-dark);
            color: var(--text-light);
            line-height: 1.6;
            padding: 30px 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 950px;
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

        /* SIMULATION FORM */
        .sim-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            margin-bottom: 30px;
        }

        .sim-form {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .input-group {
            flex: 1;
            min-width: 180px;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .sim-input {
            width: 100%;
            padding: 10px 14px;
            background: #020617;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: #fff;
            font-family: 'Fira Code', monospace;
            outline: none;
        }

        .sim-input:focus {
            border-color: var(--primary);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 11px 24px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 42px;
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* GRID RESULTS */
        .grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .logic-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .logic-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .card-title {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logic-expr {
            font-family: 'Fira Code', monospace;
            background: #020617;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #38bdf8;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .badge-result {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-true {
            background: rgba(16, 185, 129, 0.15);
            color: var(--primary);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .badge-false {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* OPERATOR TABLE */
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
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

        .ref-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .ref-table th, .ref-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .ref-table th {
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
            color: var(--secondary);
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
            <h1><i class="fa-solid fa-code-branch"></i> <?= $pageTitle ?></h1>
            <p>Pengujian Operator Perbandingan & Logika Kondisional (Sub-CPMK3 Web III)</p>
        </header>

        <!-- FORM SIMULASI NILAI -->
        <div class="sim-card">
            <form method="GET" action="logic-test.php" class="sim-form">
                <div class="input-group">
                    <label for="quota"><i class="fa-solid fa-users"></i> Total Kuota ($quota)</label>
                    <input type="number" id="quota" name="quota" class="sim-input" value="<?= $quota ?>" required>
                </div>
                <div class="input-group">
                    <label for="registered"><i class="fa-solid fa-user-check"></i> Terdaftar ($registered)</label>
                    <input type="number" id="registered" name="registered" class="sim-input" value="<?= $registered ?>" required>
                </div>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-play"></i> Jalankan Uji Logika</button>
            </form>
        </div>

        <!-- GRID HASIL EVALUASI -->
        <div class="grid-cards">
            <!-- 1. STATUS PENUH ($registered >= $quota) -->
            <div class="logic-card">
                <div class="card-title">
                    <span>STATUS PENUH</span>
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="logic-expr">$registered >= $quota</div>
                <span class="badge-result <?= $isFull ? 'badge-true' : 'badge-false' ?>">
                    <?= $isFull ? 'TRUE (PENUH)' : 'FALSE (BELUM PENUH)' ?>
                </span>
            </div>

            <!-- 2. MEMILIKI KURSI ($registered < $quota) -->
            <div class="logic-card">
                <div class="card-title">
                    <span>SISA KURSI AVAILABLE</span>
                    <i class="fa-solid fa-chair"></i>
                </div>
                <div class="logic-expr">$registered < $quota</div>
                <span class="badge-result <?= $hasSeat ? 'badge-true' : 'badge-false' ?>">
                    <?= $hasSeat ? 'TRUE (ADA KURSI)' : 'FALSE (HABIS)' ?>
                </span>
            </div>

            <!-- 3. BISA DAFTAR (!$isFull && $hasSeat) -->
            <div class="logic-card">
                <div class="card-title">
                    <span>IZIN BISA DAFTAR</span>
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="logic-expr">!$isFull && $hasSeat</div>
                <span class="badge-result <?= $canRegister ? 'badge-true' : 'badge-false' ?>">
                    <?= $canRegister ? 'TRUE (DAPAT DAFTAR)' : 'FALSE (DITOLAK)' ?>
                </span>
            </div>

            <!-- 4. HAMPIR PENUH ((registered/quota) >= 0.8) -->
            <div class="logic-card">
                <div class="card-title">
                    <span>Peringatan Hampir Penuh (>=80%)</span>
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="logic-expr">($reg / $quota) >= 0.8</div>
                <span class="badge-result <?= $isAlmostFull ? 'badge-true' : 'badge-false' ?>">
                    <?= $isAlmostFull ? 'TRUE (HAMPIR PENUH)' : 'FALSE (NORMAL)' ?>
                </span>
            </div>
        </div>

        <!-- TABLE REFERENCE LOGIKA -->
        <div class="table-card">
            <div class="table-title">
                <i class="fa-solid fa-book" style="color: var(--primary);"></i>
                Referensi Operator Perbandingan & Logika PHP
            </div>
            <div style="overflow-x: auto;">
                <table class="ref-table">
                    <thead>
                        <tr>
                            <th>Operator</th>
                            <th>Nama Operator</th>
                            <th>Contoh Ekspresi</th>
                            <th>Hasil Penjelasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code class="code-font" style="color: #38bdf8;">===</code></td>
                            <td>Strict Identikal[cite: 80]</td>
                            <td><code class="code-font">$a === $b</code></td>
                            <td>True jika nilai dan tipe data sama persis[cite: 80]</td>
                        </tr>
                        <tr>
                            <td><code class="code-font" style="color: #38bdf8;">>=</code></td>
                            <td>Lebih Besar / Sama Dengan[cite: 80]</td>
                            <td><code class="code-font">$registered >= $quota</code></td>
                            <td>True jika jumlah pendaftar mencapai/melewati kuota[cite: 80]</td>
                        </tr>
                        <tr>
                            <td><code class="code-font" style="color: #38bdf8;">&&</code></td>
                            <td>Logical AND[cite: 80]</td>
                            <td><code class="code-font">$condA && $condB</code></td>
                            <td>True jika KEDUA kondisi bernilai true[cite: 80]</td>
                        </tr>
                        <tr>
                            <td><code class="code-font" style="color: #38bdf8;">||</code></td>
                            <td>Logical OR[cite: 80]</td>
                            <td><code class="code-font">$condA || $condB</code></td>
                            <td>True jika SALAH SATU kondisi bernilai true[cite: 80]</td>
                        </tr>
                        <tr>
                            <td><code class="code-font" style="color: #38bdf8;">!</code></td>
                            <td>Logical NOT[cite: 80]</td>
                            <td><code class="code-font">!$isFull</code></td>
                            <td>Membalik nilai boolean (True jadi False)[cite: 80]</td>
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