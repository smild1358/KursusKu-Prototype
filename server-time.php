<?php
// Set zona waktu default
date_default_timezone_set('Asia/Jakarta');

// Mengambil data server
$serverTime       = date('H:i:s');$serverDate       = date('l, d F Y');
$timeZone         = date_default_timezone_get();$phpVersion       = phpversion();
$serverSoftware   =$_SERVER['SERVER_SOFTWARE'] ?? 'Web Server (Laragon)';
$serverIP         =$_SERVER['SERVER_ADDR'] ?? '127.0.0.1';
$clientIP         =$_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$year             = date('Y');$siteName         = 'KursusKu';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waktu Server - <?= htmlspecialchars($siteName) ?></title>

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --brand: #0f766e;
            --brand-dark: #0b5f55;
            --brand-light: #ccfbf1;
            --accent: #6366f1;
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f766e 100%);
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.15);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        /* Glassmorphism Card */
        .time-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .time-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(15, 118, 110, 0.15) 0%, transparent 60%);
            pointer-events: none;
        }

        .badge-live {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background-color: #34d399;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7);
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(52, 211, 153, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(52, 211, 153, 0);
            }
        }

        /* Digital Clock */
        .clock-display {
            font-size: 4.5rem;
            font-weight: 800;
            letter-spacing: 2px;
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: 'Courier New', Courier, monospace;
            margin-bottom: 8px;
            text-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .date-display {
            font-size: 1.2rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 32px;
        }

        /* Grid Info Server */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-top: 24px;
            text-align: left;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 16px;
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-3px);
        }

        .info-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Navigasi */
        .actions {
            margin-top: 32px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid var(--glass-border);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: #ffffff;
            color: #0f172a;
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            margin-top: 40px;
            color: var(--text-muted);
            font-size: 0.85rem;
            text-align: center;
        }

        @media (max-width: 600px) {
            .clock-display {
                font-size: 3rem;
            }
            .time-card {
                padding: 24px 16px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="time-card">
            <!-- Indikator Live Status -->
            <div class="badge-live">
                <span class="pulse-dot"></span>
                Server PHP Aktif
            </div>

            <!-- Tampilan Jam Utama (Dirender oleh PHP) -->
            <div class="clock-display" id="clock"><?= $serverTime ?></div>
            <div class="date-display"><i class="fa-regular fa-calendar-days"></i> <?= $serverDate ?></div>

            <!-- Informasi Teknis Server PHP -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label"><i class="fa-solid fa-earth-asia"></i> Zona Waktu</div>
                    <div class="info-value"><?= $timeZone ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fa-brands fa-php"></i> Versi PHP</div>
                    <div class="info-value">v<?= $phpVersion ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fa-solid fa-server"></i> Web Server</div>
                    <div class="info-value"><?= htmlspecialchars($serverSoftware) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fa-solid fa-network-wired"></i> IP Server</div>
                    <div class="info-value"><?= $serverIP ?></div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="actions">
                <a href="index.php" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
                <a href="server-time.php" class="btn-back" style="background: var(--brand);">
                    <i class="fa-solid fa-rotate-right"></i> Refresh Waktu PHP
                </a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?= $year ?> <strong><?= htmlspecialchars($siteName) ?></strong> - Praktikum Pemrograman Web III</p>
    </footer>

    <!-- Script Opsional untuk Detik Berjalan Halus -->
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
    </script>
</body>

</html>