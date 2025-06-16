// Obtener referencia al botón de cargar mapa
const btnCargarMapa = document.getElementById('btnCargarMapa');

// Verificar que el botón exista antes de asignar evento
if (btnCargarMapa) {
    // Escuchar clic en el botón para cargar el mapa
    btnCargarMapa.addEventListener('click', async () => {
        // Obtener el nombre del archivo introducido por el usuario y limpiar espacios
        const archivo = document.getElementById('nombreArchivo').value.trim();

        // Si no se ha introducido ningún nombre, mostrar alerta y salir
        if (!archivo) return alert('Introduce el nombre del archivo a cargar');

        // Enviar petición POST al backend para cargar el mapa desde archivo
        const response = await fetch('php/cargarMapa.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ archivo })
        });

        // Si la respuesta no es correcta, mostrar error y salir
        if (!response.ok) {
            alert('Error al cargar el mapa');
            return;
        }

        // Procesar la respuesta JSON recibida
        const resultado = await response.json();

        // Si el backend devuelve un error, mostrar alerta con el mensaje
        if (resultado.error) {
            alert('Error: ' + resultado.error);
        } else {
            // Si no hay error, mostrar el mapa en pantalla
            mostrarMapa(resultado.mapa);

            // Guardar el mapa cargado para posibles acciones futuras
            setUltimoMapa(resultado.mapa);
        }
    });
}
