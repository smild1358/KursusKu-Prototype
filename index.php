<?php
require_once __DIR__ . '/helpers.php';

$siteName = 'KursusKu';
$tagline = 'Platform Pelatihan & Sertifikasi Keterampilan Digital Terdepan.';
$year = date('Y');

$courses = [
    [
        'code' => 'WEB-01',
        'name' => 'Web Dasar',
        'fee' => 200000,
        'quota' => 30,
        'registered' => 12,
        'start_date' => '2026-09-21',
    ],
    [
        'code' => 'PHP-01',
        'name' => 'PHP Dasar',
        'fee' => 250000,
        'quota' => 30,
        'registered' => 18,
        'start_date' => '2026-09-22',
    ],
    [
        'code' => 'PHP-02',
        'name' => 'PHP Lanjutan',
        'fee' => 300000,
        'quota' => 25,
        'registered' => 24,
        'start_date' => '2026-09-24',
    ],
    [
        'code' => 'LAR-01',
        'name' => 'Laravel Fundamental',
        'fee' => 350000,
        'quota' => 25,
        'registered' => 25,
        'start_date' => '2026-09-28',
    ],
    [
        'code' => 'DB-01',
        'name' => 'MySQL Dasar',
        'fee' => 275000,
        'quota' => 20,
        'registered' => 0,
        'start_date' => '2026-10-01',
    ],
    [
        'code' => 'UI-01',
        'name' => 'UI Web Dasar',
        'fee' => 225000,
        'quota' => 35,
        'registered' => 9,
        'start_date' => '2026-10-03',
    ],
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteName) ?> - Platform Pelatihan Digital</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- SITE HEADER & NAVBAR -->
    <header class="site-header">
        <div class="container nav-wrap">
            <a href="index.php" class="brand"><?= htmlspecialchars($siteName) ?></a>
            <nav class="navbar" aria-label="Navigasi utama">
                <a href="index.php">Beranda</a>
                <a href="#katalog">Katalog Kursus</a>
                <a href="#keunggulan">Keunggulan</a>
                <a href="registration.php" class="nav-btn">Daftar Sekarang</a>
            </nav>
        </div>
    </header>

    <main>
        <!-- HERO SECTION -->
        <section class="hero">
            <div class="container hero-grid">
                <div class="hero-content">
                    <span class="badge">Edukasi Digital</span>
                    <h1>Tingkatkan Keterampilan Bersama <?= htmlspecialchars($siteName) ?></h1>
                    <p><?= htmlspecialchars($tagline) ?></p>
                    <div class="hero-actions">
                        <a href="#katalog" class="btn btn-primary">Lihat Katalog</a>
                        <a href="registration.php" class="btn btn-secondary">Form Pendaftaran</a>
                    </div>
                </div>
                <div class="hero-media">
                    <img src="assets/images/hero-kursus.jpg" alt="Pembelajaran Kursus" class="hero-img">
                </div>
            </div>
        </section>

        <!-- VIDEO SECTION (Ukuran diperkecil dan lebih manis) -->
        <section id="video" class="section-padding bg-soft">
            <div class="container">
                <div class="section-header">
                    <h2>Video Perkenalan KursusKu</h2>
                    <p>Pelajari metode praktis dan alur belajar di platform kami.</p>
                </div>
                <div class="video-wrapper">
                    <video controls>
                        <source src="assets/video/intro-kursus.mp4" type="video/mp4">
                        Browser kamu tidak mendukung pemutaran video.
                    </video>
                </div>
            </div>
        </section>

        <!-- KEUNGGULAN SECTION -->
        <section id="keunggulan" class="section-padding">
            <div class="container">
                <div class="section-header">
                    <h2>Mengapa Memilih KursusKu?</h2>
                    <p>Fasilitas utama untuk mendukung kesuksesan belajar Anda.</p>
                </div>
                <div class="features-grid">
                    <article class="feature-card">
                        <div class="icon-box">📚</div>
                        <h3>Materi Terarah</h3>
                        <p>Materi pembelajaran disusun secara terstruktur, sistematis, dan mudah diikuti oleh pemula.</p>
                    </article>

                    <article class="feature-card">
                        <div class="icon-box">💻</div>
                        <h3>Belajar Berbasis Proyek</h3>
                        <p>Peserta belajar melalui kasus nyata dan latihan praktis yang dapat memperkuat portofolio.</p>
                    </article>

                    <article class="feature-card">
                        <div class="icon-box">👨‍🏫</div>
                        <h3>Pendampingan Praktik</h3>
                        <p>Mendapatkan arahan langsung dari praktisi untuk memastikan pemahaman modul secara mendalam.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- KATALOG KURSUS SECTION (Tabel Colorful & Modern) -->
        <section id="katalog" class="section-padding bg-soft">
            <div class="container">
                <div class="section-header">
                    <h2>Katalog Kursus Pilihan</h2>
                    <p>Pilih program pelatihan sesuai dengan jalur karir yang Anda impikan.</p>
                </div>

                <div class="table-card">
                    <div class="table-responsive">
                        <table class="course-table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Program Kursus</th>
                                    <th>Biaya</th>
                                    <th>Ketersediaan Kursi</th>
                                    <th>Status</th>
                                    <th>Mulai Kursus</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): 
                                    $sisa = sisaKursi($course['quota'], $course['registered']);
                                    $percentage = round(($course['registered'] / $course['quota']) * 100);
                                    
                                    // Penentuan warna badge status
                                    $isFull = ($course['registered'] >= $course['quota']);
                                    $statusClass = $isFull ? 'badge-danger' : ($percentage >= 70 ? 'badge-warning' : 'badge-success');
                                ?>
                                    <tr>
                                        <td>
                                            <span class="code-badge"><?= htmlspecialchars($course['code']) ?></span>
                                        </td>
                                        <td>
                                            <div class="course-title"><?= htmlspecialchars($course['name']) ?></div>
                                            <small class="text-muted">Kuota: <?= (int)$course['quota'] ?> Peserta</small>
                                        </td>
                                        <td>
                                            <span class="price-tag"><?= rupiah($course['fee']) ?></span>
                                        </td>
                                        <td>
                                            <div class="progress-info">
                                                <span><strong><?= (int)$course['registered'] ?></strong> Terdaftar</span>
                                                <small>(Sisa <?= $sisa ?>)</small>
                                            </div>
                                            <div class="progress-bar-bg">
                                                <div class="progress-bar-fill <?= $isFull ? 'fill-full' : '' ?>" style="width: <?= $percentage ?>%;"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <?= statusKursus($course['quota'], $course['registered']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="date-box">
                                                📅 <?= formatTanggal($course['start_date']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($isFull): ?>
                                                <button class="btn-sm btn-disabled" disabled>Penuh</button>
                                            <?php else: ?>
                                                <a href="registration.php?course=<?= urlencode($course['code']) ?>" class="btn-sm btn-daftar">Daftar</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- LANGKAH PENDAFTARAN -->
        <section id="pendaftaran" class="section-padding">
            <div class="container">
                <div class="section-header">
                    <h2>Langkah Pendaftaran</h2>
                    <p>Prosedur mudah untuk memulai kelas pertama Anda.</p>
                </div>
                <div class="steps-grid">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <h3>Pilih Kelas</h3>
                        <p>Tentukan program studi/kursus yang ingin diikuti dari katalog.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <h3>Cek Informasi</h3>
                        <p>Periksa detail biaya, ketersediaan sisa kursi, dan jadwal mulai.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <h3>Isi Form</h3>
                        <p>Lengkapi formulir pendaftaran data diri pada menu Daftar Kursus.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <h3>Konfirmasi</h3>
                        <p>Tunggu verifikasi pendaftaran dan instruksi kelas dari tim KursusKu.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- KONTAK SECTION -->
        <section id="kontak" class="section-padding bg-soft">
            <div class="container text-center">
                <div class="section-header">
                    <h2>Butuh Bantuan?</h2>
                    <p>Tim support kami siap menjawab pertanyaan Anda.</p>
                </div>
                <div class="contact-cards">
                    <div class="contact-box">
                        <strong>Email Support:</strong>
                        <p>info@kursusku.test</p>
                    </div>
                    <div class="contact-box">
                        <strong>Layanan Telepon:</strong>
                        <p>0812-3456-7890</p>
                    </div>
                </div>
                <p style="margin-top: 1.5rem;">
                    <a href="server-time.php" class="link-muted">Lihat Waktu Server</a>
                </p>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; <?= $year ?> <strong><?= htmlspecialchars($siteName) ?></strong>. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>