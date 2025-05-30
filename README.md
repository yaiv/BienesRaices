# Bienes Raíces 🏡

Aplicación web para la gestión y visualización de propiedades inmobiliarias. Desarrollada con enfoque full-stack, integrando tecnologías de frontend modernas con una arquitectura backend basada en PHP y MySQL.

## 🚀 Funcionalidades

- ✅ Diseño web responsive y accesible (HTML + SCSS)
- 🌙 Modo oscuro con JavaScript
- 📱 Navegación adaptable a dispositivos móviles
- 🔐 Autenticación de usuarios con PHP 
- 🏘️ CRUD completo para propiedades
- - ##Proximas funcionalidades
- 🧑‍💼 CRUD para vendedores
- 🗂️ Implementación del patrón MVC para mostrar datos dinámicos en frontend

## 🛠️ Tecnologías Utilizadas

### Frontend
- HTML5
- SCSS modular
- JavaScript (Vanilla)


## 📁 Estructura del SCSS

```plaintext
base/
  ├── normalize.scss
  ├── variables.scss
  ├── mixins.scss
  ├── globales.scss
  ├── utilidades.scss
  └── botones.scss

layout/
  ├── header.scss
  ├── footer.scss
  ├── navegacion.scss
  ├── iconos.scss
  ├── anuncios.scss
  ├── contactar.scss
  ├── inferior.scss
  ├── testimonial.scss
  └── formulario.scss

internas/
  └── nosotros.scss
```

## 📸 Vista previa Pagina

![Página Bienes Raices](./cc.png)

### Backend
- PHP 8 (Programación Orientada a Objetos)
- MySQL (MySQL Workbench)
- Patrón MVC (proximamente)...   

```plaintext
admin/
  ├──propiedades/
    ├── actualizar.php
    ├── crear
  └── index.php

PROYECTOBIENESRAICES/
  ├── anuncio.php
  ├── anuncios.php
  ├── base.php
  ├── blog.php
  ├── cerrar-sesion.php
  ├── contacto.php
  ├── entrada.php
  ├── index.php
  └── login.php

````

## 📸 Vista previa Propiedades

![Página de Propiedades 2025](./cc1.png)


## 📸 Vista previa Administracion

![Página Administracion 2025](./cc2.png)


## 📦 Instalación y Uso
Clona el repositorio: https://github.com/yaiv/BienesRaices.git  
Baja las dependencias de json  
Instala la configuracion de Gulp  
Importa la base de datos en MySQL:
  Abre MySQL Workbench o phpMyAdmin  
  Crea una base de datos llamada bienesraices_crud
  Importa el archivo database/bienesraices_crud.sql

Configura los datos de conexión en:
  includes/config/database.php

Inicia el servidor local (con Apache o PHP embebido):
php -S localhost:3000



📝 Autor
Desarrollado por Yair Guerra (yaiv).





