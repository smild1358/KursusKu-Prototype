<?php
// Data Daftar Kursus
$courses = [
    'web_dasar' => ['title' => 'Web Dasar', 'price' => 300000],
    'php_dasar' => ['title' => 'PHP Dasar', 'price' => 350000],
    'laravel'   => ['title' => 'Laravel Fundamental', 'price' => 500000],
    'react_js'  => ['title' => 'React JS Mastery', 'price' => 450000]
];

// Inisialisasi & Tangkap Data POST
$name            = trim($_POST['name'] ?? '');
$participantType = $_POST['participant_type'] ?? '';
$selectedCourse  = $_POST['course'] ?? '';
$interests       = $_POST['interests'] ?? [];

$errors   = [];
$adminFee = 25000;

// 1. Validasi Input
if (empty($name)) {
    $errors[] = 'Nama lengkap wajib diisi!';
}

if (empty($participantType)) {
    $errors[] = 'Tipe peserta wajib dipilih!';
}

if (empty($selectedCourse) || !array_key_exists($selectedCourse, $courses)) {
    $errors[] = 'Kursus yang dipilih tidak valid!';
}

// 2. Perhitungan jika tidak ada error
if (empty($errors)) {
    $courseTitle = $courses[$selectedCourse]['title'];
    $baseFee     = $courses[$selectedCourse]['price'];

    // Diskon berdasarkan Tipe Peserta
    if ($participantType === 'mahasiswa') {
        $discountPercent = 20;
    } elseif ($participantType === 'guru') {
        $discountPercent = 15;
    } else {
        $discountPercent = 0;
    }

    $discountAmount = intdiv($baseFee * $discountPercent, 100);
    $totalFee       = $baseFee - $discountAmount + $adminFee;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Pendaftaran - KursusKu</title>
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0f766e;
            --primary-hover: #0d625b;
            --primary-light: #ccfbf1;
            --accent: #f59e0b;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --success-bg: #f0fdf4;
            --radius: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .container {
            width: 100%;
            max-width: 680px;
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, var(--primary), #042f2e);
            color: white;
            padding: 32px 28px;
            text-align: center;
            position: relative;
        }

        .header-icon {
            font-size: 40px;
            margin-bottom: 12px;
            color: var(--primary-light);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .header p {
            color: #99f6e4;
            font-size: 14px;
            margin-top: 4px;
        }

        .content {
            padding: 28px;
        }

        /* Error Style */
        .error-card {
            background: var(--danger-bg);
            border: 1px solid #fca5a5;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .error-title {
            color: var(--danger);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .error-list {
            list-style: none;
            color: #991b1b;
            font-size: 14px;
        }

        .error-list li {
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Summary Details */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 24px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-main);
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            width: fit-content;
        }

        .badge-mahasiswa { background: #dbeafe; color: #1e40af; }
        .badge-guru { background: #fef3c7; color: #92400e; }
        .badge-umum { background: #f3f4f6; color: #374151; }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 4px;
        }

        .tag {
            background: var(--primary-light);
            color: var(--primary);
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Billing Table */
        .table-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text-main);
        }

        .billing-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .billing-table th {
            text-align: left;
            padding: 12px;
            background: #f1f5f9;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .billing-table td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }

        .billing-table tr:last-child td {
            border-bottom: none;
        }

        .discount-row {
            color: #059669;
            font-weight: 600;
        }

        .total-row {
            background: var(--primary-light);
            font-weight: 700;
            font-size: 16px;
        }

        .total-row td {
            color: var(--primary);
        }

        /* Actions */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border);
            margin-top: 10px;
        }

        .btn-outline:hover {
            background: #f1f5f9;
            color: var(--text-main);
        }

        @media (max-width: 480px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (!empty($errors)): ?>
        <!-- Tampilan Jika Terjadi Error -->
        <div class="header" style="background: linear-gradient(135deg, #ef4444, #991b1b);">
            <div class="header-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
            <h1>Pendaftaran Gagal</h1>
            <p>Silakan periksa kembali data yang Anda masukkan.</p>
        </div>
        <div class="content">
            <div class="error-card">
                <div class="error-title"><i class="fa-solid fa-triangle-exclamation"></i> Masalah Ditemukan:</div>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><i class="fa-solid fa-xmark"></i> <?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="registration-form.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Kembali ke Form</a>
        </div>

    <?php else: ?>
        <!-- Tampilan Jika Pendaftaran Sukses -->
        <div class="header">
            <div class="header-icon"><i class="fa-solid fa-circle-check"></i></div>
            <h1>Pendaftaran Berhasil!</h1>
            <p>Terima kasih telah mendaftar di KursusKu.</p>
        </div>

        <div class="content">
            <!-- Informasi Peserta -->
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Peserta</span>
                    <span class="info-value"><?= htmlspecialchars($name) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tipe Peserta</span>
                    <span class="badge badge-<?= $participantType ?>">
                        <?= ucfirst(htmlspecialchars($participantType)) ?>
                    </span>
                </div>
                <div class="info-item" style="grid-column: span 2;">
                    <span class="info-label">Minat Pembelajaran</span>
                    <div class="tag-container">
                        <?php if (!empty($interests)): ?>
                            <?php foreach ($interests as $interest): ?>
                                <span class="tag"><i class="fa-solid fa-check"></i> <?= htmlspecialchars($interest) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="info-value" style="color: var(--text-muted); font-style: italic; font-weight: normal;">Tidak memilih minat spesifik</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Rincian Pembayaran -->
            <div class="table-title"><i class="fa-solid fa-receipt"></i> Rincian Biaya</div>
            <table class="billing-table">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th style="text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($courseTitle) ?></strong><br>
                            <small style="color: var(--text-muted);">Biaya Standar Kursus</small>
                        </td>
                        <td style="text-align: right;">Rp <?= number_format($baseFee, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="discount-row">
                        <td>Diskon Tipe Peserta (<?= $discountPercent ?>%)</td>
                        <td style="text-align: right;">- Rp <?= number_format($discountAmount, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Biaya Administrasi</td>
                        <td style="text-align: right;">Rp <?= number_format($adminFee, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="total-row">
                        <td>Total Pembayaran</td>
                        <td style="text-align: right;">Rp <?= number_format($totalFee, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Tombol Aksi -->
            <a href="registration-form.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Daftar Kursus Lain</a>
            <a href="index.php" class="btn btn-outline"><i class="fa-solid fa-house"></i> Kembali ke Beranda</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>