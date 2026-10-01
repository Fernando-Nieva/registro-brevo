<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;">
    <table role="presentation" style="width:100%; padding:40px 0;">
        <tr>
            <td align="center">
                <table style="width:100%; max-width:600px; background:#ffffff; border-radius:8px; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center">
                            <h2 style="color:#1e293b;">¡Nuevo registro!</h2>
                            <p style="color:#475569; font-size:16px;">
                                Se ha registrado un nuevo usuario:
                            </p>
                            <div style="margin:16px 0; padding:16px; background:#f8fafc; border-radius:6px; text-align:left;">
                                <p style="margin:0 0 8px;"><strong>Nombre:</strong> {{ $nombre }}</p>
                                <p style="margin:0 0 8px;"><strong>Email:</strong> {{ $email_usuario }}</p>
                            </div>

                            @if(!empty($mensaje))
                            <div style="margin-top:20px; padding:16px; background:#f8fafc; border-left:4px solid #3b82f6; border-radius:0 6px 6px 0;">
                                <p style="margin:0 0 8px; color:#1e293b; font-size:14px; font-weight:600;">Tu mensaje:</p>
                                <blockquote style="margin:0; color:#475569; font-size:15px; font-style:italic;">
                                    "{{ $mensaje }}"
                                </blockquote>
                            </div>
                            @endif

                            <div style="margin-top:20px; padding:12px; background:#e0f2fe; color:#0369a1; border-radius:6px; font-weight:bold;">
                                Registro completado exitosamente.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>