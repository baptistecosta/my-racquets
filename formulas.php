<?php

const PI = 3.14159265359;
const G = 980.5; // Unit of acceleration due to gravity

const TWO_PI_SQUARE = (2 * PI) ** 2;

$M = 0.352; // Weight in kg
$R = 32.1; // Balance point in cm
$H = 64.9; // Distance to the hanging point in cm
$T = 1.38; // Swing time in s (1x)
$L = 69; // Length in cm

// MGR/I
$mgri =	TWO_PI_SQUARE * G * $R / ($T * $T * G * ($H - $R) + TWO_PI_SQUARE * $H * (2 * $R - $H));

// MR²
$mr2 = $M * $R ** 2;

// Swingweight
$sw = (1 / 12) * $M * $L * $L + (1 / 2) * $M * $R * $L - 20 * $M * $R + 100 * $M;

echo $mgri . "\n";
echo $mr2 . "\n";
echo $sw . "\n";
echo TWO_PI_SQUARE . "\n";
