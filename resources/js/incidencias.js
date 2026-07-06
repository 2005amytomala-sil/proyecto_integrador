document.addEventListener('DOMContentLoaded', () => {
    if (!document.querySelector('[data-page="incidencias"]')) return;

    const tableBody = document.querySelector('#incidencias-table tbody');
    const searchInput = document.getElementById('incidencias-search');
    const estadoFilter = document.getElementById('filter-estado');
    const prioridadFilter = document.getElementById('filter-prioridad');
    const tipoFilter = document.getElementById('filter-tipo');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const countLabel = document.getElementById('incidencias-count');

    let incidencias = [];

    function renderRow(inc) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${inc.id}</td>
            <td>${inc.titulo ?? ''}</td>
            <td>${inc.tipo_incidencia?.nombre ?? ''}</td>
            <td>${inc.subtipo_incidencia?.nombre ?? ''}</td>
            <td>${inc.ciudad?.nombre ?? ''}</td>
            <td>${inc.ciudadano?.nombre ?? ''}</td>
            <td>${inc.estado?.nombre ?? ''}</td>
            <td>${inc.prioridad?.nombre ?? ''}</td>
            <td>
                <a href="/incidencias/${inc.id}" class="btn btn-sm btn-outline-secondary">Ver</a>
            </td>
        `;
        return tr;
    }

    function buildOptions(items, selectElement, defaultLabel) {
        const values = Array.from(new Set(items.filter(Boolean))).sort();
        selectElement.innerHTML = `<option value="">${defaultLabel}</option>` +
            values.map(value => `<option value="${value}">${value}</option>`).join('');
    }

    function updateCount(rows) {
        if (countLabel) {
            countLabel.textContent = `Mostrando ${rows.length} incidente${rows.length === 1 ? '' : 's'}`;
        }
    }

    function getFilteredIncidencias() {
        const searchValue = searchInput?.value.trim().toLowerCase() ?? '';
        const estadoValue = estadoFilter?.value ?? '';
        const prioridadValue = prioridadFilter?.value ?? '';
        const tipoValue = tipoFilter?.value ?? '';

        return incidencias.filter(inc => {
            const matchesSearch = searchValue === '' ||
                (inc.titulo && inc.titulo.toLowerCase().includes(searchValue)) ||
                (inc.descripcion && inc.descripcion.toLowerCase().includes(searchValue));

            const matchesEstado = estadoValue === '' || inc.estado?.nombre === estadoValue;
            const matchesPrioridad = prioridadValue === '' || inc.prioridad?.nombre === prioridadValue;
            const matchesTipo = tipoValue === '' || inc.tipo_incidencia?.nombre === tipoValue;

            return matchesSearch && matchesEstado && matchesPrioridad && matchesTipo;
        });
    }

    function renderTable(items) {
        tableBody.innerHTML = '';

        if (items.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">No se encontraron incidentes.</td></tr>';
        } else {
            items.forEach(item => tableBody.appendChild(renderRow(item)));
        }

        updateCount(items);
    }

    function handleFilterChange() {
        renderTable(getFilteredIncidencias());
    }

    function setupFilterData(data) {
        const estados = data.map(item => item.estado?.nombre).filter(Boolean);
        const prioridades = data.map(item => item.prioridad?.nombre).filter(Boolean);
        const tipos = data.map(item => item.tipo_incidencia?.nombre).filter(Boolean);

        if (estadoFilter) buildOptions(estados, estadoFilter, 'Todos los estados');
        if (prioridadFilter) buildOptions(prioridades, prioridadFilter, 'Todas las prioridades');
        if (tipoFilter) buildOptions(tipos, tipoFilter, 'Todas las categorías');
    }

    function attachEvents() {
        if (searchInput) searchInput.addEventListener('input', handleFilterChange);
        if (estadoFilter) estadoFilter.addEventListener('change', handleFilterChange);
        if (prioridadFilter) prioridadFilter.addEventListener('change', handleFilterChange);
        if (tipoFilter) tipoFilter.addEventListener('change', handleFilterChange);
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                if (estadoFilter) estadoFilter.value = '';
                if (prioridadFilter) prioridadFilter.value = '';
                if (tipoFilter) tipoFilter.value = '';
                renderTable(incidencias);
            });
        }
    }

    async function load() {
        try {
            const res = await fetch('/api/incidencias');
            if (!res.ok) throw new Error('Network response was not ok');
            incidencias = await res.json();

            setupFilterData(incidencias);
            renderTable(incidencias);
            attachEvents();
        } catch (err) {
            console.error(err);
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">No se pudieron cargar las incidencias.</td></tr>';
            updateCount([]);
        }
    }

    load();
});
