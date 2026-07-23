document.addEventListener('DOMContentLoaded', function () {
    
    function actualizarBadgeNotificaciones() {
        const badge = document.getElementById('notif-badge');
        if (!badge) return;

        fetch('/api/notificaciones/unread-count')
            .then(res => res.json())
            .then(data => {
                if (data.unread > 0) {
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }
            })
            .catch(err => console.error('Error al obtener badge:', err));
    }

    actualizarBadgeNotificaciones();

    if (!document.querySelector('[data-page="notificaciones"]')) return;

    let filtroEstado = 'todos';
    let filtroBuscar = '';
    let filtroOrden = 'desc';

    const container = document.getElementById('notificacionesContainer');
    const inputBuscar = document.getElementById('buscarNotificacion');
    const selectOrden = document.getElementById('ordenarNotificacion');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const totalCountEl = document.getElementById('totalCount');

    function cargarNotificaciones() {
        const params = new URLSearchParams({
            estado: filtroEstado,
            buscar: filtroBuscar,
            orden: filtroOrden
        });

        fetch(`/api/notificaciones?${params.toString()}`)
            .then(res => res.json())
            .then(data => {
                renderNotificaciones(data);
                actualizarBadgeNotificaciones();
            })
            .catch(err => console.error('Error al cargar notificaciones:', err));
    }

    function renderNotificaciones(lista) {
        totalCountEl.textContent = `${lista.length} notificaciones`;

        if (lista.length === 0) {
            container.innerHTML = `
                <div class="p-5 text-center text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    No se encontraron notificaciones.
                </div>`;
            return;
        }

        container.innerHTML = lista.map(item => {
            const esNoLeida = !item.leida;
            const fecha = new Date(item.created_at).toLocaleString('es-ES', {
                dateStyle: 'medium',
                timeStyle: 'short'
            });

            return `
                <a href="/notificaciones/${item.id}/ver" 
                   class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-3 ${esNoLeida ? 'bg-light font-weight-bold' : ''}">
                    
                    <div class="d-flex align-items-center gap-3">
                        <!-- Indicador Punto Azul/Rojo GitHub -->
                        <span class="rounded-circle ${esNoLeida ? 'bg-primary' : 'bg-transparent'}" style="width: 10px; height: 10px; display: inline-block;"></span>
                        
                        <i class="bi bi-bell-fill text-muted"></i>
                        
                        <div>
                            <div class="fw-bold ${esNoLeida ? 'text-dark' : 'text-secondary'}">${item.titulo}</div>
                            <small class="text-muted">${item.mensaje}</small>
                        </div>
                    </div>

                    <div class="text-end text-nowrap ms-3">
                        <small class="text-muted d-block">${fecha}</small>
                        ${esNoLeida ? '<span class="badge bg-primary rounded-pill">Nuevo</span>' : ''}
                    </div>
                </a>
            `;
        }).join('');
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filtroEstado = this.dataset.estado;
            cargarNotificaciones();
        });
    });

    inputBuscar.addEventListener('input', function () {
        filtroBuscar = this.value;
        cargarNotificaciones();
    });

    selectOrden.addEventListener('change', function () {
        filtroOrden = this.value;
        cargarNotificaciones();
    });

    cargarNotificaciones();
});