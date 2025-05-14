# 🦸 DC's Absolute Comics Store

¡Bienvenido a **DC's Absolute Comics Store**!  
Este es un e-commerce completo hecho como proyecto final de la materia **Programación para Internet** de la carrera *Ingeniería en Sistemas y TI* en la Universidad Anáhuac México Norte.

---

## 🛠️ Tecnologías Usadas

- **HTML5, CSS3 & Bootstrap 5**
- **JavaScript (mínimo)**
- **PHP (Programación Backend)**
- **MySQL (Base de Datos)**
- **jQuery (opcional)**
- **Sistema de sesiones**
- **Diseño responsivo**

---

## 📦 Funcionalidades

### 🛍️ Catálogo
- **30 productos** disponibles.
- Filtros por serie de cómics.
- Paginación automática.
- Vista de detalle con precio, descripción e imagen.

### 🛒 Carrito de Compras
- Agregar productos (si estás logueado).
- Modificar cantidades.
- Eliminar artículos del carrito.
- Total dinámico.
- Finalizar compra (actualiza inventario + guarda historial).

### 🔐 Autenticación de Usuarios
- Registro con datos básicos y dirección de envío.
- Inicio de sesión con verificación de contraseña encriptada.
- Sesiones seguras y persistentes.
- Cierre de sesión.

### 🧑‍💻 Panel de Administración (solo para el admin)
- Vista y gestión de productos.
- Agregar, editar y eliminar cómics.
- Vista de historial de compras global.
- Control de acceso exclusivo al admin (`id_usuario = 1`).

---

## 📱 Responsivo

Diseñado para funcionar en desktop, tablet y móviles usando Bootstrap y media queries personalizadas.

---

## 🧪 Verificación del Checklist

| Elemento                         | Cumplido ✅ |
|----------------------------------|-------------|
| Catálogo con 30+ productos       | ✅          |
| Vista detallada con imagen       | ✅          |
| Menú en todas las páginas        | ✅          |
| Navegación funcional             | ✅          |
| Sistema de usuarios              | ✅          |
| Sesión mantenida                 | ✅          |
| Carrito funcional completo       | ✅          |
| Página de administración         | ✅          |
| Modificación y alta de productos | ✅          |
| Historial de compras             | ✅          |
| Sitio responsivo                 | ✅          |
| Base de datos estructurada       | ✅          |
| Registro e inicio de sesión      | ✅          |
| Finalizar compra                 | ✅          |

---

## 📂 Estructura del Proyecto

```
comic-shop/
├── admin/               # Panel de administración
├── assets/css/          # Estilos CSS
├── functions/           # Scripts PHP funcionales (carrito, auth, checkout)
├── includes/            # Header, nav, footer y conexión a DB
├── pages/               # Todas las vistas principales (catalog, cart, login, etc.)
└── README.md
```

---

## 🚀 Cómo ejecutar el proyecto

1. Clona o descarga el repositorio.
2. Configura tu base de datos local con el esquema `tienda_comics`.
3. Cambia tus credenciales de MySQL en `includes/db.php`.
4. Inicia tu servidor local (XAMPP, MAMP, etc.).
5. Abre el sitio en `http://localhost/comic-shop/pages/index.php`.

---

## ✍️ Autor

**Carlos Vertti**  
Universidad Anáhuac México Norte  
Materia: *Programación para Internet*

---

## 🦾 Extra

Este proyecto fue desarrollado aplicando principios de:
- Usabilidad
- Seguridad básica
- Buenas prácticas en diseño web
- Arquitectura MVC básica (por organización)

---

¡Gracias por visitar el Absolute Universe! 🚀  
