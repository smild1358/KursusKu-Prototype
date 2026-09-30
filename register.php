<?php
require_once __DIR__ . '/data.php';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pertemuan 6 - Advanced Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; color: #0f172a; padding: 40px 20px; }
        .card { max-width: 650px; margin: auto; background: white; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; }
        h2 { color: #0f766e; margin-bottom: 20px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; }
        input[type="text"], input[type="email"], select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; }
        .options { display: flex; flex-direction: column; gap: 8px; font-weight: normal; font-size: 14px; }
        button { background: #0f766e; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: 700; width: 100%; cursor: pointer; }
    </style>
</head>
<body>

<div class="card">
    <h2>Form Pendaftaran Lanjutan (P6)</h2>
    <form action="process.php" method="POST">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <!-- Render Opsi Kursus dengan Loop[cite: 5] -->
        <div class="form-group">
            <label>Pilih Kursus</label>
            <select name="course_code" required>
                <option value="">-- Pilih Kursus --</option>
                <?php foreach ($coursesData as $code => $course): ?>
                    <option value="<?= $code ?>">
                        <?= $course['name'] ?> - Rp <?= number_format($course['fee'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Status Profesi (Diskon)</label>
            <select name="profession">
                <option value="mahasiswa">Mahasiswa (Diskon 20%)</option>
                <option value="guru">Guru (Diskon 15%)</option>
                <option value="umum">Umum (Diskon 0%)</option>
            </select>
        </div>

        <!-- Render Minat dengan Loop[cite: 5] -->
        <div class="form-group">
            <label>Peminatan Utama</label>
            <div class="options">
                <?php foreach ($interestsData as $key => $label): ?>
                    <label>
                        <input type="radio" name="interest" value="<?= $key ?>" required> <?= $label ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Render Fasilitas dengan Loop[cite: 5] -->
        <div class="form-group">
            <label>Fasilitas Tambahan</label>
            <div class="options">
                <?php foreach ($facilitiesData as $key => $fac): ?>
                    <label>
                        <input type="checkbox" name="facilities[]" value="<?= $key ?>">
                        <?= $fac['name'] ?> (+Rp <?= number_format($fac['fee'], 0, ',', '.') ?>)
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit">Proses Pendaftaran & Biaya</button>
    </form>
</div>

</body>
</html>