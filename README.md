# Proyecto de Recuperación - Generador de Mapas de Buscaminas

## Descripción
Este proyecto es una aplicación en PHP que genera mapas para el juego Buscaminas según diferentes niveles de dificultad.  
No incluye la lógica completa del juego, solo la generación, guardado y carga de mapas.

## Funcionalidades principales
- Generación de mapas con minas según dificultad:
  - Fácil: 9x9 con 10 minas.
  - Medio: 16x16 con 40 minas.
  - Difícil: 30x16 con 99 minas.
  - Personalizado: tamaño y minas definidos por el usuario.
- Guardado de mapas en formato JSON o XML.
- Carga de mapas previamente guardados.
- Interfaz web básica para elegir dificultad y visualizar el mapa.
- Uso de Git para control de versiones.
- Pruebas unitarias con PHPUnit.
- Dockerización para facilitar despliegue.

## Estructura del proyecto

- `/src` : Código fuente PHP.
- `/public` : Archivos accesibles en frontend.
- `/tests` : Pruebas unitarias con PHPUnit.
- `/data` : Mapas guardados en JSON o XML.
- `README.md` : Este archivo.

## Tecnologías usadas
- PHP 8.2.12
- Bootstrap 5
- AJAX para comunicación frontend-backend
- PHPUnit para pruebas unitarias
- Docker para contenerización

### Requisitos previos
- PHP >= 8.2.12
- Composer
- Docker (opcional, solo si quieres ejecución en contenedor)

### Control de versiones (Git)
- Se sigue una estructura de ramas:
  - `main`: siempre contiene la versión funcional y estable del proyecto.
  - `develop`: rama de desarrollo general.
  - `feature/*`: ramas para funciones específicas (ej. `feature/generar-mapa`).
- Se evita hacer commits directamente en `main`.
- Cada commit lleva un mensaje corto y descriptivo.

### Testing
- Se utiliza PHPUnit para las pruebas unitarias.
- El objetivo es mantener una cobertura de código del 80% al 90%.
- Las pruebas se ubican en `/tests`.

### Pasos para ejecutar

1. Clona el repositorio:
    ```bash
    git clone https://github.com/Zarddark/ProyectoRecuperacion.git
    cd ProyectoRecuperacion
    ```

2. Instalar dependencias:
    ```bash
    composer install
    ```

3. Ejecuta el servidor PHP local (desde la carpeta `public`):
    ```bash
    php -S localhost:8080
    ```

4. Accede en tu navegador a:
    ```
    http://localhost:8080
    ```
### Autor
Antonio José Rodríguez