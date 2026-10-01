<?php
$lines = file('storage/logs/laravel.log');
$recent = array_slice(array_filter($lines, function($l) {
    return str_contains($l, 'Mail queued') || str_contains($l, 'usuario@ejemplo') || str_contains($l, 'User created');
}), -10);
echo implode('', $recent);