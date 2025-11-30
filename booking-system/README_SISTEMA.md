# 📅 Sistema de Reserva de Turnos - Laravel

Sistema completo de gestión de turnos desarrollado en Laravel 12, ideal para salones de belleza, spas, consultorios médicos y cualquier negocio que requiera gestión de citas.

## 🌟 Características

- **Gestión de Usuarios**: Sistema de roles (Administrador/Cliente)
- **Servicios**: Catálogo completo con precios y duraciones
- **Profesionales**: Gestión de personal con especialidades
- **Reservas**: Sistema inteligente que previene conflictos de horarios
- **Disponibilidad**: Horarios configurables por profesional
- **Estados de Reserva**: Pendiente, Confirmada, Cancelada, Completada

## 🚀 Instalación Rápida

```bash
# 1. Instalar dependencias
composer install

# 2. Configurar base de datos
cp .env.example .env

# 3. Generar clave de aplicación
php artisan key:generate

# 4. Crear base de datos y cargar datos de prueba
php artisan migrate:fresh --seed

# 5. Iniciar servidor
php artisan serve
```

## 👥 Credenciales de Prueba

### Administrador
- **Email**: admin@booking.com
- **Password**: password

### Cliente
- **Email**: juan.perez@example.com
- **Password**: password

## 📚 Estructura del Proyecto

```
app/
├── Models/
│   ├── User.php          # Usuario (Admin/Cliente)
│   ├── Service.php       # Servicio (Corte, Manicura, etc.)
│   ├── Professional.php  # Profesional que brinda el servicio
│   ├── Booking.php       # Reserva de turno
│   └── Availability.php  # Disponibilidad horaria
│
└── Http/Controllers/
    ├── BookingController.php      # Gestión de reservas
    ├── ServiceController.php      # Gestión de servicios
    └── ProfessionalController.php # Gestión de profesionales

database/
├── migrations/           # Esquema de base de datos
└── seeders/             # Datos de ejemplo
```

## 💡 Modelos y Relaciones

### User (Usuario)
- Tiene muchas reservas (`bookings`)
- Puede ser `admin` o `client`

### Service (Servicio)
- Tiene muchas reservas
- Define duración y precio

### Professional (Profesional)
- Tiene muchas reservas
- Tiene horarios de disponibilidad
- Tiene especialización

### Booking (Reserva)
- Pertenece a un usuario
- Pertenece a un profesional
- Pertenece a un servicio
- Tiene estados: pending, confirmed, cancelled, completed

### Availability (Disponibilidad)
- Pertenece a un profesional
- Define día de la semana y horarios

## 🔧 Funcionalidades Principales

### Para Clientes
1. Registrarse e iniciar sesión
2. Ver servicios disponibles
3. Crear reservas
4. Ver historial de reservas
5. Cancelar reservas

### Para Administradores
1. Ver todas las reservas del sistema
2. Confirmar/cancelar reservas
3. Gestionar servicios (crear, editar, desactivar)
4. Gestionar profesionales
5. Configurar horarios de disponibilidad

## 📊 Servicios Incluidos (Datos de Ejemplo)

1. **Corte de Cabello** - 30 min - $25
2. **Corte y Peinado** - 60 min - $45
3. **Coloración** - 120 min - $80
4. **Mechas/Highlights** - 90 min - $95
5. **Manicura** - 45 min - $20
6. **Pedicura** - 60 min - $35
7. **Manicura Semipermanente** - 60 min - $35
8. **Tratamiento Capilar** - 45 min - $40
9. **Alisado/Keratina** - 180 min - $150
10. **Depilación Facial** - 30 min - $15

## 🧑‍💼 Profesionales Incluidos (Datos de Ejemplo)

- **María García** - Peluquería y Coloración
- **Carlos Rodríguez** - Barbería y Cortes Modernos
- **Ana Martínez** - Manicura y Pedicura
- **Laura Sánchez** - Tratamientos Capilares
- **Javier López** - Estilismo Integral

## ⏰ Horarios de Trabajo

**Lunes a Viernes:**
- Mañana: 9:00 - 14:00
- Tarde: 16:00 - 20:00

**Sábado:**
- Mañana: 9:00 - 14:00

## 🔐 Validaciones Implementadas

### Creación de Reservas
- ✅ El servicio debe existir y estar activo
- ✅ El profesional debe existir y estar activo
- ✅ La fecha debe ser hoy o futura
- ✅ No puede haber conflictos de horario
- ✅ El horario debe estar dentro de la disponibilidad del profesional

### Conflictos de Horario
El sistema verifica automáticamente que:
- El profesional no tenga otra reserva a la misma hora
- La nueva reserva no se solape con reservas existentes
- Las reservas canceladas no bloquean horarios

## 📖 Documentación Completa

Para una documentación detallada de cada clase, método y funcionalidad, consulta el archivo `DOCUMENTACION.md`.

## 🛠️ Tecnologías Utilizadas

- **Laravel**: 12.40.2
- **PHP**: 8.4.15
- **Base de Datos**: SQLite (configurable a MySQL/PostgreSQL)
- **Eloquent ORM**: Para relaciones y consultas
- **Migraciones**: Control de versiones de la BD
- **Seeders**: Datos de prueba automatizados

## 🎯 Casos de Uso

### Ejemplo 1: Cliente hace una reserva
```
1. Cliente inicia sesión
2. Selecciona "Corte de Cabello" ($25, 30 min)
3. Elige a "María García" como profesional
4. Selecciona fecha: 2025-12-01, hora: 10:00
5. Sistema calcula fin automáticamente: 10:30
6. Sistema verifica que María no tenga otra reserva 10:00-10:30
7. Crea la reserva con estado "Pendiente"
8. Admin confirma la reserva
```

### Ejemplo 2: Prevención de conflictos
```
Reserva existente:
- María García
- 2025-12-01, 10:00-10:30

Nueva reserva intenta:
- María García
- 2025-12-01, 10:15-10:45

❌ Sistema rechaza: "El profesional ya tiene una reserva en ese horario"
```

## 🚧 Próximas Mejoras

- [ ] Interfaz de usuario con Blade/Vue.js
- [ ] Sistema de notificaciones por email
- [ ] Calendario visual interactivo
- [ ] Pagos online integrados
- [ ] API REST para aplicación móvil
- [ ] Sistema de reseñas y calificaciones
- [ ] Reportes y estadísticas avanzadas
- [ ] Recordatorios automáticos

## 📝 Licencia

Este proyecto es una demostración educativa desarrollada con fines de aprendizaje.

## 👨‍💻 Soporte

Para preguntas o consultas sobre el código, revisa la documentación completa en `DOCUMENTACION.md`.

---

**¿Necesitas ayuda?** Todos los modelos, controladores y seeders están completamente documentados con comentarios en español explicando qué hace cada clase y método.
