# Registro de Usuarios con Notificación por Email (Brevo SMTP)

Proyecto Laravel 13 para registro de usuarios con notificación automática por email usando Brevo (Sendinblue) como proveedor SMTP.

## 📋 Descripción

Sistema de registro de usuarios que:
- Permite registrar usuarios con nombre, email, contraseña y mensaje opcional
- Valida datos en servidor (unique email, contraseña confirmada, etc.)
- **Envía notificación SIEMPRE al administrador** (nieva.cronos@gmail.com) cuando alguien se registra
- Incluye en el email: nombre del usuario, email registrado y mensaje opcional
- Usa colas (queue) para procesamiento asíncrono de emails
- Almacena usuarios en SQLite

## 🛠 Stack Tecnológico

| Componente | Versión/Tool |
|------------|--------------|
| **Framework** | Laravel 13.x |
| **PHP** | 8.3+ |
| **Base de datos** | SQLite (desarrollo) |
| **Colas (Queues)** | Database driver |
| **Email SMTP** | Brevo (Sendinblue) |
| **Frontend** | Vite + Vanilla JS + CSS |
| **Testing** | PHPUnit |

## 🔧 Configuración Brevo SMTP

### Variables de entorno (.env)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=b7c2ac001@smtp-brevo.com    # SMTP username de Brevo (NO tu email)
MAIL_PASSWORD=xsmtpsib-xxxxxxxxxxxxxxxx    # SMTP Key generada en Brevo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nieva.cronos@gmail.com   # Sender verificado en Brevo
MAIL_FROM_NAME="Utn Tup"
```

### Requisitos en Brevo
1. **Sender verificado**: Settings → Senders → `nieva.cronos@gmail.com` (check verde)
2. **SMTP Access ON**: Settings → SMTP & API → SMTP Access = ON
3. **IP autorizada**: Settings → SMTP & API → Authorized IPs → agregar tu IP pública
4. **SMTP Key**: Settings → SMTP & API → Generate SMTP Key (usa esa key en MAIL_PASSWORD)

## 🚀 Instalación y Uso

### 1. Clonar e instalar dependencias
```bash
git clone https://github.com/Fernando-Nieva/registro-brevo.git
cd registro-brevo
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Configurar .env
Edita `.env` con tus credenciales Brevo (ver sección arriba).

### 3. Base de datos
```bash
php artisan migrate
```

### 4. Ejecutar (requiere 2 terminales)

**Terminal 1 - Servidor web:**
```bash
php artisan serve --port=8000
```

**Terminal 2 - Queue worker (OBLIGATORIO para emails):**
```bash
php artisan queue:work
```

### 5. Probar
- Abrir: http://127.0.0.1:8000/register
- Completar formulario con cualquier email
- Enviar → Verificar que llega email a **nieva.cronos@gmail.com**

## 📁 Estructura Clave

```
app/
├── Http/Controllers/RegisterController.php   # Lógica de registro + email a admin
├── Mail/WelcomeUserMail.php                  # Mailable con queue (ShouldQueue)
├── Models/User.php                           # Modelo Usuario
resources/
├── views/
│   ├── auth/register.blade.php               # Formulario registro
│   └── emails/welcome.blade.php              # Template email admin
routes/
├── web.php                                   # Rutas: GET/POST /register
config/
├── mail.php                                  # Configuración mailers
├── queue.php                                 # Configuración colas (database)
.env                                          # Variables de entorno (NO commitear)
```

## ⚙️ Flujo de Datos

```
Usuario envía POST /register
         ↓
RegisterController::store()
  - Valida datos
  - Crea User en BD
  - Mail::to('nieva.cronos@gmail.com')->send(new WelcomeUserMail($data))
         ↓
Job encolado en tabla 'jobs' (queue database)
         ↓
php artisan queue:work (daemon)
  - Procesa job
  - Envía vía Brevo SMTP
         ↓
Email entregado a nieva.cronos@gmail.com
```

## 🐛 Problemas Comunes y Soluciones

| Problema | Causa | Solución |
|----------|-------|----------|
| Email no llega | Queue worker no corriendo | Ejecutar `php artisan queue:work` en terminal separada |
| Error 535 Auth failed | Credenciales Brevo incorrectas | Verificar MAIL_USERNAME (SMTP username) y MAIL_PASSWORD (SMTP Key) |
| Error 525 Unauthorized IP | IP no autorizada en Brevo | Agregar IP pública en Brevo → SMTP & API → Authorized IPs |
| Email en spam | Reputación dominio/IP | Revisar carpeta Spam/Promociones; configurar SPF/DKIM en Brevo |
| Unique constraint email | Email ya registrado | Borrar usuario previo o usar email diferente |

## 🧪 Testing

```bash
# Tests unitarios
php artisan test

# Probar email síncrono (sin queue) - debug
curl http://127.0.0.1:8000/test-brevo
```

## 📝 Licencia

MIT License - Proyecto educativo UTN Tup 2026

---

**Nota**: El email **SIEMPRE se envía a `nieva.cronos@gmail.com`** (admin) independientemente del email que use el usuario al registrarse. Esto permite al administrador recibir notificaciones de todos los registros.