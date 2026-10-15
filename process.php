<?php
require_once __DIR__ . '/helpers.php';

// Memastikan data.php di-load untuk mengambil master data ($coursesData, $facilitiesData)
if (file_exists(__DIR__ . '/data.php')) {
    require_once __DIR__ . '/data.php';
}

// Hanya memproses request bertipe POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    die("Metode akses tidak diizinkan.");
}

// Menangkap data POST dengan trim() dan operator null coalescing (??)
$name            = trim($_POST['name'] ?? $_POST['nama'] ?? '');
$nama            = $name; // Kompatibilitas antar variabel nama
$email           = trim($_POST['email'] ?? '');
$telepon         = trim($_POST['telepon'] ?? '');
$courseCode      = trim($_POST['course_code'] ?? '');
$profession      = trim($_POST['profession'] ?? $_POST['status_pekerjaan'] ?? 'umum');
$statusPekerjaan = $profession; // Kompatibilitas antar variabel profesi/status
$interest        = trim($_POST['interest'] ?? '');
$selectedFacs    = $_POST['facilities'] ?? [];
$selectedFac     = $selectedFacs; // Kompatibilitas antar variabel fasilitas
$catatan         = trim($_POST['catatan'] ?? '-');
$learningMode    = trim($_POST['learning_mode'] ?? 'offline'); // Tangkap data mode pembelajaran (default: offline)

$errors = [];

// ==========================================
// VALIDASI INPUT P6
// ==========================================
if (empty($name)) {
    $errors[] = 'Nama lengkap wajib diisi.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Alamat email tidak valid.';
}

if (empty($courseCode) || !isset($coursesData[$courseCode])) {
    $errors[] = 'Silakan pilih program kursus yang valid.';
}

// ==========================================
// JIKA TERDAPAT ERROR VALIDASI (HTTP 400 Bad Request)
// ==========================================
if (!empty($errors)) {
    // Menetapkan HTTP Response Code 400 Bad Request
    http_response_code(400); 
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error Validasi (400 Bad Request) — KursusKu</title>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #f0fdf4;
                color: #0f172a;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                margin: 0;
            }
            .error-card {
                background: #ffffff;
                max-width: 500px;
                width: 100%;
                padding: 32px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(239, 68, 68, 0.1);
                border: 1px solid #fca5a5;
            }
            .error-header {
                display: flex;
                align-items: center;
                gap: 12px;
                color: #dc2626;
                margin-bottom: 20px;
            }
            .error-header i { font-size: 2rem; }
            .error-header h2 { font-size: 1.4rem; font-weight: 800; margin: 0; }
            .error-list {
                background: #fef2f2;
                border-radius: 12px;
                padding: 16px 20px;
                margin-bottom: 24px;
            }
            .error-list ul { margin: 0; padding-left: 20px; color: #991b1b; }
            .error-list li { margin-bottom: 6px; font-weight: 600; font-size: 0.95rem; }
            .btn-back {
                display: block;
                text-align: center;
                background: #0f766e;
                color: #ffffff;
                text-decoration: none;
                padding: 12px;
                border-radius: 10px;
                font-weight: 700;
                transition: background 0.2s;
            }
            .btn-back:hover { background: #0d625b; }
        </style>
    </head>
    <body>
        <div class="error-card">
            <div class="error-header">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>
                    <h2>Error Validasi (400)</h2>
                    <small style="color: #64748b;">Gagal memproses pendaftaran</small>
                </div>
            </div>
            <div class="error-list">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="javascript:history.back()" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Perbaiki Form
            </a>
        </div>
    </body>
    </html>
    <?php
    exit; // Hentikan eksekusi script
}

// ==========================================
// KALKULASI ARITMATIKA BIAYA & DISKON (HTTP 200 OK)
// ==========================================
http_response_code(200);

$selectedCourse     = $coursesData[$courseCode];
$selectedCourseData = $selectedCourse;
$baseFee            = $selectedCourse['fee'];
$basePrice          = $baseFee;

// Branching Diskon Berdasarkan Status Pekerjaan / Profesi
$discountRate    = 0;
$discountPercent = 0;

if ($profession === 'mahasiswa') {
    $discountRate    = 0.20; // 20%
    $discountPercent = 20;
} elseif ($profession === 'guru') {
    $discountRate    = 0.15; // 15%
    $discountPercent = 15;
} else {
    $discountRate    = 0.00; // 0%
    $discountPercent = 0;
}

$discountAmount     = intdiv($basePrice * $discountPercent, 100);
$feeAfterDiscount   = $baseFee - $discountAmount;
$priceAfterDiscount = $feeAfterDiscount;

// Hitung Tambahan Fasilitas dengan Loop
$facilityTotal = 0;
$facilityNames = [];

if (!empty($selectedFac) && is_array($selectedFac)) {
    foreach ($selectedFac as $facKey) {
        if (isset($facilitiesData[$facKey])) {
            $facilityTotal += $facilitiesData[$facKey]['fee'];
            $facilityNames[] = $facilitiesData[$facKey]['name'];
        }
    }
}

$grandTotal = $feeAfterDiscount + $facilityTotal;

// Masukkan data transaksi ke dalam array
$recordData = [
    'nama'             => $nama,
    'email'            => $email,
    'telepon'          => $telepon,
    'course_code'      => $courseCode,
    'course_name'      => $selectedCourseData['name'],
    'learning_mode'    => $learningMode,
    'base_price'       => $basePrice,
    'status_pekerjaan' => $statusPekerjaan,
    'discount_percent' => $discountPercent,
    'discount_amount'  => $discountAmount,
    'facilities'       => $facilityNames,
    'facility_total'   => $facilityTotal,
    'grand_total'      => $grandTotal,
    'source'           => 'Form P6'
];

// Simpan permanen ke Session & JSON via helpers.php (jika fungsi tersedia)
if (function_exists('saveRegistration')) {
    saveRegistration($recordData);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Pendaftaran — Pertemuan 6</title>
    
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

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: var(--bg-body);
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
            color: var(--text-dark);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container { max-width: 650px; margin: 0 auto; }

        .summary-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.08);
            border: 1px solid rgba(15, 118, 110, 0.1);
        }

        .header-box {
            text-align: center;
            border-bottom: 2px dashed var(--border);
            padding-bottom: 20px;
            margin-bottom: 24px;
        }

        .header-box i { font-size: 2.5rem; color: var(--primary); margin-bottom: 10px; }
        .header-box h1 { font-size: 1.6rem; font-weight: 800; }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .summary-table td, .summary-table th {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
            font-size: 0.95rem;
        }

        .summary-table th {
            color: var(--text-dark);
            font-weight: 700;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
        }

        .total-row {
            font-weight: 800;
            font-size: 16px;
            color: var(--primary-dark);
            background: var(--primary-light);
        }

        .total-row th, .total-row td {
            padding: 16px 12px;
            border-bottom: none;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            flex: 1;
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: #f1f5f9; color: var(--text-muted); }
        .btn-secondary:hover { background: #e2e8f0; }
    </style>
</head>
<body>

<div class="container">
    <div class="summary-card">
        <div class="header-box">
            <i class="fa-solid fa-circle-check"></i>
            <h1>Ringkasan Transaksi & Biaya</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Rincian pendaftaran Anda telah berhasil diproses.</p>
        </div>

        <table class="summary-table">
            <tr>
                <th>Nama Pendaftar</th>
                <td><?= htmlspecialchars($name) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($email) ?> <?= !empty($telepon) ? '(' . htmlspecialchars($telepon) . ')' : '' ?></td>
            </tr>
            <tr>
                <th>Program Kursus</th>
                <td><?= htmlspecialchars($selectedCourse['name']) ?> (<?= htmlspecialchars($courseCode) ?>)</td>
            </tr>
            <tr>
                <th>Mode Pembelajaran</th>
                <td>
                    <?php 
                    if (function_exists('getLearningModeLabel')) {
                        echo getLearningModeLabel($learningMode);
                    } else {
                        echo htmlspecialchars(ucfirst($learningMode));
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Biaya Dasar</th>
                <td class="mono">Rp <?= number_format($baseFee, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Status (Diskon)</th>
                <td><?= ucfirst(htmlspecialchars($profession)) ?> (<?= $discountRate * 100 ?>%)</td>
            </tr>
            <tr>
                <th>Potongan Diskon</th>
                <td class="mono" style="color: #ef4444;">- Rp <?= number_format($discountAmount, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Fasilitas Tambahan</th>
                <td>
                    <?= !empty($facilityNames) ? htmlspecialchars(implode(', ', $facilityNames)) : 'Tidak Ada' ?>
                    <span class="mono">(+Rp <?= number_format($facilityTotal, 0, ',', '.') ?>)</span>
                </td>
            </tr>
            <tr class="total-row">
                <th>Total Pembayaran</th>
                <td class="mono" style="font-size: 1.2rem;">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
            </tr>
        </table>

        <div class="btn-group">
            <a href="register.php" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Pendaftaran Baru</a>
            <a href="history.php" class="btn btn-secondary"><i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat</a>
        </div>
    </div>
</div>

</body>
</html>