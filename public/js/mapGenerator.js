// Referencias de los elementos.
const dificultadSelect = document.getElementById('dificultad');
const personalizadoInputs = document.getElementById('personalizadoInputs');
const form = document.getElementById('formDificultad');
const mapaContainer = document.getElementById('mapaContainer');

// Mostrar u ocultar inputs personalizados según selección.
dificultadSelect.addEventListener('change', () => {
    personalizadoInputs.style.display = dificultadSelect.value === 'personalizado' ? 'flex' : 'none';
});

// Evento al enviar el formulario para generar mapa.
form.addEventListener('submit', async e => {
    e.preventDefault();

    let filas, columnas, minas;

    // Definir parámetros según dificultad seleccionada.
    switch (dificultadSelect.value) {
        case 'facil':
            filas = 9; columnas = 9; minas = 10;
            break;
        case 'medio':
            filas = 16; columnas = 16; minas = 40;
            break;
        case 'dificil':
            filas = 16; columnas = 30; minas = 99;
            break;
        case 'personalizado':
            filas = parseInt(document.getElementById('filas').value);
            columnas = parseInt(document.getElementById('columnas').value);
            minas = parseInt(document.getElementById('minas').value);
            break;
    }

    // Solicitud POST al backend PHP para generar el mapa.
    const response = await fetch('php/generarMapa.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ filas, columnas, minas })
    });

    if (!response.ok) {
        mapaContainer.textContent = 'Error al generar el mapa';
        return;
    }

    const mapa = await response.json();
    mostrarMapa(mapa);
    setUltimoMapa(mapa);
});

// Función para mostrar el mapa en pantalla con estilo de grilla.
function mostrarMapa(mapa) {
    mapaContainer.innerHTML = '';
    const filas = mapa.length;
    const columnas = mapa[0].length;
    mapaContainer.style.gridTemplateColumns = `repeat(${columnas}, 30px)`;
    mapaContainer.style.display = 'grid';

    mapa.forEach(fila => {
        fila.forEach(celda => {
            const cellDiv = document.createElement('div');
            cellDiv.classList.add('cell');
            if (celda === 1) {
                cellDiv.classList.add('mine');
                cellDiv.textContent = '💣';
            }
            mapaContainer.appendChild(cellDiv);
        });
    });
}