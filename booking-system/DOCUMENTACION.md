# Sistema de Reserva de Turnos - Documentación Completa

## 📋 Índice
1. [Introducción](#introducción)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Modelos y Base de Datos](#modelos-y-base-de-datos)
4. [Controladores](#controladores)
5. [Migraciones](#migraciones)
6. [Seeders](#seeders)
7. [Instalación y Configuración](#instalación-y-configuración)
8. [Uso del Sistema](#uso-del-sistema)

---

## 🎯 Introducción

Este es un **Sistema de Reserva de Turnos** completo desarrollado en Laravel 12. El sistema permite a los clientes reservar citas con profesionales para diferentes servicios (peluquería, manicura, tratamientos, etc.).

### Características Principales
- ✅ Gestión de usuarios (Administradores y Clientes)
- ✅ Catálogo de servicios con precios y duraciones
- ✅ Gestión de profesionales con especialidades
- ✅ Sistema de reservas con validación de conflictos
- ✅ Horarios de disponibilidad configurables
- ✅ Estados de reserva (Pendiente, Confirmada, Cancelada, Completada)
- ✅ Validación de horarios para evitar reservas duplicadas

---

## 🏗️ Arquitectura del Sistema

El sistema sigue el patrón **MVC (Modelo-Vista-Controlador)** de Laravel:

```
booking-system/
├── app/
│   ├── Http/Controllers/     # Lógica de negocio
│   └── Models/               # Modelos Eloquent
├── database/
│   ├── migrations/           # Esquema de base de datos
│   └── seeders/              # Datos de prueba
├── routes/
│   └── web.php              # Definición de rutas
└── resources/
    └── views/               # Vistas Blade (a implementar)
```

---

## 💾 Modelos y Base de Datos

### 1. **User** - `app/Models/User.php`

**Propósito:** Representa a los usuarios del sistema (administradores y clientes).

**Atributos:**
- `id`: Identificador único
- `name`: Nombre completo
- `email`: Correo electrónico (único)
- `password`: Contraseña hasheada
- `role`: Rol del usuario ('admin' o 'client')
- `phone`: Teléfono de contacto
- `created_at`, `updated_at`: Timestamps automáticos

**Relaciones:**
```php
hasMany(Booking::class) // Un usuario puede tener múltiples reservas
```

**Métodos Especiales:**
- `isAdmin()`: Verifica si el usuario es administrador
- `isClient()`: Verifica si el usuario es cliente

**Uso:**
```php
// Obtener todas las reservas de un usuario
$user = User::find(1);
$reservas = $user->bookings;

// Verificar si es admin
if ($user->isAdmin()) {
    // Acceso a panel de administración
}
```

---

### 2. **Service** - `app/Models/Service.php`

**Propósito:** Representa los servicios que se pueden reservar (corte de cabello, manicura, etc.).

**Atributos:**
- `id`: Identificador único
- `name`: Nombre del servicio
- `description`: Descripción detallada
- `duration`: Duración en minutos
- `price`: Precio del servicio
- `is_active`: Si el servicio está activo
- `created_at`, `updated_at`: Timestamps

**Relaciones:**
```php
hasMany(Booking::class) // Un servicio puede tener múltiples reservas
```

**Conversiones (Casts):**
```php
'price' => 'decimal:2',      // Asegura 2 decimales
'duration' => 'integer',     // Entero
'is_active' => 'boolean',    // Booleano
```

**Uso:**
```php
// Obtener servicios activos
$servicios = Service::where('is_active', true)->get();

// Crear nuevo servicio
Service::create([
    'name' => 'Corte de Cabello',
    'description' => 'Corte personalizado',
    'duration' => 30,
    'price' => 25.00,
]);
```

---

### 3. **Professional** - `app/Models/Professional.php`

**Propósito:** Representa a los profesionales que brindan los servicios.

**Atributos:**
- `id`: Identificador único
- `name`: Nombre del profesional
- `email`: Correo electrónico (único)
- `phone`: Teléfono
- `specialization`: Especialidad
- `bio`: Biografía
- `is_active`: Si está activo
- `created_at`, `updated_at`: Timestamps

**Relaciones:**
```php
hasMany(Booking::class)      // Tiene múltiples reservas
hasMany(Availability::class) // Tiene múltiples horarios de disponibilidad
```

**Scopes (Consultas Reutilizables):**
```php
scopeActive($query) // Filtra solo profesionales activos
```

**Uso:**
```php
// Obtener profesionales activos
$profesionales = Professional::active()->get();

// Obtener disponibilidad de un profesional
$profesional = Professional::find(1);
$horarios = $profesional->availability;
```

---

### 4. **Booking** - `app/Models/Booking.php`

**Propósito:** Representa una reserva de turno realizada por un cliente.

**Atributos:**
- `id`: Identificador único
- `user_id`: ID del usuario que reserva
- `professional_id`: ID del profesional asignado
- `service_id`: ID del servicio reservado
- `booking_date`: Fecha de la reserva
- `start_time`: Hora de inicio
- `end_time`: Hora de fin
- `status`: Estado ('pending', 'confirmed', 'cancelled', 'completed')
- `notes`: Notas adicionales
- `created_at`, `updated_at`: Timestamps

**Relaciones:**
```php
belongsTo(User::class)         // Pertenece a un usuario
belongsTo(Professional::class) // Pertenece a un profesional
belongsTo(Service::class)      // Pertenece a un servicio
```

**Scopes:**
```php
scopePending($query)           // Filtra reservas pendientes
scopeConfirmed($query)         // Filtra reservas confirmadas
scopeForDate($query, $date)    // Filtra por fecha específica
```

**Conversiones:**
```php
'booking_date' => 'date',
'start_time' => 'datetime:H:i',
'end_time' => 'datetime:H:i',
```

**Uso:**
```php
// Obtener reservas pendientes del día
$reservas = Booking::pending()
    ->forDate(today())
    ->with(['user', 'professional', 'service'])
    ->get();

// Crear nueva reserva
Booking::create([
    'user_id' => 1,
    'professional_id' => 2,
    'service_id' => 3,
    'booking_date' => '2025-12-01',
    'start_time' => '10:00',
    'end_time' => '10:30',
    'status' => 'pending',
]);
```

---

### 5. **Availability** - `app/Models/Availability.php`

**Propósito:** Define los horarios de disponibilidad de cada profesional.

**Atributos:**
- `id`: Identificador único
- `professional_id`: ID del profesional
- `day_of_week`: Día de la semana (Monday-Sunday)
- `start_time`: Hora de inicio
- `end_time`: Hora de fin
- `is_available`: Si está disponible
- `created_at`, `updated_at`: Timestamps

**Relaciones:**
```php
belongsTo(Professional::class) // Pertenece a un profesional
```

**Scopes:**
```php
scopeAvailable($query)      // Solo horarios disponibles
scopeForDay($query, $day)   // Filtra por día de la semana
```

**Nombre de tabla customizado:**
```php
protected $table = 'availability'; // Tabla en singular
```

**Uso:**
```php
// Obtener disponibilidad de un profesional para los lunes
$profesional = Professional::find(1);
$lunes = $profesional->availability()
    ->forDay('Monday')
    ->available()
    ->get();
```

---

## 🎮 Controladores

### **BookingController** - `app/Http/Controllers/BookingController.php`

**Propósito:** Gestiona todas las operaciones relacionadas con las reservas.

#### Métodos:

##### `index()`
**Qué hace:** Muestra la lista de reservas
- Administradores: ven todas las reservas
- Clientes: solo ven sus propias reservas

**Código:**
```php
public function index()
{
    $user = Auth::user();

    if ($user->isAdmin()) {
        $bookings = Booking::with(['user', 'professional', 'service'])
            ->orderBy('booking_date', 'desc')
            ->paginate(15);
    } else {
        $bookings = $user->bookings()
            ->with(['professional', 'service'])
            ->paginate(15);
    }

    return view('bookings.index', compact('bookings'));
}
```

##### `create()`
**Qué hace:** Muestra el formulario para crear una nueva reserva

**Código:**
```php
public function create()
{
    $services = Service::where('is_active', true)->get();
    $professionals = Professional::where('is_active', true)->get();

    return view('bookings.create', compact('services', 'professionals'));
}
```

##### `store(Request $request)`
**Qué hace:** Guarda una nueva reserva
- Valida que no haya conflictos de horario
- Calcula automáticamente la hora de fin según la duración del servicio
- Verifica disponibilidad del profesional

**Validaciones:**
```php
$validated = $request->validate([
    'service_id' => 'required|exists:services,id',
    'professional_id' => 'required|exists:professionals,id',
    'booking_date' => 'required|date|after_or_equal:today',
    'start_time' => 'required|date_format:H:i',
    'notes' => 'nullable|string|max:500',
]);
```

**Lógica de Conflictos:**
```php
// Verifica si ya existe una reserva en ese horario
$conflict = Booking::where('professional_id', $professional_id)
    ->where('booking_date', $date)
    ->where('status', '!=', 'cancelled')
    ->where(function ($query) use ($startTime, $endTime) {
        $query->whereBetween('start_time', [$start, $end])
            ->orWhereBetween('end_time', [$start, $end]);
    })
    ->exists();
```

##### `show(Booking $booking)`
**Qué hace:** Muestra los detalles de una reserva específica
- Verifica que el usuario tenga permisos para ver la reserva

##### `update(Request $request, Booking $booking)`
**Qué hace:** Actualiza el estado o notas de una reserva

##### `destroy(Booking $booking)`
**Qué hace:** Cancela una reserva (cambia el estado a 'cancelled')

##### `getAvailableSlots(Request $request)`
**Qué hace:** API endpoint que devuelve los horarios disponibles
- Útil para implementar selección dinámica de horarios en el frontend

---

## 📊 Migraciones

### 1. **create_users_table** (Laravel por defecto)
Crea la tabla de usuarios base de Laravel

### 2. **add_role_to_users_table**
**Qué hace:** Agrega campos adicionales a la tabla users

```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['admin', 'client'])->default('client');
    $table->string('phone')->nullable();
});
```

### 3. **create_services_table**
**Estructura:**
```php
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->integer('duration'); // minutos
    $table->decimal('price', 8, 2);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 4. **create_professionals_table**
**Estructura:**
```php
Schema::create('professionals', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->string('specialization')->nullable();
    $table->text('bio')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 5. **create_availability_table**
**Estructura:**
```php
Schema::create('availability', function (Blueprint $table) {
    $table->id();
    $table->foreignId('professional_id')
          ->constrained()
          ->onDelete('cascade');
    $table->enum('day_of_week', ['Monday', 'Tuesday', ...]);
    $table->time('start_time');
    $table->time('end_time');
    $table->boolean('is_available')->default(true);
    $table->timestamps();
});
```

### 6. **create_bookings_table**
**Estructura:**
```php
Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('professional_id')->constrained()->onDelete('cascade');
    $table->foreignId('service_id')->constrained()->onDelete('cascade');
    $table->date('booking_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
          ->default('pending');
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

**Relaciones de Cascada:**
- Si se elimina un usuario, se eliminan sus reservas
- Si se elimina un profesional, se eliminan sus reservas
- Si se elimina un servicio, se eliminan las reservas asociadas

---

## 🌱 Seeders

### 1. **UserSeeder**
**Qué hace:** Crea usuarios de prueba

**Datos creados:**
- 1 Administrador (admin@booking.com / password)
- 4 Clientes de prueba (todos con password: password)

```php
User::create([
    'name' => 'Administrador',
    'email' => 'admin@booking.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'phone' => '+34 600 000 000',
]);
```

### 2. **ServiceSeeder**
**Qué hace:** Crea servicios típicos de un salón

**Servicios creados:**
1. Corte de Cabello (30 min - $25)
2. Corte y Peinado (60 min - $45)
3. Coloración (120 min - $80)
4. Mechas/Highlights (90 min - $95)
5. Manicura (45 min - $20)
6. Pedicura (60 min - $35)
7. Manicura Semipermanente (60 min - $35)
8. Tratamiento Capilar (45 min - $40)
9. Alisado/Keratina (180 min - $150)
10. Depilación Facial (30 min - $15)

### 3. **ProfessionalSeeder**
**Qué hace:** Crea profesionales especializados

**Profesionales creados:**
1. María García - Peluquería y Coloración
2. Carlos Rodríguez - Barbería y Cortes Modernos
3. Ana Martínez - Manicura y Pedicura
4. Laura Sánchez - Tratamientos Capilares
5. Javier López - Estilismo Integral

### 4. **AvailabilitySeeder**
**Qué hace:** Define horarios de trabajo

**Horarios creados:**
- Lunes a Viernes: 9:00-14:00 y 16:00-20:00
- Sábado: 9:00-14:00

**Lógica:**
```php
foreach ($professionals as $professional) {
    foreach ($workDays as $day) {
        Availability::create([
            'professional_id' => $professional->id,
            'day_of_week' => $day,
            'start_time' => '09:00',
            'end_time' => '14:00',
            'is_available' => true,
        ]);
    }
}
```

### 5. **BookingSeeder**
**Qué hace:** Crea reservas de ejemplo con diferentes estados

**Reservas creadas:**
- 2 confirmadas (futuras)
- 2 pendientes (futuras)
- 1 completada (pasada)
- 1 cancelada (pasada)

### 6. **DatabaseSeeder**
**Qué hace:** Ejecuta todos los seeders en el orden correcto

**Orden de ejecución:**
```php
$this->call([
    UserSeeder::class,         // Primero usuarios
    ServiceSeeder::class,      // Luego servicios
    ProfessionalSeeder::class, // Luego profesionales
    AvailabilitySeeder::class, // Luego disponibilidad
    BookingSeeder::class,      // Finalmente reservas
]);
```

---

## ⚙️ Instalación y Configuración

### Requisitos
- PHP 8.4+
- Composer
- SQLite o MySQL

### Pasos de Instalación

1. **Clonar el proyecto:**
```bash
cd /ruta/del/proyecto
```

2. **Instalar dependencias:**
```bash
composer install
```

3. **Configurar base de datos:**
```bash
cp .env.example .env
# Editar .env para configurar la base de datos
```

4. **Generar clave de aplicación:**
```bash
php artisan key:generate
```

5. **Ejecutar migraciones y seeders:**
```bash
php artisan migrate:fresh --seed
```

6. **Iniciar servidor de desarrollo:**
```bash
php artisan serve
```

7. **Acceder a la aplicación:**
```
http://localhost:8000
```

### Credenciales de Prueba
**Administrador:**
- Email: admin@booking.com
- Password: password

**Cliente:**
- Email: juan.perez@example.com
- Password: password

---

## 📖 Uso del Sistema

### Para Clientes

1. **Registrarse/Iniciar Sesión**
   - Crear una cuenta nueva o iniciar sesión

2. **Hacer una Reserva**
   ```php
   // Ruta: /bookings/create
   - Seleccionar un servicio
   - Elegir un profesional
   - Seleccionar fecha y hora
   - Agregar notas opcionales
   ```

3. **Ver Mis Reservas**
   ```php
   // Ruta: /bookings
   - Lista de todas las reservas
   - Estados: Pendiente, Confirmada, Completada, Cancelada
   ```

4. **Cancelar una Reserva**
   ```php
   // Ruta: /bookings/{id}
   - Botón "Cancelar Reserva"
   ```

### Para Administradores

1. **Panel de Administración**
   - Ver todas las reservas del sistema
   - Ver todos los usuarios

2. **Gestionar Reservas**
   - Confirmar reservas pendientes
   - Marcar como completadas
   - Cancelar si es necesario

3. **Gestionar Servicios**
   - Crear nuevos servicios
   - Editar precios y duraciones
   - Activar/desactivar servicios

4. **Gestionar Profesionales**
   - Agregar nuevos profesionales
   - Modificar horarios de disponibilidad
   - Activar/desactivar profesionales

---

## 🔍 Flujo de una Reserva

### 1. Cliente Solicita Reserva
```php
// El usuario accede al formulario
GET /bookings/create

// Se cargan servicios y profesionales activos
$services = Service::where('is_active', true)->get();
$professionals = Professional::active()->get();
```

### 2. Validación de Datos
```php
POST /bookings

// Se validan los datos
- Servicio existe y está activo
- Profesional existe y está activo
- Fecha es hoy o futura
- Hora tiene formato correcto
```

### 3. Verificación de Disponibilidad
```php
// Se calcula la hora de fin
$service = Service::find($service_id);
$endTime = $startTime->copy()->addMinutes($service->duration);

// Se verifica que no haya conflictos
$conflict = Booking::where('professional_id', $professional_id)
    ->where('booking_date', $date)
    ->where(/* horarios se solapan */)
    ->exists();
```

### 4. Creación de la Reserva
```php
if (!$conflict) {
    Booking::create([...]);
    // Estado inicial: 'pending'
}
```

### 5. Confirmación por Administrador
```php
// El admin actualiza el estado
$booking->update(['status' => 'confirmed']);
```

### 6. Día de la Cita
```php
// Se marca como completada
$booking->update(['status' => 'completed']);
```

---

## 🎨 Características Avanzadas

### Sistema de Scopes
Los scopes permiten consultas reutilizables:

```php
// En el modelo Booking
public function scopePending($query) {
    return $query->where('status', 'pending');
}

// Uso:
$pendientes = Booking::pending()->get();
```

### Eager Loading
Optimización de consultas con relaciones:

```php
// Mal (N+1 queries)
$bookings = Booking::all();
foreach ($bookings as $booking) {
    echo $booking->user->name; // Query por cada iteración
}

// Bien (2 queries)
$bookings = Booking::with('user')->get();
foreach ($bookings as $booking) {
    echo $booking->user->name; // Sin queries adicionales
}
```

### Validación de Conflictos
Sistema que previene doble reserva:

```php
$conflict = Booking::where('professional_id', $id)
    ->where('booking_date', $date)
    ->where('status', '!=', 'cancelled')
    ->where(function ($query) use ($start, $end) {
        // Verifica solapamiento de horarios
        $query->whereBetween('start_time', [$start, $end])
              ->orWhereBetween('end_time', [$start, $end]);
    })
    ->exists();
```

---

## 🚀 Posibles Mejoras Futuras

1. **Sistema de Notificaciones**
   - Email de confirmación
   - Recordatorios 24h antes
   - SMS para confirmaciones

2. **Calendario Interactivo**
   - Vista de calendario mensual
   - Drag & drop para reprogramar
   - Visualización de disponibilidad en tiempo real

3. **Pagos Online**
   - Integración con Stripe/PayPal
   - Reserva con pago anticipado
   - Historial de pagos

4. **Reportes y Estadísticas**
   - Servicios más solicitados
   - Profesionales más populares
   - Ingresos por período

5. **Sistema de Reseñas**
   - Calificación de profesionales
   - Comentarios de clientes
   - Promedio de puntuaciones

6. **API REST**
   - Endpoints para aplicación móvil
   - Autenticación con tokens
   - Documentación con Swagger

---

## 📝 Conclusión

Este sistema de reserva de turnos es una demostración completa de las capacidades de Laravel 12, mostrando:

- ✅ Arquitectura MVC bien estructurada
- ✅ Relaciones Eloquent complejas
- ✅ Validaciones robustas
- ✅ Scopes y query builders
- ✅ Migraciones y seeders
- ✅ Controladores con lógica de negocio
- ✅ Sistema de permisos básico (admin/client)
- ✅ Prevención de conflictos
- ✅ Documentación completa

El código está completamente comentado y sigue las mejores prácticas de Laravel, haciéndolo ideal como base para proyectos reales o como material de aprendizaje.

---

**Desarrollado con Laravel 12.40.2**
**PHP 8.4.15**
**SQLite / MySQL**
