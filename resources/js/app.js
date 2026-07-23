document.addEventListener('DOMContentLoaded', function () {
    const btnSidebar = document.getElementById('btnSidebar');
    if (btnSidebar) {
        btnSidebar.addEventListener('click', function () {
            document.body.classList.toggle('sidebar-open');
        });
    }
    
    const notifBadge = document.getElementById('notif-badge');

    if (notifBadge) {
        checkUnreadNotifications();

        // Consultar automáticamente cada 30 segundos
        setInterval(checkUnreadNotifications, 30000);
    }

    function checkUnreadNotifications() {
        fetch('/api/notificaciones/unread-count')
            .then(response => response.json())
            .then(data => {
                const count = typeof data === 'object' ? (data.count ?? data.unread_count ?? 0) : data;

                if (count > 0) {
                    notifBadge.classList.remove('d-none');
                } else {
                    notifBadge.classList.add('d-none');
                }
            })
            .catch(error => console.error('Error al consultar notificaciones no leídas:', error));
    }
});

import './ubicacion';
import './mapa-incidencias';