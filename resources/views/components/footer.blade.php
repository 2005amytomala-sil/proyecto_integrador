<footer class="app-footer">
    <div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <div>
            <span class="fw-semibold">Sistema Gestión Incidencias Georreferenciadas</span>
            <span class="text-white-50 ms-1">&copy; {{ date('Y') }}</span>
        </div>
        <div>
            ¿Necesitas ayuda? 
            <a href="mailto:{{ config('app.admin_email') }}?subject=Soporte%20Sistema%20Incidencias" class="footer-link ms-1">
                <i class="bi bi-envelope-fill me-1"></i>Contactar al administrador
            </a>
        </div>
    </div>
</footer>
