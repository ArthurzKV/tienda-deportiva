# 🏀 Tienda Deportiva 🏐

Proyecto tercer parcial: **Tienda Deportiva con PHP**

🌐 **¡Prueba la tienda en línea ahora!**  
Accede al proyecto desplegado en Railway:  
[➡️ Tienda Deportiva](https://tienda-deportiva-production.up.railway.app/index.php)

---

![Logo de la Tienda Deportiva](https://i.imgur.com/thjHzQy.png)

## 📋 Descripción

Este proyecto es una tienda en línea básica desarrollada en **PHP**, diseñada para la administración de productos con un diseño simple pero funcional. Forma parte del proyecto final de la materia **Desarrollo Web**.

### ⚙️ Funcionalidades:

- **Gestión de productos:**
  - Crear, editar y eliminar productos.
  - Ver una tabla dinámica con todos los productos registrados.
- **Formulario amigable:**
  - Campos intuitivos para capturar datos como:
    - Nombre del producto.
    - Descripción.
    - Precio.
    - Stock.
    - Enlace de imagen.
- **Interfaz responsiva:**
  - Estilizada con **TailwindCSS** para una apariencia moderna y profesional.
- **Conexión a base de datos:**
  - MySQL es el motor para almacenar y administrar toda la información de los productos.

---

## 🚀 Tecnologías utilizadas

- **Lenguajes y Frameworks:**
  - PHP
  - MySQL
  - TailwindCSS
- **Despliegue:**
  - Railway para hosting del proyecto.

---

## 🛠️ Cómo ejecutar el proyecto localmente

1. **Clona el repositorio** en tu máquina local:
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   ```
2. **Configura la base de datos MySQL**:
   - Crea una base de datos con las siguientes tablas:
     ```sql
     CREATE TABLE productos (
         id INT AUTO_INCREMENT PRIMARY KEY,
         nombre VARCHAR(100) NOT NULL,
         descripcion TEXT NOT NULL,
         precio DECIMAL(10, 2) NOT NULL,
         stock INT NOT NULL,
         imagen TEXT
     );
     ```
   - Configura las variables de conexión en el código (`MYSQLHOST`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`).
3. **Inicia un servidor local**, como XAMPP o Laragon.
4. Abre el archivo `index.php` en tu navegador.

---

## 👨‍💻 Autores

- **Arturo Ríos Ponce**
- **Juan Pablo Silva**

---

## 📚 Docente

Este proyecto fue desarrollado como proyecto final para la materia **Desarrollo Web**, impartida por la docente **WENDY RANGEL LAMAS GONZÁLEZ**.

---

## 🌟 Capturas de pantalla

### Página principal:
![Logo de la Tienda Deportiva](https://i.imgur.com/thjHzQy.png)

---

🎉 **Gracias por visitar nuestra tienda deportiva virtual.** Si tienes alguna sugerencia o comentario, no dudes en contactarnos. 🚀
