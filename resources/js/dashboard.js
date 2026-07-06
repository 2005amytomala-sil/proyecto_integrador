document.addEventListener('DOMContentLoaded', function () {
    if (!document.querySelector('[data-page="dashboard"]')) return;

    fetch('/api/incidencias')
        .then(response => response.json())
        .then(incidencias => {
            const total = incidencias.length;

            const registradas = incidencias.filter(i =>
                i.estado && i.estado.nombre === 'Registrada'
            ).length;

            const enProceso = incidencias.filter(i =>
                i.estado && i.estado.nombre === 'En proceso'
            ).length;

            const resueltas = incidencias.filter(i =>
                i.estado && i.estado.nombre === 'Resuelta'
            ).length;

            const totalEl = document.getElementById('totalIncidencias');
            const registradasEl = document.getElementById('totalRegistradas');
            const enProcesoEl = document.getElementById('totalEnProceso');
            const resueltasEl = document.getElementById('totalResueltas');

            if (totalEl) totalEl.textContent = total;
            if (registradasEl) registradasEl.textContent = registradas;
            if (enProcesoEl) enProcesoEl.textContent = enProceso;
            if (resueltasEl) resueltasEl.textContent = resueltas;
        })
        .catch(error => {
            console.error('Error al cargar incidencias:', error);
        });
});