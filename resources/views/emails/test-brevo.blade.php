<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $asunto }}</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial,sans-serif;">
    <table role="presentation" style="width:100%; padding:40px 0;">
        <tr>
            <td align="center">
                <table style="width:100%; max-width:600px; background:#fff; border-radius:8px; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center">
                            <h2 style="color:#1e293b;">¡Hola, {{ $nombre }}!</h2>
                            <p style="color:#475569; font-size:16px;">{{ $mensaje }}</p>
                            <div style="margin-top:20px; padding:12px; background:#e0f2fe; color:#0369a1; border-radius:6px; font-weight:bold;">
                                Test síncrono Brevo - Sin queue
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>