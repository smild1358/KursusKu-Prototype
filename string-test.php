<?php
/**
 * string-test.php - Praktikum E: Fungsi String
 */
$rawName   = "   Laravel Fundamental   ";
$cleanName = trim($rawName); // Menghapus spasi luar
$upperName = strtoupper($cleanName);
$lowerName = strtolower($cleanName);
$length    = strlen($cleanName);
$short     = substr($cleanName, 0, 7);

echo "<strong>Raw Name:</strong> '" . $rawName . "'<br>";
echo "<strong>Clean Name (trim):</strong> '" . $cleanName . "'<br>"; // Output: 'Laravel Fundamental'
echo "<strong>Upper Name:</strong> " . $upperName . "<br>";
echo "<strong>Lower Name:</strong> " . $lowerName . "<br>";
echo "<strong>String Length:</strong> " . $length . "<br>";
echo "<strong>Substring (0-7):</strong> " . $short . "<br>";