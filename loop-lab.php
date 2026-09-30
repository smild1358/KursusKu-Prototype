<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Lab Perulangan - Pertemuan 6</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; padding: 40px 20px; }
        .card { max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; }
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 20px; }
        .box { background: #f8fafc; border: 1px solid #cbd5e1; padding: 16px; border-radius: 8px; }
        h4 { margin-bottom: 8px; color: #0f766e; }
    </style>
</head>
<body>

<div class="card">
    <h2>Eksperimen Perbandingan Looping PHP</h2>
    <p>Membandingkan struktur kontrol perulangan <code>for</code>, <code>while</code>, dan <code>do-while</code>[cite: 5].</p>

    <div class="grid">
        <!-- Loop FOR -->
        <div class="box">
            <h4>For Loop</h4>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                Iterasi ke-<?= $i ?><br>
            <?php endfor; ?>
        </div>

        <!-- Loop WHILE -->
        <div class="box">
            <h4>While Loop</h4>
            <?php 
            $j = 1;
            while ($j <= 5) {
                echo "Iterasi ke-{$j}<br>";
                $j++;
            }
            ?>
        </div>

        <!-- Loop DO-WHILE -->
        <div class="box">
            <h4>Do-While Loop</h4>
            <?php 
            $k = 1;
            do {
                echo "Iterasi ke-{$k}<br>";
                $k++;
            } while ($k <= 5);
            ?>
        </div>
    </div>
</div>

</body>
</html>