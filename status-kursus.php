<?php
/**
 * status-kursus.php - Halaman & Komponen Status Kursus Detail (Week 04)
 */
require_once __DIR__ . '/helpers.php';

// Data Kursus untuk Pengujian Status
$courses = [
    [
        'code'       => 'WEB-01',
        'name'       => 'Web Dasar',
        'fee'        => 200000,
        'quota'      => 30,
        'registered' => 12,
        'start_date' => '2026-09-21'
    ],
    [
        'code'       => 'PHP-01',
        'name'       => 'PHP Dasar',
        'fee'        => 250000,
        'quota'      => 30,
        'registered' => 18,
        'start_date' => '2026-09-22'
    ],
    [
        'code'       => 'PHP-02',
        'name'       => 'PHP Lanjutan',
        'fee'        => 300000,
        'quota'      => 25,
        'registered' => 24, // Hampir Penuh
        'start_date' => '2026-09-24'
    ],
    [
        'code'       => 'LAR-01',
        'name'       => 'Laravel Fundamental',
        'fee'        => 350000,
        'quota'      => 25,
        'registered' => 25, // Penuh
        'start_date' => '2026-09-28'
    ],
    [
        'code'       => 'DB-01',
        'name'       => 'MySQL Dasar',
        'fee'        => 275000,
        'quota'      => 20,
        'registered' => 0,  // Kosong / Baru
        'start_date' => '2026-10-01'
    ],
    [
        'code'       => 'UI-01',
        'name'       => 'UI Web Dasar',
        'fee'        => 225000,
        'quota'      => 35,
        'registered' => 9,
        'start_date' => '2026-10-03'
    ]
];

/**
 * Fungsi pembantu tambahan khusus status visual
 */
function getStatusDetails(int $quota, int $registered): array
{
    $remaining  = sisaKursi($quota, $registered); // dari helpers.php
    $percentage = ($quota > 0) ? min(100, round(($registered / $quota) * 100)) : 0;

    if ($registered >= $quota) {
        return [
            'label'      => 'Penuh',
            'badgeClass' => 'badge-full',
            'progress'   => 'progress-full',
            'percent'    => $percentage,
            'message'    => 'Pendaftaran ditutup'
        ];
    } elseif ($percentage >= 80) {
        return [
            'label'      => 'Sisa Sedikit',
            'badgeClass' => 'badge-warning',
            'progress'   => 'progress-warning',
            'percent'    => $percentage,
            'message'    => 'Segera mendaftar!'
        ];
    } else {
        return [
            'label'      => 'Tersedia',
            'badgeClass' => 'badge-available',
            'progress'   => 'progress-available',
            'percent'    => $percentage,
            'message'    => 'Kursi masih banyak'
        ];
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Status Kursus - KursusKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0f766e;
            --primary-light: #ccfbf1;
            --bg: #f8fafc;
            --surface: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); color: var(--text-dark); padding: 40px 20px; }

        .container { max-width: 950px; margin: auto; }
        .header { text-align: center; margin-bottom: 32px; }
        .header h1 { font-size: 26px; color: var(--primary); font-weight: 800; }
        .header p { color: var(--text-muted); font-size: 14px; margin-top: 6px; }

        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); transition: transform 0.2s; }
        .card:hover { transform: translateY(-2px); }

        .card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .code { font-family: monospace; font-size: 12px; font-weight: 700; background: #f1f5f9; padding: 4px 8px; border-radius: 6px; color: #334155; }
        
        /* Badges */
        .badge { padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 5px; }
        .badge-available { background: #e7f8ef; color: #146c43; }
        .badge-warning { background: #fffbebf5; color: #b45309; border: 1px solid #fde68a; }
        .badge-full { background: #fdeaea; color: #a61b1b; }

        .course-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; color: var(--text-dark); }

        /* Progress Bar */
        .progress-container { background: #e2e8f0; border-radius: 10px; height: 10px; width: 100%; overflow: hidden; margin-bottom: 10px; }
        .progress-bar { height: 100%; border-radius: 10px; transition: width 0.3s ease; }
        .progress-available { background: #10b981; }
        .progress-warning { background: #f59e0b; }
        .progress-full { background: #ef4444; }

        .meta-info { display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted); font-weight: 600; }
        .note { margin-top: 12px; font-size: 12px; font-weight: 600; color: var(--primary); text-align: right; }

        .btn-back { display: inline-block; margin-top: 30px; color: var(--primary); font-weight: 700; text-decoration: none; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><i class="fa-solid fa-chart-pie"></i> Status Keterisian Kursus</h1>
        <p>Visualisasi Quota, Sisa Kursi, dan Presentase Pendaftaran Real-Time</p>
    </div>

    <div class="grid">
        <?php foreach ($courses as $course): ?>
            <?php
                $statusData = getStatusDetails($course['quota'], $course['registered']);
                $remaining  = sisaKursi($course['quota'], $course['registered']);
            ?>
            <div class="card">
                <div class="card-top">
                    <span class="code"><?= htmlspecialchars($course['code']) ?></span>
                    <span class="badge <?= $statusData['badgeClass'] ?>">
                        <?= $statusData['label'] ?>
                    </span>
                </div>

                <div class="course-title"><?= htmlspecialchars($course['name']) ?></div>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div class="progress-bar <?= $statusData['progress'] ?>" style="width: <?= $statusData['percent'] ?>%;"></div>
                </div>

                <div class="meta-info">
                    <span>Terisi: <strong><?= $course['registered'] ?>/<?= $course['quota'] ?></strong></span>
                    <span>Sisa: <strong><?= $remaining ?> Kursi</strong></span>
                </div>

                <div class="note">
                    <i class="fa-solid fa-circle-info"></i> <?= $statusData['message'] ?> (<?= $statusData['percent'] ?>%)
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="index.php" class="btn-back">&larr; Kembali ke Katalog Utama</a>
</div>

</body>
</html>