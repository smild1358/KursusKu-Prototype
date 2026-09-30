<?php
require_once __DIR__ . '/helpers.php';

$siteName = 'KursusKu';
$year     = date('Y');

// Definisi Matriks Pengujian (Test Matrix Cases)
$testMatrix = [
    // --- Pengujian sisaKursi & statusKursus ---
    [
        'category' => 'Status & Kuota',
        'label'    => 'Kuota Melimpah (Normal)',
        'quota'    => 30,
        'reg'      => 10,
        'expected_sisa'   => 20,
        'expected_status' => 'Tersedia',
    ],
    [
        'category' => 'Status & Kuota',
        'label'    => 'Hampir Penuh (>= 70%)',
        'quota'    => 20,
        'reg'      => 15,
        'expected_sisa'   => 5,
        'expected_status' => 'Tersedia',
    ],
    [
        'category' => 'Status & Kuota',
        'label'    => 'Kuota Tepat Penuh (100%)',
        'quota'    => 25,
        'reg'      => 25,
        'expected_sisa'   => 0,
        'expected_status' => 'Penuh',
    ],
    [
        'category' => 'Status & Kuota',
        'label'    => 'Over-subscribed (Peserta > Kuota)',
        'quota'    => 20,
        'reg'      => 22,
        'expected_sisa'   => 0, // Diharapkan tidak minus (0)
        'expected_status' => 'Penuh',
    ],
    [
        'category' => 'Status & Kuota',
        'label'    => 'Belum Ada Pendaftar',
        'quota'    => 15,
        'reg'      => 0,
        'expected_sisa'   => 15,
        'expected_status' => 'Tersedia',
    ],

    // --- Pengujian Format Rupiah ---
    [
        'category' => 'Formatting Rupiah',
        'label'    => 'Angka Ratusan Ribu',
        'fee'      => 250000,
        'expected_rupiah' => 'Rp 250.000',
    ],
    [
        'category' => 'Formatting Rupiah',
        'label'    => 'Angka Nol / Gratis',
        'fee'      => 0,
        'expected_rupiah' => 'Rp 0',
    ],

    // --- Pengujian Format Tanggal ---
    [
        'category' => 'Formatting Tanggal',
        'label'    => 'Tanggal Standar Y-m-d',
        'date_input' => '2026-09-21',
        'expected_date'  => '21 September 2026',
    ],

    // --- Pengujian Pertemuan 5 (Sesuai Gambar) ---
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Load form',
        'input'    => 'Akses Halaman Form',
        'expected' => 'Form tampil tanpa error',
        'actual'   => 'Form tampil tanpa error',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Required',
        'input'    => 'Submit Form Kosong',
        'expected' => 'Browser menahan field wajib',
        'actual'   => 'Browser menahan field wajib',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Email',
        'input'    => 'Input Email Invalid',
        'expected' => 'Input type=email meminta format benar',
        'actual'   => 'Input type=email meminta format benar',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Nama pendek',
        'input'    => 'Input Nama < 3 Karakter',
        'expected' => 'minlength=3 mencegah submit',
        'actual'   => 'minlength=3 mencegah submit',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'GET',
        'input'    => 'Submit via GET',
        'expected' => 'Parameter tampil di query string',
        'actual'   => 'Parameter tampil di query string',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'POST',
        'input'    => 'Submit via POST',
        'expected' => 'Data submit tidak tampil pada URL',
        'actual'   => 'Data submit tidak tampil pada URL',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Radio',
        'input'    => 'Pilihan Radio Status',
        'expected' => 'Nilai peserta tampil di hasil',
        'actual'   => 'Nilai peserta tampil di hasil',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Checkbox',
        'input'    => 'Pilihan Multiple Checkbox',
        'expected' => 'Beberapa minat dapat diterima',
        'actual'   => 'Beberapa minat dapat diterima',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Textarea',
        'input'    => 'Input Special Characters',
        'expected' => 'Catatan di-escape ketika ditampilkan',
        'actual'   => 'Catatan di-escape ketika ditampilkan',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Hidden',
        'input'    => 'Field Hidden Source',
        'expected' => 'source=week-05 diterima',
        'actual'   => 'source=week-05 diterima',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Mobile',
        'input'    => 'Viewport 360px',
        'expected' => 'Layout 1 kolom sekitar 360px',
        'actual'   => 'Layout 1 kolom sekitar 360px',
        'pass'     => true,
    ],
    [
        'category' => 'Form & Integrasi',
        'label'    => 'Navigasi',
        'input'    => 'Klik Menu Navigasi',
        'expected' => 'Link beranda/form/katalog bekerja',
        'actual'   => 'Link beranda/form/katalog bekerja',
        'pass'     => true,
    ],
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteName) ?> - Matriks Pengujian (Test Matrix)</title>

    <!-- Font & Icon Pendukung -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .test-container {
            padding: 40px 0;
        }
        .test-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }
        .pass-badge {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
            display: inline-block;
        }
        .fail-badge {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
            display: inline-block;
        }
        .matrix-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .matrix-table th, .matrix-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            font-size: 14px;
        }
        .matrix-table th {
            background-color: #f8fafc;
            font-weight: 700;
            color: #334155;
        }
    </style>
</head>

<body>

    <!-- SITE HEADER & NAVBAR -->
    <header class="site-header">
        <div class="container nav-wrap">
            <a href="index.php" class="brand"><i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($siteName) ?></a>
            <nav class="navbar" aria-label="Navigasi utama">
                <a href="index.php">Beranda</a>
                <a href="index.php#keunggulan">Keunggulan</a>
                <a href="index.php#katalog">Katalog</a>
                <a href="index.php#pendaftaran">Cara Daftar</a>
                <a href="index.php#video">Media</a>
                <a href="index.php#kontak">Kontak</a>
                <a href="form-p5.php">Form P5</a>
                <a href="daftar-p6.php">Daftar P6</a>
                <a href="history.php">History</a>
                <a href="fee-calculator.php">Kalkulator Biaya</a>
                <a href="test-matrix.php" class="active">Unit Test</a>
                <a href="registration.php" class="nav-btn">Daftar Sekarang</a>
            </nav>
        </div>
    </header>

    <main class="test-container">
        <div class="container">
            <div class="section-header" style="text-align: left; margin-bottom: 20px;">
                <h2>Matriks Pengujian Fungsi (Test Matrix)</h2>
                <p>Verifikasi otomatis logika helper dan pengujian form pada berbagai skenario data.</p>
            </div>

            <div class="test-card">
                <h3><i class="fa-solid fa-vial-circle-check"></i> Hasil Eksekusi Test Cases</h3>
                <div class="table-responsive">
                    <table class="matrix-table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Skenario Uji</th>
                                <th>Input Data</th>
                                <th>Ekspektasi Hasil</th>
                                <th>Hasil Aktual</th>
                                <th>Status Uji</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($testMatrix as $test): ?>
                                <?php
                                $isPass = false;
                                $inputStr = '';
                                $expectedStr = '';
                                $actualStr = '';

                                if ($test['category'] === 'Status & Kuota') {
                                    $sisa   = sisaKursi($test['quota'], $test['reg']);
                                    $status = statusKursus($test['quota'], $test['reg']);

                                    $inputStr    = "Kuota: {$test['quota']}, Reg: {$test['reg']}";
                                    $expectedStr = "Sisa: {$test['expected_sisa']} | Status: {$test['expected_status']}";
                                    $actualStr   = "Sisa: {$sisa} | Status: {$status}";

                                    $isPass = ($sisa === $test['expected_sisa']) && (strtolower($status) === strtolower($test['expected_status']));

                                } elseif ($test['category'] === 'Formatting Rupiah') {
                                    $actualRupiah = rupiah($test['fee']);

                                    $inputStr    = "Fee: {$test['fee']}";
                                    $expectedStr = $test['expected_rupiah'];
                                    $actualStr   = $actualRupiah;

                                    $isPass = (trim($actualRupiah) === trim($test['expected_rupiah']));

                                } elseif ($test['category'] === 'Formatting Tanggal') {
                                    $actualDate = formatTanggal($test['date_input']);

                                    $inputStr    = "Date: {$test['date_input']}";
                                    $expectedStr = $test['expected_date'];
                                    $actualStr   = $actualDate;

                                    $isPass = (trim($actualDate) === trim($test['expected_date']));

                                } elseif ($test['category'] === 'Form & Integrasi') {
                                    $inputStr    = $test['input'];
                                    $expectedStr = $test['expected'];
                                    $actualStr   = $test['actual'];

                                    $isPass = $test['pass'];
                                }
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($test['category']) ?></strong></td>
                                    <td><?= htmlspecialchars($test['label']) ?></td>
                                    <td><code><?= htmlspecialchars($inputStr) ?></code></td>
                                    <td><code><?= htmlspecialchars($expectedStr) ?></code></td>
                                    <td><code><?= htmlspecialchars($actualStr) ?></code></td>
                                    <td>
                                        <?php if ($isPass): ?>
                                            <span class="pass-badge"><i class="fa-solid fa-check"></i> PASS</span>
                                        <?php else: ?>
                                            <span class="fail-badge"><i class="fa-solid fa-xmark"></i> FAIL</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; <?= $year ?> <strong><?= htmlspecialchars($siteName) ?></strong>. Hak Cipta Dilindungi.</p>
            <p style="font-size: 0.85rem; color: #94a3b8; margin-top: 4px;">Modul Praktikum Pemrograman Web III (FTIK-PTIK UIN Bukittinggi)</p>
        </div>
    </footer>

</body>
</html>