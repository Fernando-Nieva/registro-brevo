<?php
$logFile = __DIR__.'/storage/logs/laravel.log';
$lines = file($logFile);
$recent = array_slice($lines, -20);
echo "=== ÚLTIMAS 20 LÍNEAS DEL LOG ===\n\n";
echo implode('', $recent);