<?php
require_once __DIR__ . '/data.php';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pertemuan 6 - Advanced Registration</title>

    <!-- Google Fonts & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #0f766e;
            --primary-hover: #0d625b;
            --primary-light: #ccfbf1;
            --bg-body: #f0fdf4;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #cbd5e1;
            --focus-ring: rgba(15, 118, 110, 0.15);
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
            max-width: 680px;
            margin: auto;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 36px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.06);
        }

        .header-card {
            text-align: center;
            margin-bottom: 28px;
            border-bottom: 2px dashed #e2e8f0;
            padding-bottom: 20px;
        }

        .header-card i {
            font-size: 2.2rem;
            color: var(--primary);
            background: var(--primary-light);
            padding: 14px;
            border-radius: 16px;
            margin-bottom: 12px;
            display: inline-block;
        }

        .header-card h2 {
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.5rem;
        }

        .header-card p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label.form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        label.form-label i {
            color: var(--primary);
        }

        input[type="text"], 
        input[type="email"], 
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--text-dark);
            background-color: #fff;
            outline: none;
            transition: all 0.2s ease;
        }

        input[type="text"]:focus, 
        input[type="email"]:focus, 
        select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--focus-ring);
        }

        /* Option Grid Cards */
        .grid-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }

        .custom-option-card {
            position: relative;
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .custom-option-card:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .custom-option-card input[type="radio"],
        .custom-option-card input[type="checkbox"] {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
        }

        .package-badge {
            font-family: 'JetBrains Mono', monospace;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            margin-left: auto;
        }

        .options-vertical {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        button.btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
        }

        button.btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="header-card">
            <i class="fa-solid fa-user-plus"></i>
            <h2>Form Pendaftaran Lanjutan (P6)</h2>
            <p>Isi formulir pendaftaran kursus dan fasilitas tambahan di bawah ini.</p>
        </div>

        <form action="process.php" method="POST">
            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-user"></i> Nama Lengkap</label>
                <input type="text" name="name" placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-envelope"></i> Alamat Email</label>
                <input type="email" name="email" placeholder="contoh@domain.com" required>
            </div>

            <!-- Render Opsi Kursus dengan Loop -->
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-graduation-cap"></i> Pilih Kursus</label>
                <select name="course_code" required>
                    <option value="">-- Pilih Program Kursus --</option>
                    <?php foreach ($coursesData as $code => $course): ?>
                        <option value="<?= htmlspecialchars($code) ?>">
                            <?= htmlspecialchars($course['name']) ?> - Rp <?= number_format($course['fee'], 0, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- OPSI BARU: Perulangan Loop FOR ($i = 1; $i <= 3; $i++) Untuk Jumlah Paket -->
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-cubes"></i> Pilih Jumlah Paket Kursus</label>
                <div class="grid-options">
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                        <label class="custom-option-card">
                            <input type="radio" name="package_count" value="<?= $i ?>" <?= $i === 1 ? 'checked' : '' ?> required>
                            <span><?= $i ?> Paket</span>
                            <span class="package-badge"><?= $i ?>x Modul</span>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Status Profesi -->
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-briefcase"></i> Status Profesi (Diskon)</label>
                <select name="profession">
                    <option value="mahasiswa">Mahasiswa (Diskon 20%)</option>
                    <option value="guru">Guru (Diskon 15%)</option>
                    <option value="umum">Umum (Diskon 0%)</option>
                </select>
            </div>

            <!-- Render Minat dengan Loop -->
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-compass"></i> Peminatan Utama</label>
                <div class="options-vertical">
                    <?php foreach ($interestsData as $key => $label): ?>
                        <label class="custom-option-card">
                            <input type="radio" name="interest" value="<?= htmlspecialchars($key) ?>" required>
                            <span><?= htmlspecialchars($label) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Render Fasilitas dengan Loop -->
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-boxes-stacked"></i> Fasilitas Tambahan</label>
                <div class="options-vertical">
                    <?php foreach ($facilitiesData as $key => $fac): ?>
                        <label class="custom-option-card">
                            <input type="checkbox" name="facilities[]" value="<?= htmlspecialchars($key) ?>">
                            <span><?= htmlspecialchars($fac['name']) ?></span>
                            <span style="margin-left: auto; font-family: 'JetBrains Mono', monospace; color: var(--primary); font-size: 0.85rem;">
                                +Rp <?= number_format($fac['fee'], 0, ',', '.') ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Proses Pendaftaran & Biaya
            </button>
        </form>

        <a href="index.php" class="back-link">&larr; Kembali ke Beranda Utama</a>
    </div>
</div>

</body>
</html>