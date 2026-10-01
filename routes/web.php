<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RegisterController;
use App\Mail\TestBrevoMail;

Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// TEST SÍNCRONO BREVO (sin queue) - para debuggear
Route::get('/test-brevo', function () {
    Mail::to('nieva.cronos@gmail.com')->send(new TestBrevoMail('Test', 'Test Brevo', 'Mensaje de prueba síncrono'));
    return 'Enviado síncrono - revisa inbox + errores en pantalla';
});