// Variable global que almacena el último mapa generado
let ultimoMapa = null;

// Función para actualizar el mapa guardado (se llama desde otro script, ej. generarmapa.js)
function setUltimoMapa(mapa) {
    ultimoMapa = mapa;
}

// Ejecutar cuando el DOM esté listo para asignar eventos a los botones
document.addEventListener('DOMContentLoaded', () => {
    const btnJSON = document.getElementById('guardarJSON');
    const btnXML = document.getElementById('guardarXML');

    // Evento para guardar el mapa como JSON en el servidor
    if (btnJSON) {
        btnJSON.addEventListener('click', () => {
            if (!ultimoMapa) return alert('Primero genera un mapa');
            guardarMapaEnServidor('json');
        });
    }

    // Evento para guardar el mapa como XML en el servidor
    if (btnXML) {
        btnXML.addEventListener('click', () => {
            if (!ultimoMapa) return alert('Primero genera un mapa');
            guardarMapaEnServidor('xml');
        });
    }
});

// Función que envía el mapa y formato al backend para guardarlo en carpeta /data/
function guardarMapaEnServidor(formato) {
    fetch('php/guardarMapa.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mapa: ultimoMapa, formato })
    })
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            alert('Mapa guardado correctamente en el servidor');
        } else {
            alert('Error al guardar el mapa: ' + data.error);
        }
    })
    .catch(() => {
        alert('Error en la conexión con el servidor');
    });
}
