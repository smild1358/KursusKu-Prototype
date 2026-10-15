<?php
require_once __DIR__ . '/helpers.php';

/**
 * Memetakan nilai mode pembelajaran menjadi label visual yang estetik.
 * Mode "offline" dipetakan secara khusus menjadi "Tatap Muka".
 *
 * @param string $mode Kode mode pembelajaran ('offline', 'online', 'hybrid', dll)
 * @return string HTML Badge/Label yang sudah diformat
 */
if (!function_exists('getLearningModeLabel')) {
    function getLearningModeLabel(string $mode): string {
        $normalizedMode = strtolower(trim($mode));

        switch ($normalizedMode) {
            case 'offline':
                return '<span class="mode-badge mode-offline"><i class="fa-solid fa-users"></i> Tatap Muka</span>';
            case 'online':
                return '<span class="mode-badge mode-online"><i class="fa-solid fa-laptop-code"></i> Daring (Online)</span>';
            case 'hybrid':
                return '<span class="mode-badge mode-hybrid"><i class="fa-solid fa-layer-group"></i> Hybrid</span>';
            default:
                return '<span class="mode-badge mode-default"><i class="fa-solid fa-circle-question"></i> ' . htmlspecialchars(ucfirst($mode)) . '</span>';
        }
    }
}

// Ambil input pengujian via query string GET (default: offline)
$selectedMode = $_GET['mode'] ?? 'offline';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Mode Label Inspector — KursusKu</title>
    
    <!-- Google Fonts & Font Awesome Icons -->
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
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header Card */
        .header-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px 30px;
            box-shadow: 0 10px 30px rgba(15, 118, 110, 0.08);
            border: 1px solid rgba(15, 118, 110, 0.1);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-title i {
            font-size: 1.8rem;
            color: var(--primary);
            background: var(--primary-light);
            padding: 12px;
            border-radius: 12px;
        }

        .header-title h1 {
            font-size: 1.4rem;
            font-weight: 800;
        }

        .btn-back {
            text-decoration: none;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--primary-light);
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: var(--primary);
            color: white;
        }

        /* Main Testing Card */
        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 32px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-mode {
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.88rem;
            background: #f1f5f9;
            color: var(--text-muted);
            border: 1.5px solid var(--border);
            transition: all 0.2s;
        }

        .btn-mode.active, .btn-mode:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Result Display Box */
        .result-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .result-title {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        /* CSS Styling Khusus Badge Mode Pembelajaran */
        .mode-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Styling Khusus Mode "offline" -> "Tatap Muka" */
        .mode-offline {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .mode-online {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .mode-hybrid {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .mode-default {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .code-preview {
            margin-top: 20px;
            background: #0f172a;
            color: #38bdf8;
            padding: 16px;
            border-radius: 12px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            text-align: left;
            overflow-x: auto;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER NAVIGATION -->
    <div class="header-card">
        <div class="header-title">
            <i class="fa-solid fa-chalkboard-user"></i>
            <div>
                <h1>getLearningModeLabel() Laboratory</h1>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Pengujian Pemetaan Nilai Mode Pembelajaran</p>
            </div>
        </div>
        <a href="index.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- CARDS PENGUJIAN -->
    <div class="card">
        <div class="form-group">
            <label>Pilih Nilai Mode Pembelajaran untuk Diuji:</label>
            <div class="btn-group">
                <a href="?mode=offline" class="btn-mode <?= $selectedMode === 'offline' ? 'active' : '' ?>">
                    <i class="fa-solid fa-users"></i> offline
                </a>
                <a href="?mode=online" class="btn-mode <?= $selectedMode === 'online' ? 'active' : '' ?>">
                    <i class="fa-solid fa-laptop-code"></i> online
                </a>
                <a href="?mode=hybrid" class="btn-mode <?= $selectedMode === 'hybrid' ? 'active' : '' ?>">
                    <i class="fa-solid fa-layer-group"></i> hybrid
                </a>
            </div>
        </div>

        <!-- HASIL RENDER LABEL -->
        <div class="result-box">
            <div class="result-title">Hasil Output getLearningModeLabel('<?= htmlspecialchars($selectedMode) ?>'):</div>
            <div>
                <?= getLearningModeLabel($selectedMode) ?>
            </div>

            <div class="code-preview">
// Pemetaan Input vs Output:
Input  : '<?= htmlspecialchars($selectedMode) ?>'
Output : <?= htmlspecialchars(getLearningModeLabel($selectedMode)) ?>
            </div>
        </div>
    </div>

</div>

</body>
</html>