<?php
// Inisialisasi variabel untuk input dan error
$selectedCourse = '';
$paymentMethod  = '';
$errors         = [];
$submitted      = false;

// Data Tarif Dasar Kursus (Array)
$courses = [
    'web_dasar' => ['title' => 'Web Dasar', 'price' => 300000],
    'php_dasar' => ['title' => 'PHP Dasar', 'price' => 350000],
    'laravel'   => ['title' => 'Laravel Fundamental', 'price' => 500000],
    'react_js'  => ['title' => 'React JS Mastery', 'price' => 450000]
];

// Data Diskon Metode Pembayaran
$paymentDiscounts = [
    'transfer' => ['label' => 'Transfer Bank (Diskon 5%)', 'discount' => 5],
    'ewallet'  => ['label' => 'E-Wallet (Diskon 2%)', 'discount' => 2],
    'tunai'    => ['label' => 'Tunai / Cash (Tanpa Diskon)', 'discount' => 0]
];

// Variabel Hasil Perhitungan
$courseTitle     = '';
$baseFee         = 0;
$discountPercent = 0;
$discountAmount  = 0;
$adminFee        = 25000;
$totalFee        = 0;

// Memproses Request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedCourse = $_POST['course'] ?? '';
    $paymentMethod  = $_POST['payment_method'] ?? '';

    // Validasi Pilihan Kursus
    if (empty($selectedCourse) || !array_key_exists($selectedCourse, $courses)) {
        $errors[] = 'Silakan pilih kursus yang valid.';
    }

    // Validasi Metode Pembayaran
    if (empty($paymentMethod) || !array_key_exists($paymentMethod, $paymentDiscounts)) {
        $errors[] = 'Silakan pilih metode pembayaran yang valid.';
    }

    // Jika tidak ada error, lakukan kalkulasi
    if (empty($errors)) {
        $submitted       = true;
        $courseTitle     = $courses[$selectedCourse]['title'];
        $baseFee         = $courses[$selectedCourse]['price'];
        $discountPercent = $paymentDiscounts[$paymentMethod]['discount'];

        // Hitung Potongan Diskon dan Total
        $discountAmount  = intdiv($baseFee * $discountPercent, 100);
        $totalFee        = $baseFee - $discountAmount + $adminFee;
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalkulator Biaya Kursus - KursusKu</title>
    <style>
        :root {
            --primary: #0f766e;
            --primary-hover: #0d625b;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text-main: #0f172a;
            --danger-bg: #fef2f2;
            --danger-border: #fca5a5;
            --danger-text: #991b1b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--bg); color: var(--text-main); padding: 30px 15px; }
        .card { max-width: 550px; margin: auto; background: var(--card-bg); padding: 28px; border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h2 { margin-bottom: 20px; color: var(--primary); font-size: 22px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; }
        select { width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; font-size: 14px; background-color: #fff; }
        .error-box { background: var(--danger-bg); border: 1px solid var(--danger-border); color: var(--danger-text); padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .error-box ul { margin-left: 20px; }
        .summary-box { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 20px; border-radius: 8px; margin-top: 24px; }
        .summary-box h3 { color: #166534; font-size: 18px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 10px 8px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f9fafb; font-weight: 600; }
        .total-row { font-weight: bold; background: #dcfce7; color: #14532d; }
        button { background: var(--primary); color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: 600; width: 100%; transition: background 0.2s; }
        button:hover { background: var(--primary-hover); }
        a { color: var(--primary); text-decoration: none; font-size: 14px; display: inline-block; margin-top: 16px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<main class="card">
    <h2>Kalkulator Biaya Kursus</h2>

    <!-- Pesan Error Validasi -->
    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form Input Kalkulator -->
    <form method="POST" action="fee-calculator.php">
        <div class="form-group">
            <label for="course">Pilih Kursus:</label>
            <select id="course" name="course">
                <option value="">-- Pilih Kursus --</option>
                <?php foreach ($courses as $key => $course): ?>
                    <option value="<?= $key ?>" <?= $selectedCourse === $key ? 'selected' : '' ?>>
                        <?= htmlspecialchars($course['title']) ?> - Rp <?= number_format($course['price'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="payment_method">Metode Pembayaran:</label>
            <select id="payment_method" name="payment_method">
                <option value="">-- Pilih Metode Pembayaran --</option>
                <?php foreach ($paymentDiscounts as $key => $method): ?>
                    <option value="<?= $key ?>" <?= $paymentMethod === $key ? 'selected' : '' ?>>
                        <?= htmlspecialchars($method['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Hitung Total Biaya</button>
    </form>

    <!-- Hasil Perhitungan Biaya -->
    <?php if ($submitted): ?>
        <section class="summary-box">
            <h3>Rincian Perhitungan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Komponen</th>
                        <th style="text-align: right;">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Biaya Kursus (<?= htmlspecialchars($courseTitle) ?>)</td>
                        <td style="text-align: right;">Rp <?= number_format($baseFee, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Diskon Pembayaran (<?= $discountPercent ?>%)</td>
                        <td style="text-align: right;">- Rp <?= number_format($discountAmount, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Biaya Administrasi</td>
                        <td style="text-align: right;">Rp <?= number_format($adminFee, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="total-row">
                        <td>Total yang Harus Dibayar</td>
                        <td style="text-align: right;">Rp <?= number_format($totalFee, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </section>
    <?php endif; ?>

    <a href="index.php">&larr; Kembali ke Beranda</a>
</main>

</body>
</html>
