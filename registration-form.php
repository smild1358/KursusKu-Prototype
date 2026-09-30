<?php
// Data Daftar Kursus (Array multidimensi)
$courses = [
    'web_dasar' => ['title' => 'Web Dasar', 'price' => 300000],
    'php_dasar' => ['title' => 'PHP Dasar', 'price' => 350000],
    'laravel'   => ['title' => 'Laravel Fundamental', 'price' => 500000],
    'react_js'  => ['title' => 'React JS Mastery', 'price' => 450000]
];

// Inisialisasi variabel input & error
$name            = '';
$participantType = '';
$selectedCourse  = '';
$interests       = [];
$errors          = [];
$submitted       = false;

// Variabel hasil perhitungan
$courseTitle     = '';
$baseFee         = 0;
$discountPercent = 0;
$discountAmount  = 0;
$adminFee        = 25000;
$totalFee        = 0;

// Memproses Request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Tangkap Input
    $name            = trim($_POST['name'] ?? '');
    $participantType = $_POST['participant_type'] ?? '';
    $selectedCourse  = $_POST['course'] ?? '';
    $interests       = $_POST['interests'] ?? [];

    // 2. Validasi Input
    if (empty($name)) {
        $errors[] = 'Nama lengkap wajib diisi!';
    }

    if (empty($participantType)) {
        $errors[] = 'Tipe peserta wajib dipilih!';
    }

    if (empty($selectedCourse) || !array_key_exists($selectedCourse, $courses)) {
        $errors[] = 'Kursus yang dipilih tidak valid!';
    }

    // 3. Jika Tidak Ada Error, Lakukan Perhitungan
    if (empty($errors)) {
        $submitted   = true;
        $courseTitle = $courses[$selectedCourse]['title'];
        $baseFee     = $courses[$selectedCourse]['price'];

        // Terapkan Diskon berdasarkan participant_type
        if ($participantType === 'mahasiswa') {
            $discountPercent = 20;
        } elseif ($participantType === 'guru') {
            $discountPercent = 15;
        } else {
            $discountPercent = 0; // Tipe 'umum'
        }

        // Proses Aritmatika
        $discountAmount = intdiv($baseFee * $discountPercent, 100);
        $totalFee       = $baseFee - $discountAmount + $adminFee;
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Kursus - KursusKu</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 20px; color: #333; }
        .card { max-width: 650px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
        input[type="text"], select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .radio-group, .checkbox-group { display: flex; gap: 15px; flex-wrap: wrap; }
        .error-box { background: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; }
        .summary-box { background: #e8f4ea; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #ddd; padding: 8px; text-align: left; }
        button { background: #0f766e; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0d625b; }
        a { color: #0f766e; text-decoration: none; }
    </style>
</head>
<body>

<main class="card">
    <h2>Form Pendaftaran KursusKu</h2>

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

    <!-- Form Input Pendaftaran -->
    <form method="POST" action="registration-form.php">
        <!-- 1. Nama Peserta -->
        <div class="form-group">
            <label for="name">Nama Lengkap:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Masukkan nama Anda">
        </div>

        <!-- 2. Tipe Peserta (Radio Button) -->
        <div class="form-group">
            <label>Tipe Peserta:</label>
            <div class="radio-group">
                <label><input type="radio" name="participant_type" value="mahasiswa" <?= $participantType === 'mahasiswa' ? 'checked' : '' ?>> Mahasiswa (Diskon 20%)</label>
                <label><input type="radio" name="participant_type" value="guru" <?= $participantType === 'guru' ? 'checked' : '' ?>> Guru (Diskon 15%)</label>
                <label><input type="radio" name="participant_type" value="umum" <?= $participantType === 'umum' ? 'checked' : '' ?>> Umum (Diskon 0%)</label>
            </div>
        </div>

        <!-- 3. Pilihan Kursus (Looping Array) -->
        <div class="form-group">
            <label for="course">Pilih Kursus:</label>
            <select id="course" name="course">
                <option value="">-- Pilih Kursus --</option>
                <?php foreach ($courses as $key => $course): ?>
                    <option value="<?= $key ?>" <?= $selectedCourse === $key ? 'selected' : '' ?>>
                        <?= $course['title'] ?> - Rp <?= number_format($course['price'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- 4. Minat Pembelajaran (Checkbox Array) -->
        <div class="form-group">
            <label>Minat Materi Tambahan (Optional):</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="interests[]" value="Frontend" <?= in_array('Frontend', $interests) ? 'checked' : '' ?>> Frontend</label>
                <label><input type="checkbox" name="interests[]" value="Backend" <?= in_array('Backend', $interests) ? 'checked' : '' ?>> Backend</label>
                <label><input type="checkbox" name="interests[]" value="Database" <?= in_array('Database', $interests) ? 'checked' : '' ?>> Database</label>
                <label><input type="checkbox" name="interests[]" value="DevOps" <?= in_array('DevOps', $interests) ? 'checked' : '' ?>> DevOps</label>
            </div>
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>

    <!-- 5. Tampilkan Ringkasan Pendaftaran Jika Valid -->
    <?php if ($submitted): ?>
        <div class="summary-box">
            <h3>Ringkasan Pendaftaran</h3>
            <p><strong>Nama:</strong> <?= htmlspecialchars($name) ?></p>
            <p><strong>Tipe Peserta:</strong> <?= ucfirst(htmlspecialchars($participantType)) ?></p>
            <p><strong>Minat:</strong> 
                <?= !empty($interests) ? htmlspecialchars(implode(', ', $interests)) : '<em>Tidak ada minat khusus dipilih</em>' ?>
            </p>

            <table>
                <tr><th>Rincian Biaya</th><th>Nilai</th></tr>
                <tr><td>Kursus (<?= htmlspecialchars($courseTitle) ?>)</td><td>Rp <?= number_format($baseFee, 0, ',', '.') ?></td></tr>
                <tr><td>Diskon (<?= $discountPercent ?>%)</td><td>- Rp <?= number_format($discountAmount, 0, ',', '.') ?></td></tr>
                <tr><td>Biaya Admin</td><td>Rp <?= number_format($adminFee, 0, ',', '.') ?></td></tr>
                <tr style="font-weight: bold; background: #d4edda;">
                    <td>Total Bayar</td>
                    <td>Rp <?= number_format($totalFee, 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>

    <p style="margin-top:20px;"><a href="index.php">&larr; Kembali ke Beranda KursusKu</a></p>
</main>

</body>
</html>