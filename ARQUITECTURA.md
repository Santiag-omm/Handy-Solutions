# HANDY SOLUTIONS - Arquitectura del Sistema

## Resumen

Sistema web para gestión de solicitudes de reparación en el hogar: clientes solicitan servicios, el administrador valida y asigna técnicos, se generan cotizaciones y órdenes de trabajo, con notificaciones por email.

## Tecnologías

- **Backend:** Laravel 12, PHP 8.2
- **Base de datos:** MySQL (PlanetScale)
- **Infraestructura:** Railway (Hosting)
- **Dominio:** Gratuito (*.up.railway.app) o Personalizado (Cloudflare)
- **Frontend:** Bootstrap 5, Blade, JavaScript
- **Seguridad:** CSRF, validación, roles, subida segura de archivos

## Estructura de carpetas relevante

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/          # Login, Register, Forgot/Reset Password
│   │   ├── Admin/         # Dashboard, Servicios, Técnicos, Solicitudes, Órdenes, Zonas, Clientes, Pagos
│   │   ├── HomeController.php
│   │   └── SolicitudController.php (público)
│   └── Middleware/
│       └── EnsureUserHasRole.php   # role:admin,tecnico,cliente
├── Models/                # User, Role, Servicio, Solicitud, OrdenTrabajo, etc.
├── Notifications/         # SolicitudRecibida, TecnicoAsignado, ServicioCompletado
├── Policies/
│   └── SolicitudPolicy.php
└── Services/
    ├── CotizacionService.php
    ├── SolicitudService.php
    └── OrdenTrabajoService.php

database/
├── migrations/            # roles, users (extendido), zonas, servicios, tecnicos, solicitudes, cotizaciones, ordenes_trabajo, pagos, resenas, horarios, galeria_trabajos, faqs
└── seeders/               # RoleSeeder, ServicioSeeder, FaqSeeder, AdminSeeder

resources/views/
├── layouts/
│   ├── app.blade.php      # Público
│   └── admin.blade.php    # Panel admin
├── auth/                  # login, register, forgot-password, reset-password
├── home.blade.php, galeria, contacto, faq
├── servicios/             # index, show
├── solicitudes/           # create, show
└── admin/                 # dashboard, servicios, tecnicos, clientes, zonas, solicitudes, ordenes
```

## Modelo de datos (ER)

- **users** — id, name, email, password, role_id, phone, address
- **roles** — id, name, slug, description
- **zonas** — id, nombre, codigo, descripcion, activo
- **servicios** — id, nombre, slug, descripcion, precio_base, precio_min, imagen, orden, activo
- **tecnicos** — id, user_id, especialidades, calificacion_promedio, total_servicios, activo
- **tecnico_zona** — tecnico_id, zona_id (pivot)
- **solicitudes** — id, folio, user_id, servicio_id, zona_id, direccion, descripcion_problema, fecha_deseada, urgencia, estado, fotos (json), observaciones_admin, soft deletes
- **cotizaciones** — id, solicitud_id, monto, tipo (automatica|manual), observaciones, ajustado_por
- **ordenes_trabajo** — id, codigo, solicitud_id, tecnico_id, cotizacion_id, asignado_por, fecha_asignada, estado, notas_tecnico, soft deletes
- **pagos** — id, orden_trabajo_id, monto, metodo, estado, referencia, fecha_pago
- **resenas** — id, orden_trabajo_id, user_id, calificacion, comentario, visible
- **horarios** — id, tecnico_id, dia_semana, hora_inicio, hora_fin, activo
- **galeria_trabajos** — id, orden_trabajo_id, imagen, titulo, descripcion, servicio_id, orden, destacado, visible
- **faqs** — id, pregunta, respuesta, orden, activo

## Flujo de una solicitud

1. Cliente (logueado) envía **solicitud** (servicio, dirección, fotos, urgencia).
2. Se genera **cotización automática** y estado pasa a `cotizada`; se envía email **SolicitudRecibida**.
3. Admin **valida** o rechaza; puede **ajustar cotización** manual.
4. Admin **crea orden de trabajo** y asigna técnico; estado solicitud `asignada`; se envía **TecnicoAsignado** al cliente.
5. Técnico/Admin actualiza estado de la orden: `en_camino` → `en_proceso` → `completada`.
6. Al marcar **completada** se envía **ServicioCompletado** al cliente.
7. Admin registra **pago**; cliente puede dejar **reseña**.

## Rutas principales

- **Público:** `/`, `/servicios`, `/servicios/{slug}`, `/galeria`, `/contacto`, `/faq`
- **Auth:** `/login`, `/register`, `/logout`, `/forgot-password`, `/reset-password`
- **Solicitudes (auth):** `/solicitar-servicio`, `POST /solicitudes`, `/solicitudes/{id}`
- **Admin (auth + role:admin|tecnico):** `/admin` (dashboard), `/admin/servicios`, `/admin/tecnicos`, `/admin/clientes`, `/admin/zonas`, `/admin/solicitudes`, `/admin/ordenes`, `/admin/pagos`

## Seguridad

- CSRF en todos los formularios.
- Middleware `auth` en panel y solicitudes.
- Middleware `role:admin,tecnico` en rutas `/admin/*`.
- Validación en controladores (Request).
- Subida de imágenes: `image`, `mimes`, `max:5120` (5MB); almacenamiento en `storage/app/public`.

## Cómo ejecutar

1. `composer install`
2. Copiar `.env.example` a `.env`, configurar `DB_*` (MySQL).
3. `php artisan key:generate`
4. `php artisan migrate`
5. `php artisan db:seed`
6. `php artisan storage:link`
7. `php artisan serve`

**Acceso por defecto:** admin@handyplus.com / password
