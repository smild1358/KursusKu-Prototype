<?php
require_once __DIR__ . '/helpers.php';
function hitungTotal(
    int $price,
    int $qty,
    float $discount = 0
): int {
    $subtotal = $price * $qty;
    $potongan = $subtotal * ($discount / 100);

    return (int) round($subtotal - $potongan);
}

$price = 250000;
$qty = 2;
$discount = 10;

$subtotal = $price * $qty;
$total = hitungTotal($price, $qty, $discount);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kalkulator Biaya - KursusKu</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<main>

    <h1>Kalkulator Biaya Kursus</h1>

    <section>

        <p>
            Harga Kursus:
            <strong><?= rupiah($price) ?></strong>
        </p>

        <p>
            Jumlah Peserta:
            <strong><?= $qty ?></strong>
        </p>

        <p>
            Subtotal:
            <strong><?= rupiah($subtotal) ?></strong>
        </p>

        <p>
            Diskon:
            <strong><?= $discount ?>%</strong>
        </p>

        <p>
            Total Bayar:
            <strong><?= rupiah($total) ?></strong>
        </p>

    </section>

</main>

</body>
</html>