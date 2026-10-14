<?php
// Set timezone & variabel pendukung
date_default_timezone_set('Asia/Jakarta');
$siteName = 'KursusKu';
$pageTitle = 'Eksperimen Operator Bitwise';

/* ============================================================================
 * LOGIKA BITWISE PERMITTED (SESUAI MODUL PRAKTIKUM PERTEMUAN 4)
 * ============================================================================ */

// 1. Definisi Flag Izin Akses (Representasi Bit)
define('PERM_READ',    1); // Bit 0: 0001 (Desimal 1)
define('PERM_WRITE',   2); // Bit 1: 0010 (Desimal 2)
define('PERM_DELETE',  4); // Bit 2: 0100 (Desimal 4)
define('PERM_EXECUTE', 8); // Bit 3: 1000 (Desimal 8)

// 2. Simulasi Penggabungan Hak Akses Pengguna (Bitwise OR |)
$userRole       = $_GET['role'] ?? 'editor';
$userPermission = 0;

switch ($userRole) {
    case 'admin':
        $userPermission = PERM_READ | PERM_WRITE | PERM_DELETE | PERM_EXECUTE; // 1111 (15)
        break;
    case 'editor':
        $userPermission = PERM_READ | PERM_WRITE; // 0011 (3)
        break;
    case 'viewer':
    default:
        $userPermission = PERM_READ; // 0001 (1)
        break;
}

// 3. Pengecekan Hak Akses (Bitwise AND &)
$canRead    = ($userPermission & PERM_READ) === PERM_READ;
$canWrite   = ($userPermission & PERM_WRITE) === PERM_WRITE;
$canDelete  = ($userPermission & PERM_DELETE) === PERM_DELETE;
$canExecute = ($userPermission & PERM_EXECUTE) === PERM_EXECUTE;

// 4. Kalkulator Bitwise Kustom (Input GET)
$valA = isset($_GET['a']) ? (int)$_GET['a'] : 12;
$valB = isset($_GET['b']) ? (int)$_GET['b'] : 5;

// Konversi ke representasi biner 8-bit
function toBinary8Bit($num) {
    return sprintf("%08b", $num);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - <?= $siteName ?></title>

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-dark: #090d16;
            --surface: #111827;
            --surface-card: #1f293d;
            --border: #2e3d59;
            --primary: #06b6d4;
            --secondary: #8b5cf6;
            --accent: #f43f5e;
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
            background-color: var(--bg-dark);
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
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        /* GRID CARDS */
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .card-header i {
            font-size: 1.4rem;
            color: var(--primary);
        }

        .card-header h2 {
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* ROLE SELECTOR */
        .role-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .role-btn {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            background: var(--surface-card);
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        .role-btn:hover, .role-btn.active {
            background: var(--primary);
            color: #000;
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.4);
        }

        /* PERMISSION STATUS LIST */
        .perm-list {
            list-style: none;
        }

        .perm-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: var(--surface-card);
            border-radius: 10px;
            margin-bottom: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .badge-perm {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-granted {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .badge-denied {
            background: rgba(244, 63, 94, 0.15);
            color: var(--accent);
            border: 1px solid rgba(244, 63, 94, 0.3);
        }

        /* BITWISE OPERATOR TABLE */
        .bit-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Fira Code', monospace;
            font-size: 0.9rem;
        }

        .bit-table th, .bit-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .bit-table th {
            color: var(--text-muted);
            font-weight: 500;
        }

        .val-highlight {
            color: #38bdf8;
            font-weight: 700;
        }

        /* CALCULATOR FORM */
        .calc-form {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .input-group {
            flex: 1;
        }

        .input-group label {
            display: block;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .calc-input {
            width: 100%;
            padding: 10px 14px;
            background: var(--surface-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: #fff;
            font-family: 'Fira Code', monospace;
            outline: none;
        }

        .calc-input:focus {
            border-color: var(--primary);
        }

        .btn-calc {
            background: var(--secondary);
            color: #fff;
            border: none;
            padding: 0 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 22px;
            height: 42px;
        }

        .btn-calc:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* NAV FOOTER */
        .nav-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-link:hover {
            color: #38bdf8;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- HEADER -->
        <header class="page-header">
            <h1><i class="fa-solid fa-microchip"></i> <?= $pageTitle ?></h1>
            <p>Pengujian Representasi Bit & Hak Akses Pengguna (Sub-CPMK3 Web III)</p>
        </header>

        <div class="grid-layout">
            <!-- CARD 1: SIMULASI FLAG PERMISSION -->
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-user-shield"></i>
                    <h2>Simulasi Hak Akses (Bitwise OR & AND)</h2>
                </div>

                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px;">
                    Pilih peran pengguna untuk menguji bitwise flag:
                </p>

                <div class="role-selector">
                    <a href="bitwise-test.php?role=viewer" class="role-btn <?= $userRole === 'viewer' ? 'active' : '' ?>">Viewer</a>
                    <a href="bitwise-test.php?role=editor" class="role-btn <?= $userRole === 'editor' ? 'active' : '' ?>">Editor</a>
                    <a href="bitwise-test.php?role=admin" class="role-btn <?= $userRole === 'admin' ? 'active' : '' ?>">Admin</a>
                </div>

                <div style="background: var(--surface-card); padding: 12px; border-radius: 8px; margin-bottom: 15px;" class="code-font">
                    <small style="color: var(--text-muted); display:block;">Combined Bitmask Value:</small>
                    <strong style="color: var(--primary); font-size: 1.1rem;"><?= $userPermission ?></strong> 
                    <span style="color: var(--text-muted);"> (Biner: <?= toBinary8Bit($userPermission) ?>)</span>
                </div>

                <ul class="perm-list">
                    <li class="perm-item">
                        <span><i class="fa-solid fa-eye"></i> Baca Data (READ)</span>
                        <span class="badge-perm <?= $canRead ? 'badge-granted' : 'badge-denied' ?>">
                            <?= $canRead ? 'IZIN' : 'DITOLAK' ?>
                        </span>
                    </li>
                    <li class="perm-item">
                        <span><i class="fa-solid fa-pen"></i> Tulis Data (WRITE)</span>
                        <span class="badge-perm <?= $canWrite ? 'badge-granted' : 'badge-denied' ?>">
                            <?= $canWrite ? 'IZIN' : 'DITOLAK' ?>
                        </span>
                    </li>
                    <li class="perm-item">
                        <span><i class="fa-solid fa-trash"></i> Hapus Data (DELETE)</span>
                        <span class="badge-perm <?= $canDelete ? 'badge-granted' : 'badge-denied' ?>">
                            <?= $canDelete ? 'IZIN' : 'DITOLAK' ?>
                        </span>
                    </li>
                    <li class="perm-item">
                        <span><i class="fa-solid fa-terminal"></i> Eksekusi (EXECUTE)</span>
                        <span class="badge-perm <?= $canExecute ? 'badge-granted' : 'badge-denied' ?>">
                            <?= $canExecute ? 'IZIN' : 'DITOLAK' ?>
                        </span>
                    </li>
                </ul>
            </div>

            <!-- CARD 2: KALKULATOR OPERATOR BITWISE -->
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-calculator"></i>
                    <h2>Kalkulator Operasi Bitwise</h2>
                </div>

                <form method="GET" action="bitwise-test.php" class="calc-form">
                    <input type="hidden" name="role" value="<?= htmlspecialchars($userRole) ?>">
                    <div class="input-group">
                        <label for="inputA">Angka A (Desimal)</label>
                        <input type="number" id="inputA" name="a" class="calc-input" value="<?= $valA ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="inputB">Angka B (Desimal)</label>
                        <input type="number" id="inputB" name="b" class="calc-input" value="<?= $valB ?>" required>
                    </div>
                    <button type="submit" class="btn-calc"><i class="fa-solid fa-bolt"></i> Hitung</button>
                </form>

                <table class="bit-table">
                    <thead>
                        <tr>
                            <th>Operasi</th>
                            <th>Ekspresi</th>
                            <th>Biner (8-Bit)</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nilai A</td>
                            <td><span class="code-font">$a</span></td>
                            <td><span class="code-font"><?= toBinary8Bit($valA) ?></span></td>
                            <td><span class="val-highlight"><?= $valA ?></span></td>
                        </tr>
                        <tr>
                            <td>Nilai B</td>
                            <td><span class="code-font">$b</span></td>
                            <td><span class="code-font"><?= toBinary8Bit($valB) ?></span></td>
                            <td><span class="val-highlight"><?= $valB ?></span></td>
                        </tr>
                        <tr>
                            <td>AND (&)</td>
                            <td><span class="code-font">$a & $b</span></td>
                            <td><span class="code-font"><?= toBinary8Bit($valA & $valB) ?></span></td>
                            <td><span class="val-highlight"><?= $valA & $valB ?></span></td>
                        </tr>
                        <tr>
                            <td>OR (|)</td>
                            <td><span class="code-font">$a | $b</span></td>
                            <td><span class="code-font"><?= toBinary8Bit($valA | $valB) ?></span></td>
                            <td><span class="val-highlight"><?= $valA | $valB ?></span></td>
                        </tr>
                        <tr>
                            <td>XOR (^)</td>
                            <td><span class="code-font">$a ^ $b</span></td>
                            <td><span class="code-font"><?= toBinary8Bit($valA ^ $valB) ?></span></td>
                            <td><span class="val-highlight"><?= $valA ^ $valB ?></span></td>
                        </tr>
                        <tr>
                            <td>NOT (~)</td>
                            <td><span class="code-font">~$a</span></td>
                            <td><span class="code-font"><?= toBinary8Bit(~$valA) ?></span></td>
                            <td><span class="val-highlight"><?= ~$valA ?></span></td>
                        </tr>
                        <tr>
                            <td>Shift Left (<<)</td>
                            <td><span class="code-font">$a << 1</span></td>
                            <td><span class="code-font"><?= toBinary8Bit($valA << 1) ?></span></td>
                            <td><span class="val-highlight"><?= $valA << 1 ?></span></td>
                        </tr>
                        <tr>
                            <td>Shift Right (>>)</td>
                            <td><span class="code-font">$a >> 1</span></td>
                            <td><span class="code-font"><?= toBinary8Bit($valA >> 1) ?></span></td>
                            <td><span class="val-highlight"><?= $valA >> 1 ?></span></td>
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