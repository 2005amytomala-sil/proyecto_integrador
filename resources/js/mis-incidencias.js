document.addEventListener('DOMContentLoaded', () => {
    // 1. Verificamos que estemos únicamente en la pantalla "mis-incidencias"
    const page = document.querySelector('[data-page="mis-incidencias"]');
    if (!page) return;

    // 2. Capturamos los elementos del HTML
    const tbody = document.querySelector('#mis-incidencias-table tbody');
    const searchInput = document.querySelector('#mis-incidencias-search');
    const estadoSelect = document.querySelector('#filter-estado');
    const prioridadSelect = document.querySelector('#filter-prioridad');
    const tipoSelect = document.querySelector('#filter-tipo');
    const clearButton = document.querySelector('#clear-filters');
    const countText = document.querySelector('#incidencias-count');

    let misIncidencias = [];

    // 3. Petición a la API para traer SOLO mis incidencias
    fetch('/api/mis-incidencias', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return response.json();
        })
        .then(data => {
            misIncidencias = data;
            cargarFiltros(misIncidencias);
            renderizarTabla(misIncidencias);
        })
        .catch(error => {
            console.error('Error al cargar mis incidencias:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-danger py-4">
                        Ocurrió un error al cargar sus incidencias.
                    </td>
                </tr>`;
        });

    // 4. Llena las opciones de los combos sin repetir valores
    function cargarFiltros(data) {
        llenarSelect(estadoSelect, data.map(i => i.estado?.nombre));
        llenarSelect(prioridadSelect, data.map(i => i.prioridad?.nombre));
        llenarSelect(tipoSelect, data.map(i => i.tipo_incidencia?.nombre));
    }

    function llenarSelect(select, valores) {
        const unicos = [...new Set(valores.filter(Boolean))];
        unicos.forEach(valor => {
            const option = document.createElement('option');
            option.value = valor;
            option.textContent = valor;
            select.appendChild(option);
        });
    }

    // 5. Clases de color para los estados y prioridades
    function getEstadoBadgeClass(nombre) {
        switch ((nombre || '').trim().toLowerCase()) {
            case 'registrada': return 'bg-primary';
            case 'en proceso': return 'bg-warning text-dark';
            case 'resuelta': return 'bg-success';
            case 'cerrada': return 'bg-dark';
            default: return 'bg-secondary';
        }
    }

    function getPrioridadBadgeClass(nombre) {
        switch ((nombre || '').trim().toLowerCase()) {
            case 'baja': return 'bg-success';
            case 'media': return 'bg-warning text-dark';
            case 'alta': return 'bg-danger';
            default: return 'bg-secondary';
        }
    }

    // 6. Construye las filas de la tabla
    function renderizarTabla(data) {
        tbody.innerHTML = '';
        countText.textContent = `Mostrando ${data.length} incidentes`;

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        No se encontraron incidencias registradas.
                    </td>
                </tr>`;
            return;
        }

        data.forEach(incidencia => {
            const fila = document.createElement('tr');
            const estadoNombre = incidencia.estado?.nombre ?? '-';
            const prioridadNombre = incidencia.prioridad?.nombre ?? '-';

            fila.innerHTML = `
                <td>${incidencia.id}</td>
                <td><strong>${incidencia.titulo}</strong></td>
                <td>${incidencia.tipo_incidencia?.nombre ?? '-'}</td>
                <td>${incidencia.subtipo_incidencia?.nombre ?? '-'}</td>
                <td>${incidencia.ciudad?.nombre ?? '-'}</td>
                <td><span class="badge ${getEstadoBadgeClass(estadoNombre)}">${estadoNombre}</span></td>
                <td><span class="badge ${getPrioridadBadgeClass(prioridadNombre)}">${prioridadNombre}</span></td>
                <td class="text-end">
                    <a href="/incidencias/${incidencia.id}" class="btn btn-sm btn-outline-primary" title="Ver Detalle">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            `;

            tbody.appendChild(fila);
        });
    }

    // 7. Filtrado instantáneo en la memoria del navegador
    function aplicarFiltros() {
        const texto = searchInput.value.toLowerCase();
        const estado = estadoSelect.value;
        const prioridad = prioridadSelect.value;
        const tipo = tipoSelect.value;

        const filtradas = misIncidencias.filter(i => {
            const coincideTexto =
                i.titulo.toLowerCase().includes(texto) ||
                (i.descripcion && i.descripcion.toLowerCase().includes(texto));

            const coincideEstado = !estado || i.estado?.nombre === estado;
            const coincidePrioridad = !prioridad || i.prioridad?.nombre === prioridad;
            const coincideTipo = !tipo || i.tipo_incidencia?.nombre === tipo;

            return coincideTexto && coincideEstado && coincidePrioridad && coincideTipo;
        });

        renderizarTabla(filtradas);
    }

    // 8. Event Listeners
    searchInput.addEventListener('input', aplicarFiltros);
    estadoSelect.addEventListener('change', aplicarFiltros);
    prioridadSelect.addEventListener('change', aplicarFiltros);
    tipoSelect.addEventListener('change', aplicarFiltros);

    clearButton.addEventListener('click', () => {
        searchInput.value = '';
        estadoSelect.value = '';
        prioridadSelect.value = '';
        tipoSelect.value = '';
        renderizarTabla(misIncidencias);
    });
});