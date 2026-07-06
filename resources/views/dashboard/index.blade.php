@extends('layouts.app')

@section('content')

<div class="container-fluid p-4" data-page="dashboard">
	<h2>Panel de Control</h2>
	<p class="text-muted">Resumen general del sistema de incidencias</p>

	<div class="row g-4 mt-2">
		<div class="col-md-3">
			<div class="card shadow-sm">
				<div class="card-body">
					<p class="text-muted mb-1">Incidencias Totales</p>
					<h3 id="totalIncidencias">0</h3>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card shadow-sm">
				<div class="card-body">
					<p class="text-muted mb-1">Registradas</p>
					<h3 id="totalRegistradas">0</h3>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card shadow-sm">
				<div class="card-body">
					<p class="text-muted mb-1">En proceso</p>
					<h3 id="totalEnProceso">0</h3>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card shadow-sm">
				<div class="card-body">
					<p class="text-muted mb-1">Resueltas</p>
					<h3 id="totalResueltas">0</h3>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection

@push('scripts')
    @vite('resources/js/dashboard.js')
@endpush
