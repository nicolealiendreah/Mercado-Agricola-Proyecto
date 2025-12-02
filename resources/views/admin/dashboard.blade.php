@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-chart-line text-success"></i> Dashboard
            </h1>
            <p class="text-muted mb-0">
                Resumen del mercado: animales, maquinaria y productos orgánicos.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalGanado }}</h3>
                    <p>Animales publicados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cow"></i>
                </div>
                <a href="{{ route('ganados.index') }}" class="small-box-footer">
                    Ver todos los animales <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalMaquinaria }}</h3>
                    <p>Maquinaria publicada</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tractor"></i>
                </div>
                <a href="{{ route('maquinarias.index') }}" class="small-box-footer">
                    Ver toda la maquinaria <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalOrganicos }}</h3>
                    <p>Productos orgánicos publicados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-carrot"></i>
                </div>
                <a href="{{ route('organicos.index') }}" class="small-box-footer text-dark">
                    Ver todos los orgánicos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalPublicaciones }}</h3>
                    <p>Total de publicaciones</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="small-box-footer">
                    Mercado general
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card shadow-sm border-left-success h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-1">
                        <i class="fas fa-calendar-day text-success mr-1"></i> Publicaciones de hoy
                    </h6>
                    <h3 class="mb-0">{{ $totalHoy }}</h3>
                    <small class="text-muted">Animales, maquinaria y orgánicos creados hoy.</small>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card shadow-sm border-left-info h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-1">
                        <i class="fas fa-calendar-week text-info mr-1"></i> Últimos 7 días
                    </h6>
                    <h3 class="mb-0">{{ $totalSemana }}</h3>
                    <small class="text-muted">Nuevas publicaciones en la última semana.</small>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card shadow-sm border-left-warning h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-1">
                        <i class="fas fa-calendar-alt text-warning mr-1"></i> Mes actual
                    </h6>
                    <h3 class="mb-0">{{ $totalMes }}</h3>
                    <small class="text-muted">Publicaciones registradas en el mes en curso.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Participación de Animales</h6>
                        <h3 class="mb-0">{{ $porcentajeGanado }}%</h3>
                        <small class="text-muted">Sobre el total de publicaciones.</small>
                    </div>
                    <i class="fas fa-cow fa-2x text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Participación de Maquinaria</h6>
                        <h3 class="mb-0">{{ $porcentajeMaquinaria }}%</h3>
                        <small class="text-muted">Sobre el total de publicaciones.</small>
                    </div>
                    <i class="fas fa-tractor fa-2x text-info"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Participación de Orgánicos</h6>
                        <h3 class="mb-0">{{ $porcentajeOrganicos }}%</h3>
                        <small class="text-muted">Sobre el total de publicaciones.</small>
                    </div>
                    <i class="fas fa-leaf fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header border-0 bg-light">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-chart-bar text-success mr-1"></i> Publicaciones por categoría
                    </h3>
                </div>
                <div class="card-body">
                    <div style="height: 260px;">
                        <canvas id="graficoCategorias"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header border-0 bg-light">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-chart-area text-success mr-1"></i> Evolución últimos 6 meses
                    </h3>
                </div>
                <div class="card-body">
                    <div style="height: 260px;">
                        <canvas id="graficoMeses"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 d-flex align-items-center bg-light">
                    <i class="fas fa-cow text-success mr-2"></i>
                    <h3 class="card-title mb-0">Animales</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Estadísticas y publicaciones de ganado disponible en el mercado.
                    </p>
                    <ul class="small mb-3">
                        <li>Control de animales registrados.</li>
                        <li>Acceso rápido al listado completo.</li>
                    </ul>
                    <a href="{{ route('ganados.index') }}" class="btn btn-sm btn-success">
                        Ir a animales
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 d-flex align-items-center bg-light">
                    <i class="fas fa-tractor text-info mr-2"></i>
                    <h3 class="card-title mb-0">Maquinaria</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Seguimiento de la oferta de maquinaria agrícola disponible.
                    </p>
                    <ul class="small mb-3">
                        <li>Resumen de equipos publicados.</li>
                        <li>Monitoreo de oferta por tipo.</li>
                    </ul>
                    <a href="{{ route('maquinarias.index') }}" class="btn btn-sm btn-info">
                        Ir a maquinaria
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 d-flex align-items-center bg-light">
                    <i class="fas fa-leaf text-warning mr-2"></i>
                    <h3 class="card-title mb-0">Productos orgánicos</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Visualiza rápidamente la cantidad de productos orgánicos disponibles.
                    </p>
                    <ul class="small mb-3">
                        <li>Control de productos registrados.</li>
                        <li>Acceso rápido a listado y detalles.</li>
                    </ul>
                    <a href="{{ route('organicos.index') }}" class="btn btn-sm btn-warning text-white">
                        Ir a orgánicos
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctxCategorias = document.getElementById('graficoCategorias').getContext('2d');

            new Chart(ctxCategorias, {
                type: 'bar',
                data: {
                    labels: ['Animales', 'Maquinaria', 'Orgánicos'],
                    datasets: [{
                        label: 'Publicaciones registradas',
                        data: [{{ $totalGanado }}, {{ $totalMaquinaria }}, {{ $totalOrganicos }}],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.7)',   
                            'rgba(23, 162, 184, 0.7)',
                            'rgba(255, 193, 7, 0.7)'    
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(23, 162, 184, 1)',
                            'rgba(255, 193, 7, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            var ctxMeses = document.getElementById('graficoMeses').getContext('2d');

            new Chart(ctxMeses, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labelsMeses) !!},
                    datasets: [
                        {
                            label: 'Animales',
                            data: {!! json_encode($ganadoPorMes) !!},
                            borderColor: 'rgba(40, 167, 69, 1)',
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            borderWidth: 2,
                            tension: 0.3
                        },
                        {
                            label: 'Maquinaria',
                            data: {!! json_encode($maquinariaPorMes) !!},
                            borderColor: 'rgba(23, 162, 184, 1)',
                            backgroundColor: 'rgba(23, 162, 184, 0.2)',
                            borderWidth: 2,
                            tension: 0.3
                        },
                        {
                            label: 'Orgánicos',
                            data: {!! json_encode($organicosPorMes) !!},
                            borderColor: 'rgba(255, 193, 7, 1)',
                            backgroundColor: 'rgba(255, 193, 7, 0.2)',
                            borderWidth: 2,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
