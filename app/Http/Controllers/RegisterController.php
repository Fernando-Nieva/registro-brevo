<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\WelcomeUserMail;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        \Log::info('Register attempt', ['data' => $request->all()]);
        
        // Validaciones
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:255'],
            'email'    => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'message'  => ['nullable', 'string', 'max:1000'],
        ], [
            'email.unique'       => 'Este correo electrónico ya se encuentra registrado.',
            'password.confirmed' => 'Las contraseñas ingresadas no coinciden.',
        ]);

        \Log::info('Validation passed', ['validated' => $validated]);

        // Guardar usuario
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        \Log::info('User created', ['user_id' => $user->id, 'email' => $user->email]);

        // Enviar correo SIEMPRE a admin (nieva.cronos@gmail.com)
        Mail::to('nieva.cronos@gmail.com')->send(new WelcomeUserMail($validated));

        \Log::info('Mail queued to admin', ['user_id' => $user->id, 'user_email' => $user->email]);

        return back()->with('success', '¡Usuario registrado con éxito! Correo de bienvenida enviado.');
    }
}