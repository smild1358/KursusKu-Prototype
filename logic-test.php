<?php
/**
 * logic-test.php - Praktikum A: Operator Perbandingan & Logika
 */
$quota      = 30;
$registered = 18;

$isFull  = $registered >= $quota; // False
$hasSeat = $registered < $quota;  // True

echo "<h3>Hasil Pengujian Logika (Awal: Quota 30, Registered 18):</h3>";
var_dump($isFull);
echo "<br>";
var_dump($hasSeat);

// Simulasi jika terisi penuh
$registeredFull = 30;
echo "<h3>Hasil Pengujian Logika (Registered = 30):</h3>";
var_dump($registeredFull >= $quota); // True