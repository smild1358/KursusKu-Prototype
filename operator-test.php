<?php
require_once __DIR__ . '/helpers.php';

// Ambil input nilai A dan B dari parameter GET (atau gunakan nilai default)
$valA = isset($_GET['a']) ? (float)$_GET['a'] : 10;
$valB = isset($_GET['b']) ? (float)$_GET['b'] : 3;

// 1. Operator Aritmatika
$add = $valA + $valB;
$sub = $valA - $valB;
$mul = $valA * $valB;
$div = $valB != 0 ? round($valA / $valB, 2) : 'Undefined (Div by 0)';
$mod = $valB != 0 ? fmod($valA, $valB) : 'Undefined';
$exp = $valA ** $valB;

// 2. Operator Perbandingan Standard
$eq        = ($valA == $valB) ? 'true' : 'false';
$identical = ($valA === $valB) ? 'true' : 'false';
$neq       = ($valA != $valB) ? 'true' : 'false';
$gt        = ($valA > $valB) ? 'true' : 'false';
$lt        = ($valA < $valB) ? 'true' : 'false';
$gte       = ($valA >= $valB) ? 'true' : 'false';
$lte       = ($valA <= $valB) ? 'true' : 'false';

// 3. Modul Khusus Demonstrasi Identik $fee === 350000
$fee           = 350000;
$feeTestVal    = 350000;
$feeIdentical  = ($fee === $feeTestVal); // Result: true
$feeType       = gettype($fee);
$feeTestType   = gettype($feeTestVal);

// 4. Operator Increment & Decrement
$incA = $valA; 
$incA++;
$decB = $valB; 
$decB--;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Test Laboratory — KursusKu</title>
    
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
            --success: #10b981;
            --danger: #ef4444;
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

        /* Form Input */
        .form-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 16px;
            align-items: end;
        }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
            outline: none;
            font-family: 'JetBrains Mono', monospace;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 13px 24px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
        }

        /* Highlight Fee Banner */
        .fee-highlight-card {
            background: linear-gradient(135deg, #0f766e 0%, #042f2e 100%);
            color: white;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 12px 28px rgba(15, 118, 110, 0.15);
        }

        .fee-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .fee-code-box {
            background: rgba(0, 0, 0, 0.3);
            border-left: 4px solid var(--success);
            padding: 16px;
            border-radius: 10px;
            font-family: 'JetBrains Mono', monospace;
            margin: 14px 0;
            font-size: 0.95rem;
        }

        .bool-badge-true {
            background: #d1fae5;
            color: #065f46;
            font-family: 'JetBrains Mono', monospace;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 800;
        }

        .bool-badge-false {
            background: #fee2e2;
            color: #991b1b;
            font-family: 'JetBrains Mono', monospace;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 800;
        }

        /* Results Grid */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .panel-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .panel-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 12px;
        }

        .panel-title i {
            color: var(--primary);
        }

        .op-table {
            width: 100%;
            border-collapse: collapse;
        }

        .op-table td {
            padding: 10px 4px;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.9rem;
        }

        .op-expr {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            color: var(--text-dark);
        }

        .op-res {
            font-family: 'JetBrains Mono', monospace;
            text-align: right;
            font-weight: 700;
            color: var(--primary);
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Header Card -->
    <div class="header-card">
        <div class="header-title">
            <i class="fa-solid fa-calculator"></i>
            <div>
                <h1>Operator Test Laboratory</h1>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Pengujian Operator Aritmatika, Perbandingan & Identitas PHP</p>
            </div>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Interactive Parameter Form -->
    <div class="form-card">
        <form method="GET" action="operator-test.php">
            <div class="form-grid">
                <div class="form-group">
                    <label><i class="fa-solid fa-vial"></i> Nilai A ($valA)</label>
                    <input type="number" step="any" name="a" class="form-control" value="<?= htmlspecialchars($valA) ?>" required>
                </div>
                <div class="form-group">
                    <label><i class="fa-solid fa-vial"></i> Nilai B ($valB)</label>
                    <input type="number" step="any" name="b" class="form-control" value="<?= htmlspecialchars($valB) ?>" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-play"></i> Jalankan Pengujian
                </button>
            </div>
        </form>
    </div>

    <!-- Modul Khusus: Visualisasi $fee === 350000 -->
    <div class="fee-highlight-card">
        <span class="fee-badge"><i class="fa-solid fa-certificate"></i> Modul Evaluasi Identitas Tipe Data</span>
        <h2 style="font-size: 1.25rem; font-weight: 800;">Uji Identitas Biaya: <code>$fee === 350000</code></h2>
        <p style="font-size: 0.88rem; opacity: 0.9; margin-top: 4px;">
            Ekspresi perbandingan di bawah ini menghasilkan nilai <strong>true</strong> karena nilai dan tipe data kedua operand secara presisi bernilai sama.
        </p>

        <div class="fee-code-box">
            $fee = <?= $fee ?>; <span style="color: #94a3b8;">// Tipe: <?= $feeType ?></span><br>
            $fee === 350000; <span style="color: #94a3b8;">// Pembanding Tipe: <?= $feeTestType ?></span><br>
            <span style="color: #38bdf8;">Hasil Evaluasi:</span> <?= $feeIdentical ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?>
        </div>
    </div>

    <!-- Results Panels -->
    <div class="results-grid">

        <!-- 1. Aritmatika -->
        <div class="panel-card">
            <div class="panel-title">
                <i class="fa-solid fa-plus-minus"></i> Operator Aritmatika
            </div>
            <table class="op-table">
                <tr>
                    <td class="op-expr"><?= $valA ?> + <?= $valB ?></td>
                    <td class="op-res"><?= $add ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> - <?= $valB ?></td>
                    <td class="op-res"><?= $sub ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> * <?= $valB ?></td>
                    <td class="op-res"><?= $mul ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> / <?= $valB ?></td>
                    <td class="op-res"><?= $div ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> % <?= $valB ?></td>
                    <td class="op-res"><?= $mod ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> ** <?= $valB ?></td>
                    <td class="op-res"><?= $exp ?></td>
                </tr>
            </table>
        </div>

        <!-- 2. Perbandingan -->
        <div class="panel-card">
            <div class="panel-title">
                <i class="fa-solid fa-code-compare"></i> Operator Perbandingan
            </div>
            <table class="op-table">
                <tr>
                    <td class="op-expr"><?= $valA ?> == <?= $valB ?></td>
                    <td class="op-res"><?= $eq === 'true' ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> === <?= $valB ?></td>
                    <td class="op-res"><?= $identical === 'true' ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> != <?= $valB ?></td>
                    <td class="op-res"><?= $neq === 'true' ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> > <?= $valB ?></td>
                    <td class="op-res"><?= $gt === 'true' ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> < <?= $valB ?></td>
                    <td class="op-res"><?= $lt === 'true' ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> >= <?= $valB ?></td>
                    <td class="op-res"><?= $gte === 'true' ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?></td>
                </tr>
                <tr>
                    <td class="op-expr"><?= $valA ?> <= <?= $valB ?></td>
                    <td class="op-res"><?= $lte === 'true' ? '<span class="bool-badge-true">true</span>' : '<span class="bool-badge-false">false</span>' ?></td>
                </tr>
            </table>
        </div>

        <!-- 3. Increment / Decrement -->
        <div class="panel-card">
            <div class="panel-title">
                <i class="fa-solid fa-arrow-up-1-9"></i> Increment & Decrement
            </div>
            <table class="op-table">
                <tr>
                    <td class="op-expr">$valA (Awal)</td>
                    <td class="op-res"><?= $valA ?></td>
                </tr>
                <tr>
                    <td class="op-expr">$valA++ (Post-Increment)</td>
                    <td class="op-res"><?= $incA ?></td>
                </tr>
                <tr>
                    <td class="op-expr">$valB (Awal)</td>
                    <td class="op-res"><?= $valB ?></td>
                </tr>
                <tr>
                    <td class="op-expr">$valB-- (Post-Decrement)</td>
                    <td class="op-res"><?= $decB ?></td>
                </tr>
            </table>
        </div>

    </div>

</div>

</body>
</html>