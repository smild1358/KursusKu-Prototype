<?php
require_once __DIR__ . '/helpers.php';

$siteName = 'KursusKu';
$year     = date('Y');

// Dynamic Master Data Kursus (Di-render via Looping PHP)
$courses = [
    'web-dev'  => ['title' => 'Web Development Mastering', 'price' => 500000, 'icon' => 'fa-code'],
    'data-sci' => ['title' => 'Data Science & Machine Learning', 'price' => 650000, 'icon' => 'fa-brain'],
    'ui-ux'    => ['title' => 'UI/UX Design & Prototyping', 'price' => 450000, 'icon' => 'fa-pen-ruler'],
    'cyber'    => ['title' => 'Cyber Security Essentials', 'price' => 600000, 'icon' => 'fa-shield-halved'],
];

// Master Data Minat Belajar
$availableInterests = ['Frontend', 'Backend', 'Database', 'UI/UX', 'DevOps', 'Mobile App'];

// Master Data Metode Belajar
$learningMethods = [
    'online' => 'Online Self-Paced (Akses 24/7)',
    'live'   => 'Live Virtual Class (Interaktif Zoom)',
    'hybrid' => 'Hybrid Class (Tatap Muka + Online)',
];

// Initial State Form
$isSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');
$errors      = [];
$invoice     = null;

if ($isSubmitted) {
    // Sanitasi & Ambil Input Form P6
    $nama            = trim($_POST['nama'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $courseKey       = $_POST['course_code'] ?? '';
    $participantType = $_POST['participant_type'] ?? '';
    $interests       = $_POST['interests'] ?? [];
    $methodKey       = $_POST['learning_method'] ?? '';
    $packageQty      = max(1, intval($_POST['package_qty'] ?? 1));
    $catatan         = trim($_POST['catatan'] ?? '');

    // Validasi Sisi Server
    if (empty($nama) || strlen($nama) < 3) {
        $errors[] = "Nama lengkap wajib diisi minimal 3 karakter.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Alamat email tidak valid.";
    }
    if (empty($courseKey) || !isset($courses[$courseKey])) {
        $errors[] = "Silakan pilih kursus yang tersedia.";
    }
    if (empty($participantType)) {
        $errors[] = "Silakan pilih tipe peserta.";
    }
    if (empty($methodKey) || !isset($learningMethods[$methodKey])) {
        $errors[] = "Silakan pilih metode belajar.";
    }

    // Pemrosesan Data & Kalkulasi Diskon P6
    if (empty($errors)) {
        $selectedCourse = $courses[$courseKey];
        $basePrice      = $selectedCourse['price'] * $packageQty;
        $discountRate   = 0;

        // Aturan Percabangan Diskon Berdasarkan Tipe Peserta
        switch ($participantType) {
            case 'mahasiswa':
                $discountRate = 0.20; // Diskon 20%
                $typeBadge    = 'Mahasiswa (Diskon 20%)';
                break;
            case 'guru':
                $discountRate = 0.15; // Diskon 15%
                $typeBadge    = 'Guru / Pendidik (Diskon 15%)';
                break;
            case 'umum':
            default:
                $discountRate = 0.00; // Tanpa Diskon
                $typeBadge    = 'Umum (Harga Normal)';
                break;
        }

        $discountValue = $basePrice * $discountRate;
        $grandTotal    = $basePrice - $discountValue;
        $trxId         = 'TRX-P6-' . strtoupper(substr(md5(uniqid()), 0, 6));
        $timestamp     = date('d M Y, H:i') . ' WIB';

        // 1. Data Invoice untuk Tampilan UI Sisi Kanan (Lama)
        $invoice = [
            'id_transaksi'     => $trxId,
            'nama'             => htmlspecialchars($nama),
            'email'            => htmlspecialchars($email),
            'course_title'     => $selectedCourse['title'],
            'course_icon'      => $selectedCourse['icon'],
            'participant_type' => $typeBadge,
            'learning_method'  => $learningMethods[$methodKey],
            'package_qty'      => $packageQty,
            'interests'        => array_map('htmlspecialchars', $interests),
            'catatan'          => htmlspecialchars($catatan),
            'base_price'       => $basePrice,
            'discount_percent' => ($discountRate * 100),
            'discount_value'   => $discountValue,
            'grand_total'      => $grandTotal,
            'timestamp'        => $timestamp,
        ];

        // 2. Format Data Terintegrasi (Baru - Dapat Disimpan ke Session/Database/File)
        $registrationData = [
            'id'               => $trxId,
            'nama'             => htmlspecialchars($nama),
            'email'            => htmlspecialchars($email),
            'course'           => $selectedCourse['title'],
            'participant_type' => ucfirst($participantType),
            'learning_method'  => $learningMethods[$methodKey],
            'package_qty'      => $packageQty,
            'interests'        => array_map('htmlspecialchars', $interests),
            'catatan'          => htmlspecialchars($catatan),
            'base_price'       => $basePrice,
            'discount_rate'    => $discountRate,
            'discount_value'   => $discountValue,
            'grand_total'      => $grandTotal,
            'created_at'       => date('Y-m-d H:i:s'),
        ];

        // Contoh Penyimpanan Data (Jika helper memiliki fungsi saveRegistration)
        if (function_exists('saveRegistration')) {
            saveRegistration($registrationData);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteName) ?> — Pendaftaran Form P6 Lanjutan</title>

    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- External CSS Projek -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --brand-primary: #059669;
            --brand-primary-dark: #047857;
            --brand-accent: #10b981;
            --bg-page: #f0fdf4;
            --card-border: #d1fae5;
        }

        body {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 10% 10%, rgba(16, 185, 129, 0.08) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(5, 150, 105, 0.08) 0px, transparent 50%);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }

        .p6-wrapper {
            max-width: 1080px;
            margin: 0 auto;
        }

        .p6-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .p6-header .badge-milestone {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #d1fae5;
            color: var(--brand-primary-dark);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 12px;
            border: 1px solid #a7f3d0;
        }

        .p6-header h1 {
            font-size: 2.3rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .p6-header p {
            color: #64748b;
            font-size: 0.98rem;
        }

        .p6-grid-container {
            display: grid;
            grid-template-columns: 1.25fr 0.75fr;
            gap: 28px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .p6-grid-container { grid-template-columns: 1fr; }
        }

        .p6-card-form {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px -10px rgba(5, 150, 105, 0.08);
        }

        .form-row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 600px) {
            .form-row-2col { grid-template-columns: 1fr; }
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-size: 0.92rem;
            background: #ffffff;
            color: #0f172a;
            transition: all 0.2s;
            font-family: inherit;
        }

        .form-control-custom:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
            outline: none;
        }

        /* Custom Radio & Checkbox Styling */
        .option-chips-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .chip-option {
            position: relative;
            flex: 1;
            min-width: 110px;
        }

        .chip-option input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .chip-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            font-size: 0.88rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .chip-option input:checked + .chip-label {
            border-color: var(--brand-primary);
            background: #ecfdf5;
            color: var(--brand-primary-dark);
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.12);
        }

        .chip-option input:focus + .chip-label {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        }

        /* Group Buttons */
        .action-button-group {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn-submit-p6 {
            flex: 2;
            min-width: 180px;
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
            color: #ffffff;
            border: none;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 20px -4px rgba(5, 150, 105, 0.4);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit-p6:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -4px rgba(5, 150, 105, 0.5);
        }

        .btn-secondary-p6 {
            flex: 1;
            min-width: 120px;
            background: #ffffff;
            color: #0f172a;
            border: 1.5px solid #cbd5e1;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 700;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-secondary-p6:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        /* Invoice & Summary Side Panel */
        .side-sticky-panel {
            position: sticky;
            top: 90px;
        }

        .invoice-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            padding: 24px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        }

        .invoice-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px dashed #e2e8f0;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }

        .invoice-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.88rem;
        }

        .invoice-row .key { color: #64748b; }
        .invoice-row .val { font-weight: 600; color: #0f172a; text-align: right; }

        .discount-badge-text {
            color: #dc2626;
            font-weight: 700;
        }

        .total-price-box {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin-top: 18px;
        }

        .total-price-box .total-amount {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--brand-primary-dark);
            margin-top: 2px;
        }

        .alert-error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.88rem;
        }
    </style>
</head>

<body>

    <!-- NAVBAR UTAMA -->
    <header class="site-header">
        <div class="container nav-wrap">
            <a href="index.php" class="brand"><i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($siteName) ?></a>
            <nav class="navbar" aria-label="Navigasi Utama">
                <a href="index.php">Beranda</a>
                <a href="form-p5.php">Form P5</a>
                <a href="daftar-p6.php" class="active">Daftar P6</a>
                <a href="history.php">History</a>
                <a href="test-matrix.php">Unit Test</a>
            </nav>
        </div>
    </header>

    <main class="container" style="padding: 40px 0 60px;">
        <div class="p6-wrapper">
            
            <!-- HEADER MODUL -->
            <div class="p6-header">
                <span class="badge-milestone"><i class="fa-solid fa-layer-group"></i> Milestone 6 &bull; Form Lanjutan</span>
                <h1>Form Pendaftaran Kursus Interaktif</h1>
                <p>Alur: Form Input &rarr; Validasi & Percabangan Diskon &rarr; Loop Rendering &rarr; Ringkasan Invoice</p>
            </div>

            <div class="p6-grid-container">
                
                <!-- SISI KIRI: FORM INPUT LENGKAP -->
                <div class="p6-card-form">
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert-error-box">
                            <strong><i class="fa-solid fa-triangle-exclamation"></i> Terdapat kendala input:</strong>
                            <ul style="margin-left: 20px; margin-top: 6px;">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= $err ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="daftar-p6.php" method="POST" id="formDaftarP6">
                        
                        <!-- 1. IDENTITAS PENDAFTAR -->
                        <div class="form-row-2col">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap *</label>
                                <input type="text" id="nama" name="nama" class="form-control-custom" placeholder="Contoh: Rian Anggara" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Alamat Email *</label>
                                <input type="email" id="email" name="email" class="form-control-custom" placeholder="rian@contoh.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            </div>
                        </div>

                        <!-- 2. PILIHAN KURSUS (PHP LOOPING RENDER) -->
                        <div class="form-group">
                            <label for="course_code">Pilih Program Kursus *</label>
                            <select id="course_code" name="course_code" class="form-control-custom" required onchange="calculateLiveTotal()">
                                <option value="" disabled selected>-- Pilih Jenis Kursus --</option>
                                <?php foreach ($courses as $key => $course): ?>
                                    <option value="<?= $key ?>" <?= (($_POST['course_code'] ?? '') === $key) ? 'selected' : '' ?>>
                                        <?= $course['title'] ?> — Rp <?= number_format($course['price'], 0, ',', '.') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 3. TIPE PESERTA (RADIO BUTTONS - DISKON LOGIC) -->
                        <div class="form-group">
                            <label>Tipe Peserta (Potongan Diskon Khusus) *</label>
                            <div class="option-chips-container">
                                <div class="chip-option">
                                    <input type="radio" id="type_mhs" name="participant_type" value="mahasiswa" <?= (($_POST['participant_type'] ?? '') === 'mahasiswa') ? 'checked' : '' ?> onchange="calculateLiveTotal()" required>
                                    <label for="type_mhs" class="chip-label"><i class="fa-solid fa-user-graduate"></i> Mahasiswa (-20%)</label>
                                </div>
                                <div class="chip-option">
                                    <input type="radio" id="type_guru" name="participant_type" value="guru" <?= (($_POST['participant_type'] ?? '') === 'guru') ? 'checked' : '' ?> onchange="calculateLiveTotal()">
                                    <label for="type_guru" class="chip-label"><i class="fa-solid fa-chalkboard-user"></i> Guru (-15%)</label>
                                </div>
                                <div class="chip-option">
                                    <input type="radio" id="type_umum" name="participant_type" value="umum" <?= (($_POST['participant_type'] ?? 'umum') === 'umum') ? 'checked' : '' ?> onchange="calculateLiveTotal()">
                                    <label for="type_umum" class="chip-label"><i class="fa-solid fa-user"></i> Umum</label>
                                </div>
                            </div>
                        </div>

                        <!-- 4. MINAT BELAJAR (CHECKBOX ARRAY) -->
                        <div class="form-group">
                            <label>Minat Fokus Belajar (Bisa pilih lebih dari satu)</label>
                            <div class="option-chips-container">
                                <?php
                                $selectedInterests = $_POST['interests'] ?? [];
                                foreach ($availableInterests as $idx => $interest):
                                    $chipId = 'interest_' . $idx;
                                    $isCheck = in_array($interest, $selectedInterests) ? 'checked' : '';
                                ?>
                                    <div class="chip-option">
                                        <input type="checkbox" id="<?= $chipId ?>" name="interests[]" value="<?= $interest ?>" <?= $isCheck ?>>
                                        <label for="<?= $chipId ?>" class="chip-label"><i class="fa-solid fa-check"></i> <?= $interest ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- 5. METODE BELAJAR & JUMLAH PAKET -->
                        <div class="form-row-2col">
                            <div class="form-group">
                                <label for="learning_method">Metode Belajar *</label>
                                <select id="learning_method" name="learning_method" class="form-control-custom" required>
                                    <option value="" disabled selected>-- Pilih Metode --</option>
                                    <?php foreach ($learningMethods as $mKey => $mLabel): ?>
                                        <option value="<?= $mKey ?>" <?= (($_POST['learning_method'] ?? '') === $mKey) ? 'selected' : '' ?>><?= $mLabel ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="package_qty">Jumlah Paket / Bulan *</label>
                                <select id="package_qty" name="package_qty" class="form-control-custom" onchange="calculateLiveTotal()">
                                    <option value="1" <?= (($_POST['package_qty'] ?? '1') == '1') ? 'selected' : '' ?>>1 Paket Bulan</option>
                                    <option value="3" <?= (($_POST['package_qty'] ?? '') == '3') ? 'selected' : '' ?>>3 Paket Bulan (Hemat 5%)</option>
                                    <option value="6" <?= (($_POST['package_qty'] ?? '') == '6') ? 'selected' : '' ?>>6 Paket Bulan (Hemat 10%)</option>
                                </select>
                            </div>
                        </div>

                        <!-- 6. CATATAN TAMBAHAN -->
                        <div class="form-group">
                            <label for="catatan">Catatan Tambahan / Kebutuhan Khusus</label>
                            <textarea id="catatan" name="catatan" class="form-control-custom" rows="3" placeholder="Tuliskan catatan khusus jika ada..."><?= htmlspecialchars($_POST['catatan'] ?? '') ?></textarea>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="action-button-group">
                            <button type="submit" class="btn-submit-p6">
                                <i class="fa-solid fa-paper-plane"></i> Proses Pendaftaran
                            </button>
                            <a href="history.php" class="btn-secondary-p6">
                                <i class="fa-solid fa-clock-rotate-left"></i> History Dummy
                            </a>
                            <a href="test-matrix.php" class="btn-secondary-p6">
                                <i class="fa-solid fa-vial-circle-check"></i> Loop Lab
                            </a>
                        </div>

                    </form>
                </div>

                <!-- SISI KANAN: LIVE INVOICE / RINGKASAN DATA -->
                <div class="side-sticky-panel">
                    <div class="invoice-card">
                        
                        <?php if ($invoice): ?>
                            <!-- HASIL SUBMIT FORM (INVOICE FINAL) -->
                            <div class="invoice-header">
                                <div>
                                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">INVOICE PENDAFTARAN</span>
                                    <h4 style="font-size: 1.1rem; color: #0f172a; font-weight: 800;"><?= $invoice['id_transaksi'] ?></h4>
                                </div>
                                <span style="background: #dcfce7; color: #15803d; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 20px;">Lunas / Sukses</span>
                            </div>

                            <div class="invoice-row">
                                <span class="key">Nama</span>
                                <span class="val"><?= $invoice['nama'] ?></span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Email</span>
                                <span class="val"><?= $invoice['email'] ?></span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Program Kursus</span>
                                <span class="val"><i class="fa-solid <?= $invoice['course_icon'] ?>"></i> <?= $invoice['course_title'] ?></span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Kategori Peserta</span>
                                <span class="val"><?= $invoice['participant_type'] ?></span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Metode & Durasi</span>
                                <span class="val"><?= $invoice['package_qty'] ?> Bulan &bull; <?= explode(' ', $invoice['learning_method'])[0] ?></span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Minat Terpilih</span>
                                <span class="val">
                                    <?php if (!empty($invoice['interests'])): ?>
                                        <?= implode(', ', $invoice['interests']) ?>
                                    <?php else: ?>
                                        <em style="color: #94a3b8;">Tidak ada</em>
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div style="border-top: 1px dashed #e2e8f0; margin: 12px 0;"></div>

                            <div class="invoice-row">
                                <span class="key">Harga Normal</span>
                                <span class="val">Rp <?= number_format($invoice['base_price'], 0, ',', '.') ?></span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Potongan Diskon</span>
                                <span class="val discount-badge-text">Rp <?= number_format($invoice['discount_value'], 0, ',', '.') ?> (<?= $invoice['discount_percent'] ?>%)</span>
                            </div>

                            <div class="total-price-box">
                                <span style="font-size: 0.8rem; color: #047857; font-weight: 700; text-transform: uppercase;">TOTAL BIAYA AKHIR</span>
                                <div class="total-amount">Rp <?= number_format($invoice['grand_total'], 0, ',', '.') ?></div>
                            </div>

                            <p style="font-size: 0.75rem; color: #94a3b8; text-align: center; margin-top: 12px;">
                                <i class="fa-solid fa-calendar-check"></i> <?= $invoice['timestamp'] ?>
                            </p>

                        <?php else: ?>
                            <!-- PREVIEW ESTIMASI BIAYA REALTIME SAAT KETIK -->
                            <div class="invoice-header">
                                <div>
                                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">ESTIMASI REALTIME</span>
                                    <h4 style="font-size: 1.05rem; color: #0f172a; font-weight: 800;">Simulasi Biaya Pendaftaran</h4>
                                </div>
                                <i class="fa-solid fa-calculator" style="color: var(--brand-primary); font-size: 1.4rem;"></i>
                            </div>

                            <div class="invoice-row">
                                <span class="key">Kursus Dipilih</span>
                                <span class="val" id="prevCourseTitle">-</span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Diskon Peserta</span>
                                <span class="val" id="prevDiscountPercent">0%</span>
                            </div>
                            <div class="invoice-row">
                                <span class="key">Jumlah Paket</span>
                                <span class="val" id="prevQty">1 Paket</span>
                            </div>

                            <div class="total-price-box">
                                <span style="font-size: 0.8rem; color: #047857; font-weight: 700; text-transform: uppercase;">ESTIMASI TOTAL</span>
                                <div class="total-amount" id="prevTotalAmount">Rp 0</div>
                            </div>

                            <p style="font-size: 0.78rem; color: #64748b; text-align: center; margin-top: 14px; line-height: 1.4;">
                                Pilih kursus dan kategori peserta di samping untuk melihat diskon otomatis.
                            </p>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; <?= $year ?> <strong><?= htmlspecialchars($siteName) ?></strong>. All rights reserved.</p>
        </div>
    </footer>

    <!-- SCRIPT ESTIMASI BIAYA SECARA LIVE (JAVASCRIPT) -->
    <script>
        const coursePrices = {
            'web-dev': 500000,
            'data-sci': 650000,
            'ui-ux': 450000,
            'cyber': 600000
        };

        const courseNames = {
            'web-dev': 'Web Development Mastering',
            'data-sci': 'Data Science & Machine Learning',
            'ui-ux': 'UI/UX Design & Prototyping',
            'cyber': 'Cyber Security Essentials'
        };

        function calculateLiveTotal() {
            const courseSelect = document.getElementById('course_code');
            const selectedKey = courseSelect.value;
            
            const selectedType = document.querySelector('input[name="participant_type"]:checked');
            const qtySelect = document.getElementById('package_qty');
            const packageQty = parseInt(qtySelect.value) || 1;

            let discountRate = 0;
            if (selectedType) {
                if (selectedType.value === 'mahasiswa') discountRate = 0.20;
                else if (selectedType.value === 'guru') discountRate = 0.15;
            }

            const prevCourseTitle = document.getElementById('prevCourseTitle');
            const prevDiscountPercent = document.getElementById('prevDiscountPercent');
            const prevQty = document.getElementById('prevQty');
            const prevTotalAmount = document.getElementById('prevTotalAmount');

            if (prevCourseTitle && prevTotalAmount) {
                if (selectedKey && coursePrices[selectedKey]) {
                    const base = coursePrices[selectedKey] * packageQty;
                    const finalPrice = base - (base * discountRate);

                    prevCourseTitle.textContent = courseNames[selectedKey];
                    prevDiscountPercent.textContent = (discountRate * 100) + '%';
                    prevQty.textContent = packageQty + ' Paket';
                    prevTotalAmount.textContent = 'Rp ' + Math.round(finalPrice).toLocaleString('id-ID');
                } else {
                    prevCourseTitle.textContent = '-';
                    prevDiscountPercent.textContent = '0%';
                    prevQty.textContent = packageQty + ' Paket';
                    prevTotalAmount.textContent = 'Rp 0';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', calculateLiveTotal);
    </script>

</body>
</html>