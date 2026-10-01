<?php
$logFile = __DIR__.'/storage/logs/laravel.log';
$lines = file($logFile);
$recent = array_slice(array_filter($lines, function($l) {
    return str_contains($l, '22:42') || str_contains($l, '22:43') || str_contains($l, '22:44') || str_contains($l, '22:45');
}), -30);
echo "=== LOGS 22:42+ ===\n\n";
echo implode('', $recent);