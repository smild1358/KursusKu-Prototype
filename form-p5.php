<?php
require_once __DIR__ . '/helpers.php';

$siteName = 'KursusKu';
$year     = date('Y');

// Inisialisasi variabel
$isSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');
$errors      = [];
$formData    = [];

if ($isSubmitted) {
    // Sanitasi dan Pengambilan Data Form P5
    $nama        = trim($_POST['nama'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $telepon     = trim($_POST['telepon'] ?? '');
    $kursus      = $_POST['kursus'] ?? '';
    $level       = $_POST['level'] ?? 'pemula';
    $jadwal      = $_POST['jadwal'] ?? 'reguler';
    $catatan     = trim($_POST['catatan'] ?? '');
    $sumber      = $_POST['sumber'] ?? 'week-05';

    // Validasi Sederhana
    if (empty($nama) || strlen($nama) < 3) {
        $errors[] = "Nama lengkap minimal terdiri dari 3 karakter.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format alamat email tidak valid.";
    }
    if (empty($kursus)) {
        $errors[] = "Silakan pilih salah satu program kursus.";
    }

    if (empty($errors)) {
        $formData = [
            'nama'    => htmlspecialchars($nama),
            'email'   => htmlspecialchars($email),
            'telepon' => htmlspecialchars($telepon),
            'kursus'  => htmlspecialchars($kursus),
            'level'   => htmlspecialchars($level),
            'jadwal'  => htmlspecialchars($jadwal),
            'catatan' => htmlspecialchars($catatan),
            'sumber'  => htmlspecialchars($sumber),
            'waktu'   => date('d F Y, H:i') . ' WIB'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteName) ?> - Pendaftaran Form P5</title>

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- External CSS (Memuat style utama proyek) -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --primary-grad: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --accent-grad: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            --bg-glass: rgba(255, 255, 255, 0.85);
            --border-glass: rgba(226, 232, 240, 0.8);
        }

        body {
            background: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.08) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .p5-hero-header {
            text-align: center;
            max-width: 680px;
            margin: 0 auto 35px;
        }

        .p5-hero-header .badge-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .p5-hero-header h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 10px;
        }

        .p5-hero-header p {
            color: #64748b;
            font-size: 1rem;
        }

        .p5-layout-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .p5-layout-grid {
                grid-template-columns: 1fr;
            }
        }

        .glass-card {
            background: var(--bg-glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
        }

        .form-section-title i {
            color: #6366f1;
        }

        .form-group-custom {
            margin-bottom: 20px;
        }

        .form-group-custom label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .input-icon-wrapper input,
        .input-icon-wrapper select,
        .input-icon-wrapper textarea {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #ffffff;
            color: #0f172a;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .input-icon-wrapper textarea {
            padding-left: 14px;
            resize: vertical;
            min-height: 100px;
        }

        .input-icon-wrapper input:focus,
        .input-icon-wrapper select:focus,
        .input-icon-wrapper textarea:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .input-icon-wrapper input:focus + i,
        .input-icon-wrapper select:focus + i {
            color: #6366f1;
        }

        /* Radio Card Selection */
        .radio-options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 12px;
        }

        .radio-card-option {
            position: relative;
        }

        .radio-card-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .radio-card-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 14px 10px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s ease;
        }

        .radio-card-label i {
            font-size: 1.3rem;
            color: #64748b;
            margin-bottom: 6px;
        }

        .radio-card-label span {
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
        }

        .radio-card-option input[type="radio"]:checked + .radio-card-label {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }

        .radio-card-option input[type="radio"]:checked + .radio-card-label i,
        .radio-card-option input[type="radio"]:checked + .radio-card-label span {
            color: #4f46e5;
        }

        /* Submit Button */
        .btn-gradient-submit {
            width: 100%;
            padding: 14px;
            background: var(--primary-grad);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-gradient-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5);
        }

        /* Result Live Card */
        .summary-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.9rem;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item .label {
            color: #64748b;
        }

        .summary-item .value {
            font-weight: 600;
            color: #0f172a;
        }

        .price-tag-box {
            background: rgba(99, 102, 241, 0.08);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin-top: 15px;
        }

        .price-tag-box .amount {
            font-size: 1.6rem;
            font-weight: 800;
            color: #4f46e5;
        }

        .alert-box {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
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
                <a href="form-p5.php" class="active">Form P5</a>
                <a href="daftar-p6.php">Daftar P6</a>
                <a href="history.php">History</a>
                <a href="fee-calculator.php">Kalkulator Biaya</a>
                <a href="test-matrix.php">Unit Test</a>
                <a href="registration.php" class="nav-btn">Daftar Sekarang</a>
            </nav>
        </div>
    </header>

    <main class="container" style="padding: 40px 0 60px;">
        
        <div class="p5-hero-header">
            <span class="badge-tag"><i class="fa-solid fa-sparkles"></i> Praktikum Pertemuan 5</span>
            <h2>Form Pendaftaran Interaktif</h2>
            <p>Pilih kelas impianmu, atur jadwal kustom, dan mulai perjalanan karir digitalmu sekarang.</p>
        </div>

        <div class="p5-layout-grid">
            
            <!-- FORMULIR INPUT -->
            <div class="glass-card">
                
                <?php if (!empty($errors)): ?>
                    <div class="alert-box alert-error">
                        <strong><i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan:</strong>
                        <ul style="margin-left: 20px; margin-top: 6px;">
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="form-p5.php" method="POST" id="formP5">
                    
                    <!-- Hidden Input Sesuai Modul P5 -->
                    <input type="hidden" name="sumber" value="week-05">

                    <!-- SEKSI 1: BIODATA -->
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-gear"></i> Informasi Pendaftar
                    </div>

                    <div class="form-group-custom">
                        <label for="nama">Nama Lengkap *</label>
                        <div class="input-icon-wrapper">
                            <input type="text" id="nama" name="nama" placeholder="Contoh: Alex Rian" minlength="3" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                            <i class="fa-regular fa-user"></i>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group-custom">
                            <label for="email">Alamat Email *</label>
                            <div class="input-icon-wrapper">
                                <input type="email" id="email" name="email" placeholder="nama@email.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label for="telepon">Nomor WhatsApp</label>
                            <div class="input-icon-wrapper">
                                <input type="tel" id="telepon" name="telepon" placeholder="081234567890" value="<?= htmlspecialchars($_POST['telepon'] ?? '') ?>">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                        </div>
                    </div>

                    <!-- SEKSI 2: PROGRAM KURSUS -->
                    <div class="form-section-title" style="margin-top: 25px;">
                        <i class="fa-solid fa-laptop-code"></i> Pilihan Program & Tingkat
                    </div>

                    <div class="form-group-custom">
                        <label for="kursus">Pilih Program Kursus *</label>
                        <div class="input-icon-wrapper">
                            <select id="kursus" name="kursus" required onchange="calculateEstimate()">
                                <option value="" disabled selected>-- Pilih Program Kursus --</option>
                                <option value="Web Development" <?= (($_POST['kursus'] ?? '') === 'Web Development') ? 'selected' : '' ?>>Web Development (HTML, CSS, PHP)</option>
                                <option value="UI/UX Design" <?= (($_POST['kursus'] ?? '') === 'UI/UX Design') ? 'selected' : '' ?>>UI/UX Design & Prototyping</option>
                                <option value="Data Science" <?= (($_POST['kursus'] ?? '') === 'Data Science') ? 'selected' : '' ?>>Data Science & Machine Learning</option>
                                <option value="Cyber Security" <?= (($_POST['kursus'] ?? '') === 'Cyber Security') ? 'selected' : '' ?>>Cyber Security Fundamental</option>
                            </select>
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Tingkat Pengalaman (Level)</label>
                        <div class="radio-options-grid">
                            <div class="radio-card-option">
                                <input type="radio" id="lvl_pemula" name="level" value="pemula" <?= (($_POST['level'] ?? 'pemula') === 'pemula') ? 'checked' : '' ?> onchange="calculateEstimate()">
                                <label for="lvl_pemula" class="radio-card-label">
                                    <i class="fa-solid fa-seedling"></i>
                                    <span>Pemula</span>
                                </label>
                            </div>
                            <div class="radio-card-option">
                                <input type="radio" id="lvl_menengah" name="level" value="menengah" <?= (($_POST['level'] ?? '') === 'menengah') ? 'checked' : '' ?> onchange="calculateEstimate()">
                                <label for="lvl_menengah" class="radio-card-label">
                                    <i class="fa-solid fa-chart-line"></i>
                                    <span>Menengah</span>
                                </label>
                            </div>
                            <div class="radio-card-option">
                                <input type="radio" id="lvl_mahif" name="level" value="mahir" <?= (($_POST['level'] ?? '') === 'mahir') ? 'checked' : '' ?> onchange="calculateEstimate()">
                                <label for="lvl_mahif" class="radio-card-label">
                                    <i class="fa-solid fa-rocket"></i>
                                    <span>Lanjutan</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Pilihan Waktu Belajar</label>
                        <div class="radio-options-grid">
                            <div class="radio-card-option">
                                <input type="radio" id="jdw_reguler" name="jadwal" value="reguler" <?= (($_POST['jadwal'] ?? 'reguler') === 'reguler') ? 'checked' : '' ?>>
                                <label for="jdw_reguler" class="radio-card-label">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <span>Hari Kerja</span>
                                </label>
                            </div>
                            <div class="radio-card-option">
                                <input type="radio" id="jdw_weekend" name="jadwal" value="weekend" <?= (($_POST['jadwal'] ?? '') === 'weekend') ? 'checked' : '' ?>>
                                <label for="jdw_weekend" class="radio-card-label">
                                    <i class="fa-solid fa-mug-hot"></i>
                                    <span>Akhir Pekan</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label for="catatan">Catatan / Ekspektasi (Opsional)</label>
                        <div class="input-icon-wrapper">
                            <textarea id="catatan" name="catatan" placeholder="Tuliskan target atau pertanyaan khusus Anda..."><?= htmlspecialchars($_POST['catatan'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-gradient-submit">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran SEKARANG
                    </button>

                </form>
            </div>

            <!-- RINGKASAN & ESTIMASI HARGA LIVE -->
            <div>
                <div class="glass-card" style="position: sticky; top: 90px;">
                    <div class="form-section-title">
                        <i class="fa-solid fa-receipt"></i> Ringkasan & Estimasi Biaya
                    </div>

                    <?php if ($isSubmitted && empty($errors)): ?>
                        <!-- JIKA FORM BERHASIL DISUBMIT (POST RESULT) -->
                        <div style="background: #dcfce7; border: 1px solid #bbf7d0; color: #15803d; padding: 12px; border-radius: 10px; font-size: 0.88rem; margin-bottom: 15px; text-align: center;">
                            <i class="fa-solid fa-circle-check"></i> Pendaftaran Berhasil Dikirim!
                        </div>

                        <div class="summary-card">
                            <div class="summary-item">
                                <span class="label">Nama</span>
                                <span class="value"><?= $formData['nama'] ?></span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Email</span>
                                <span class="value"><?= $formData['email'] ?></span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Kursus</span>
                                <span class="value"><?= $formData['kursus'] ?></span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Level</span>
                                <span class="value" style="text-transform: capitalize;"><?= $formData['level'] ?></span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Jadwal</span>
                                <span class="value" style="text-transform: capitalize;"><?= $formData['jadwal'] ?></span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Sumber Data</span>
                                <span class="value"><code><?= $formData['sumber'] ?></code></span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Waktu Submit</span>
                                <span class="value" style="font-size: 0.8rem;"><?= $formData['waktu'] ?></span>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- SIMULASI REALTIME SAAT MENGISI FORM -->
                        <div class="summary-card">
                            <div class="summary-item">
                                <span class="label">Status</span>
                                <span class="value" style="color: #6366f1;">Mengisi Formulir...</span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Program Dipilih</span>
                                <span class="value" id="previewKursus">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Tingkat Kelas</span>
                                <span class="value" id="previewLevel">Pemula</span>
                            </div>
                        </div>

                        <div class="price-tag-box">
                            <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">ESTIMASI INVESTASI</span>
                            <div class="amount" id="previewHarga">Rp 0</div>
                            <span style="font-size: 0.75rem; color: #94a3b8;">*Biaya sudah termasuk sertifikat & materi lengkap</span>
                        </div>
                    <?php endif; ?>

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

    <!-- JS DYNAMIC ESTIMATION -->
    <script>
        function calculateEstimate() {
            const courseSelect = document.getElementById('kursus');
            const selectedCourse = courseSelect.value;
            const level = document.querySelector('input[name="level"]:checked').value;

            const basePrices = {
                'Web Development': 350000,
                'UI/UX Design': 300000,
                'Data Science': 450000,
                'Cyber Security': 400000
            };

            const levelMultiplier = {
                'pemula': 1.0,
                'menengah': 1.2,
                'mahir': 1.5
            };

            const previewKursus = document.getElementById('previewKursus');
            const previewLevel = document.getElementById('previewLevel');
            const previewHarga = document.getElementById('previewHarga');

            if (previewKursus && previewHarga) {
                previewKursus.textContent = selectedCourse ? selectedCourse : '-';
                previewLevel.textContent = level.charAt(0).toUpperCase() + level.slice(1);

                if (selectedCourse && basePrices[selectedCourse]) {
                    const total = basePrices[selectedCourse] * levelMultiplier[level];
                    previewHarga.textContent = 'Rp ' + total.toLocaleString('id-ID');
                } else {
                    previewHarga.textContent = 'Rp 0';
                }
            }
        }

        // Jalankan saat pertama kali dimuat
        document.addEventListener('DOMContentLoaded', calculateEstimate);
    </script>

</body>
</html>