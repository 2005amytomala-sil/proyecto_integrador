@extends('layouts.app')

@section('content')

<div class="container-fluid p-4" data-page="dashboard">
	<h2>Panel de Control</h2>
	<p class="text-muted">Resumen general del sistema de incidencias</p>

	<div class="row g-4 mt-2">
		<div class="col-md-3">
			<div class="card shadow-sm dashboard-stat-card">
				<div class="card-body">
					<p class="text-muted mb-1">Incidencias Totales</p>
					<h3 id="totalIncidencias">0</h3>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card shadow-sm dashboard-stat-card">
				<div class="card-body">
					<p class="text-muted mb-1">Registradas</p>
					<h3 id="totalRegistradas">0</h3>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card shadow-sm dashboard-stat-card">
				<div class="card-body">
					<p class="text-muted mb-1">En proceso</p>
					<h3 id="totalEnProceso">0</h3>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card shadow-sm dashboard-stat-card">
				<div class="card-body">
					<p class="text-muted mb-1">Resueltas</p>
					<h3 id="totalResueltas">0</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-4 mt-4">
		<div class="col-lg-6">
			<div class="card shadow-sm h-100 dashboard-card">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h5 class="mb-1">Incidencias por estado</h5>
							<p class="text-muted small mb-0">Distribución de los estados actuales</p>
						</div>
					</div>
					<div class="chart-wrapper mb-0">
						<canvas id="estadoChart"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="card shadow-sm h-100 dashboard-card">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h5 class="mb-1">Incidencias por prioridad</h5>
							<p class="text-muted small mb-0">Volumen según urgencia</p>
						</div>
					</div>
					<div class="chart-wrapper mb-0">
						<canvas id="prioridadChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-4 mt-4">
		<div class="col-12">
			<div class="card shadow-sm h-100 dashboard-card">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h5 class="mb-1">Incidencias por categoría</h5>
							<p class="text-muted small mb-0">Clasificación por tipo de incidente</p>
						</div>
					</div>
					<div class="chart-wrapper mb-0">
						<canvas id="tipoChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-4 mt-4">
		<div class="col-12">
			<div class="card shadow-sm h-100 dashboard-card">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h5 class="mb-1">Tendencia mensual</h5>
							<p class="text-muted small mb-0">Incidencias reportadas en los últimos 6 meses</p>
						</div>
					</div>
					<div class="chart-wrapper mb-0">
						<canvas id="tendenciaChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-4 mt-4">
		<div class="col-12">
			<div class="card shadow-sm dashboard-card">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<div>
							<h5 class="mb-1">Últimas incidencias</h5>
							<p class="text-muted small mb-0">Los incidentes más recientes registrados en el sistema</p>
						</div>
					</div>
					<div class="table-responsive rounded-4">
						<table class="table table-hover mb-0" id="latest-incidencias-table">
							<thead class="table-light">
								<tr>
									<th>ID</th>
									<th>Título</th>
									<th>Estado</th>
									<th>Prioridad</th>
									<th>Fecha</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<!-- Filas inyectadas por JS -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @vite('resources/js/dashboard.js')
@endpush
