document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('[data-page="incidencias"]');

    if (!page) return;

    const tbody = document.querySelector('#incidencias-table tbody');
    const searchInput = document.querySelector('#incidencias-search');
    const estadoSelect = document.querySelector('#filter-estado');
    const prioridadSelect = document.querySelector('#filter-prioridad');
    const tipoSelect = document.querySelector('#filter-tipo');
    const clearButton = document.querySelector('#clear-filters');
    const countText = document.querySelector('#incidencias-count');

    let incidencias = [];

    fetch('/api/incidencias')
        .then(response => response.json())
        .then(data => {
            incidencias = data;
            cargarFiltros(incidencias);
            renderizarTabla(incidencias);
        })
        .catch(error => {
            console.error('Error al cargar incidencias:', error);
        });

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

    function getEstadoBadgeClass(nombre) {
        switch ((nombre || '').trim().toLowerCase()) {
            case 'registrada':
                return 'bg-primary';
            case 'en proceso':
                return 'bg-warning text-dark';
            case 'resuelta':
                return 'bg-success';
            case 'cerrada':
                return 'bg-dark';
            case 'pendiente':
                return 'bg-secondary';
            default:
                return 'bg-info text-dark';
        }
    }

    function getPrioridadBadgeClass(nombre) {
        switch ((nombre || '').trim().toLowerCase()) {
            case 'baja':
                return 'bg-success';
            case 'media':
            case 'media-baja':
            case 'moderada':
                return 'bg-warning text-dark';
            case 'alta':
            case 'urgente':
                return 'bg-danger';
            default:
                return 'bg-secondary';
        }
    }

    function renderizarTabla(data) {
        tbody.innerHTML = '';

        countText.textContent = `Mostrando ${data.length} incidentes`;

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        No se encontraron incidentes.
                    </td>
                </tr>
            `;
            return;
        }

        data.forEach(incidencia => {
            const fila = document.createElement('tr');
            const estadoNombre = incidencia.estado?.nombre ?? '-';
            const prioridadNombre = incidencia.prioridad?.nombre ?? '-';

            fila.innerHTML = `
                <td>${incidencia.id}</td>
                <td>${incidencia.titulo}</td>
                <td>${incidencia.tipo_incidencia?.nombre ?? '-'}</td>
                <td>${incidencia.subtipo_incidencia?.nombre ?? '-'}</td>
                <td>${incidencia.ciudad?.nombre ?? '-'}</td>
                <td>${incidencia.ciudadano?.nombres ?? ''} ${incidencia.ciudadano?.apellidos ?? ''}</td>
                <td><span class="badge ${getEstadoBadgeClass(estadoNombre)}">${estadoNombre}</span></td>
                <td><span class="badge ${getPrioridadBadgeClass(prioridadNombre)}">${prioridadNombre}</span></td>
                <td>
                     <a href="/incidencias/${incidencia.id}" class="btn btn-sm btn-outline-primary" title="Ver">
                        <i class="bi bi-eye"></i>
                    </a>

                    <a href="/incidencias/${incidencia.id}/edit" class="btn btn-sm btn-outline-secondary" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </td>
            `;

            tbody.appendChild(fila);
        });
    }

    function aplicarFiltros() {
        const texto = searchInput.value.toLowerCase();
        const estado = estadoSelect.value;
        const prioridad = prioridadSelect.value;
        const tipo = tipoSelect.value;

        const filtradas = incidencias.filter(i => {
            const coincideTexto =
                i.titulo.toLowerCase().includes(texto) ||
                i.descripcion.toLowerCase().includes(texto);

            const coincideEstado = !estado || i.estado?.nombre === estado;
            const coincidePrioridad = !prioridad || i.prioridad?.nombre === prioridad;
            const coincideTipo = !tipo || i.tipo_incidencia?.nombre === tipo;

            return coincideTexto && coincideEstado && coincidePrioridad && coincideTipo;
        });

        renderizarTabla(filtradas);
    }

    searchInput.addEventListener('input', aplicarFiltros);
    estadoSelect.addEventListener('change', aplicarFiltros);
    prioridadSelect.addEventListener('change', aplicarFiltros);
    tipoSelect.addEventListener('change', aplicarFiltros);

    clearButton.addEventListener('click', () => {
        searchInput.value = '';
        estadoSelect.value = '';
        prioridadSelect.value = '';
        tipoSelect.value = '';

        renderizarTabla(incidencias);
    });
});