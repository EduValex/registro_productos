# Sistema de Registro de Productos

Este es un sistema web para la gestión de productos, desarrollado con **PHP (sin frameworks), JavaScript/AJAX, PostgreSQL y CSS nativo**. Permite registrar, listar, editar y eliminar productos, asegurando la unicidad del código de cada producto y ofreciendo una navegación fluida entre las páginas.

## 🚀 Características
- Registro de productos con validaciones en **JavaScript** y **PHP**.
- **Verificación de código único** para evitar duplicados en la base de datos.
- **Carga dinámica de sucursales** según la bodega seleccionada mediante **AJAX**.
- **Listado de productos** con opciones para **editar y eliminar**.
- Confirmación antes de eliminar un producto.
- **Navegación fluida** con una barra de navegación.
- **Estilos personalizados** en `styles.css`.

## 🛠️ Tecnologías Utilizadas
- **PHP** (sin frameworks)
- **PostgreSQL** (conexión mediante PDO)
- **JavaScript/AJAX** para la carga dinámica
- **HTML/CSS** (nativo, sin frameworks)
- **Nginx** (puede usarse en lugar de Apache)

## 📌 Requisitos Previos
1. Tener **PHP** instalado en el sistema.
2. Tener **PostgreSQL** instalado y configurado con pgAdmin.
3. Configurar un servidor local como **Nginx** o **Apache**.

## 📂 Instalación y Configuración
1. Clonar este repositorio:
   ```sh
   git clone https://github.com/tu_usuario/registro_productos.git
   ```
2. Importar la base de datos (archivo `productos_db.sql`) en PostgreSQL.
3. Configurar la conexión en el archivo `config.php`:
   ```php
   $host = "localhost";
   $dbname = "productos_db";
   $user = "postgres";
   $password = "admin";
   ```
4. Iniciar el servidor y acceder a `http://localhost/registro_productos/`.

## 📜 Estructura del Proyecto
```
registro_productos/
├── css/
│   ├── styles.css
├── js/
│   ├── cargar_sucursales.js
├── includes/
│   ├── navbar.php
├── agregar_producto.php
├── editar_producto.php
├── eliminar_producto.php
├── lista_productos.php
├── index.php
└── config.php
```

## ✨ Funcionalidades Clave
- **AJAX** para cargar sucursales dinámicamente según la bodega.
- **Mensajes de éxito/error amigables** en la interfaz.
- **Seguridad**: Uso de `htmlspecialchars()` y `prepared statements` en SQL.
- **Código estructurado y modular** para facilitar futuras mejoras.

## ⚡ Próximos Mejoras
- Implementar **paginación** en la lista de productos.
- Agregar **filtros y búsqueda** en la tabla de productos.
- Mejorar la interfaz con algún framework CSS opcional (**Bootstrap/Tailwind**).

## 📌 Autor
Creado por EduValex.  - www.valexmarketing.com -
Si tienes alguna consulta o sugerencia, ¡no dudes en contactarme! 🚀

