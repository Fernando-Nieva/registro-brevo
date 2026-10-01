<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

echo "=== TEST HTTP REAL (COMO NAVEGADOR) ===\n\n";

// Limpiar
DB::table('jobs')->delete();
DB::table('failed_jobs')->delete();

// 1. GET /register para obtener token CSRF y sesión
$getRequest = Request::create('/register', 'GET');
$getResponse = $kernel->handle($getRequest);

// Extraer cookies y token
$cookies = $getResponse->headers->getCookies();
$cookieHeader = '';
foreach ($cookies as $cookie) {
    $cookieHeader .= $cookie->getName() . '=' . $cookie->getValue() . '; ';
}

$content = $getResponse->getContent();
preg_match('/name="_token" value="([^"]+)"/', $content, $matches);
$token = $matches[1] ?? null;

echo "1. GET /register\n";
echo "   Token: " . ($token ? 'OK' : 'NO ENCONTRADO') . "\n";
echo "   Cookies: " . count($cookies) . "\n";

// 2. POST /register con cookies y token (EXACTO como navegador)
$postRequest = Request::create('/register', 'POST', [
    '_token' => $token,
    'name' => 'Test Navegador Real',
    'email' => 'test' . time() . '@gmail.com',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'message' => 'Test desde HTTP request real',
], [], [], [], [], $cookieHeader);

$postResponse = $kernel->handle($postRequest);

echo "\n2. POST /register\n";
echo "   Status: " . $postResponse->getStatusCode() . "\n";
echo "   Redirect: " . ($postResponse->headers->get('Location') ?? 'NO') . "\n";
echo "   Jobs en cola: " . DB::table('jobs')->count() . "\n";

// 3. Verificar job en cola
$job = DB::table('jobs')->first();
if ($job) {
    $payload = json_decode($job->payload, true);
    echo "   Job payload keys: " . implode(', ', array_keys($payload)) . "\n";
}

echo "\n=== AHORA EL WORKER DAEMON DEBERÍA PROCESARLO ===\n";
echo "Revisa tu terminal con 'php artisan queue:work'\n";