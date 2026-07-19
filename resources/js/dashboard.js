document.addEventListener('DOMContentLoaded', function () {
    if (!document.querySelector('[data-page="dashboard"]')) return;

    function createChart(context, type, labels, data, options = {}) {
        if (!context) return null;

        return new Chart(context, {
            type,
            data: {
                labels,
                datasets: [
                    {
                        label: options.label || '',
                        data,
                        backgroundColor: options.backgroundColor || [
                            '#3751FF',
                            '#0BC5EA',
                            '#F6AD55',
                            '#48BB78',
                            '#ED64A6',
                            '#A0AEC0',
                            '#F56565',
                        ],
                        borderColor: options.borderColor || '#3751FF',
                        borderWidth: options.borderWidth || 2,
                        fill: options.fill || false,
                        tension: options.tension || 0.4,
                        pointRadius: options.pointRadius || 4,
                        pointBackgroundColor: options.pointBackgroundColor || options.borderColor || '#3751FF',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 14,
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = context.parsed.y ?? context.parsed;
                                return `${context.label}: ${value}`;
                            },
                        },
                    },
                },
                scales: options.scales || {
                    y: {
                        beginAtZero: options.beginAtZero !== undefined ? options.beginAtZero : true,
                        min: options.min,
                        ticks: {
                            precision: 0,
                        },
                    },
                },
            },
        });
    }

    function getLastSixMonths() {
        const now = new Date();
        const months = [];

        for (let i = 5; i >= 0; i--) {
            const date = new Date(now.getFullYear(), now.getMonth() - i, 1);

            months.push({
                label: date.toLocaleString('es-ES', { month: 'short' }),
                year: date.getFullYear(),
                month: date.getMonth() + 1,
            });
        }

        return months;
    }

    function buildTrendData(incidencias) {
        const months = getLastSixMonths();
        const counts = months.map(() => 0);

        incidencias.forEach(incidencia => {
            if (!incidencia.created_at) return;

            const date = new Date(incidencia.created_at);
            const monthKey = `${date.getFullYear()}-${date.getMonth() + 1}`;

            months.forEach((month, index) => {
                if (monthKey === `${month.year}-${month.month}`) {
                    counts[index] += 1;
                }
            });
        });

        return {
            labels: months.map(month => month.label),
            counts,
        };
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

    function countByRelation(incidencias, relation, key) {
        return incidencias.reduce((acc, incidencia) => {
            const obj = incidencia[relation];
            const value = obj && obj[key] ? obj[key] : null;

            if (value) {
                acc[value] = (acc[value] || 0) + 1;
            }

            return acc;
        }, {});
    }

    function renderLatestIncidencias(incidencias) {
        const latestBody = document.querySelector('#latest-incidencias-table tbody');

        if (!latestBody) return;

        const latestIncidencias = [...incidencias]
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
            .slice(0, 6);

        if (latestIncidencias.length === 0) {
            latestBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No hay incidencias recientes.
                    </td>
                </tr>
            `;
            return;
        }

        latestBody.innerHTML = latestIncidencias.map(item => {
            const fecha = item.created_at
                ? new Date(item.created_at).toLocaleDateString('es-ES')
                : '-';

            const estadoNombre = item.estado?.nombre ?? '-';
            const prioridadNombre = item.prioridad?.nombre ?? '-';

            return `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.titulo ?? '-'}</td>
                    <td><span class="badge ${getEstadoBadgeClass(estadoNombre)}">${estadoNombre}</span></td>
                    <td><span class="badge ${getPrioridadBadgeClass(prioridadNombre)}">${prioridadNombre}</span></td>
                    <td>${fecha}</td>
                    <td>
                        <a href="/incidencias/${item.id}" class="btn btn-sm btn-outline-secondary">
                            Ver
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }

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

            const estados = countByRelation(incidencias, 'estado', 'nombre');
            const prioridades = countByRelation(incidencias, 'prioridad', 'nombre');
            const tipos = countByRelation(incidencias, 'tipo_incidencia', 'nombre');

            createChart(
                document.getElementById('estadoChart'),
                'doughnut',
                Object.keys(estados),
                Object.values(estados),
                {
                    label: 'Incidencias por estado',
                    borderColor: '#ffffff',
                    backgroundColor: ['#3b82f6', '#0ea5e9', '#22c55e', '#f97316', '#ef4444'],
                    borderWidth: 2,
                    pointRadius: 0,
                }
            );

            createChart(
                document.getElementById('prioridadChart'),
                'doughnut',
                Object.keys(prioridades),
                Object.values(prioridades),
                {
                    label: 'Incidencias por prioridad',
                    borderColor: '#ffffff',
                    backgroundColor: ['#2563eb', '#f59e0b', '#ef4444', '#10b981'],
                    borderWidth: 2,
                    pointRadius: 0,
                }
            );

            createChart(
                document.getElementById('tipoChart'),
                'doughnut',
                Object.keys(tipos),
                Object.values(tipos),
                {
                    label: 'Incidencias por categoría',
                    borderColor: '#ffffff',
                    backgroundColor: ['#7c3aed', '#0ea5e9', '#14b8a6', '#f97316', '#e11d48'],
                    borderWidth: 2,
                    pointRadius: 0,
                }
            );

            const trend = buildTrendData(incidencias);

            createChart(
                document.getElementById('tendenciaChart'),
                'line',
                trend.labels,
                trend.counts,
                {
                    label: 'Incidencias',
                    borderColor: '#3751FF',
                    backgroundColor: 'rgba(56, 112, 255, 0.14)',
                    fill: true,
                    pointBackgroundColor: '#3751FF',
                    min: 1,
                    beginAtZero: false,
                    scales: {
                        y: {
                            min: 1,
                            beginAtZero: false,
                            ticks: {
                                precision: 0,
                            },
                        },
                    },
                }
            );

            renderLatestIncidencias(incidencias);
        })
        .catch(error => {
            console.error('Error al cargar incidencias:', error);
        });
});