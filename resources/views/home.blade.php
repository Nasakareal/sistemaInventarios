@extends('adminlte::page')

@section('title', 'Sistema de Inventarios')

@section('content_header')
    <center><h1>Sistema de Mantenimiento</h1></center>
@stop

@section('content')
    <div class="row" id="serviciosContainer">
        <!-- Aquí se generarán los odómetros dinámicamente -->
    </div>
@stop

@section('css')
    <style>
        .servicio-card {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }
        .chart-container {
            width: 100%;
            height: 150px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("{{ route('servicios.json') }}", {
                headers: {
                    "Authorization": "Bearer {{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                let container = document.getElementById("serviciosContainer");

                if (data.length === 0) {
                    container.innerHTML = `<div class='col-12 text-center'><p class='text-muted'>No hay servicios programados.</p></div>`;
                    return;
                }

                let cardHtml = "";

                data.forEach((servicio, index) => {
                    let diasRestantes = servicio.dias_restantes;
                    let porcentaje = Math.max(0, 100 - (diasRestantes / 30) * 100);
                    let color = diasRestantes <= 0 ? "#dc3545" : diasRestantes <= 7 ? "#ffc107" : "#28a745";
                    let estado = diasRestantes <= 0 ? "⚠️ Urgente" : diasRestantes <= 7 ? "⚠️ Próximo" : "✅ En tiempo";

                    cardHtml += `
                        <div class="col-md-4 col-sm-6">
                            <div class="card servicio-card border-${diasRestantes <= 0 ? 'danger' : diasRestantes <= 7 ? 'warning' : 'success'}">
                                <div class="card-header bg-light">
                                    <h5 class="card-title">${servicio.nombre}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="odometro${index}"></canvas>
                                    </div>
                                    <p><strong>Estado:</strong> ${estado}</p>
                                    <p><strong>Días Restantes:</strong> ${diasRestantes} días</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = cardHtml; // 🔥 **Ahora los elementos están en el DOM**

                // 🚀 **Después de añadir las tarjetas, generamos los gráficos**
                data.forEach((servicio, index) => {
                    let diasRestantes = servicio.dias_restantes;
                    let porcentaje = Math.max(0, 100 - (diasRestantes / 30) * 100);
                    let color = diasRestantes <= 0 ? "#dc3545" : diasRestantes <= 7 ? "#ffc107" : "#28a745";

                    let ctx = document.getElementById(`odometro${index}`).getContext("2d");

                    new Chart(ctx, {
                        type: "doughnut",
                        data: {
                            datasets: [{
                                data: [porcentaje, 100 - porcentaje],
                                backgroundColor: [color, "#e0e0e0"]
                            }]
                        },
                        options: {
                            responsive: true,
                            cutout: "80%",
                            plugins: {
                                tooltip: { enabled: false },
                                legend: { display: false }
                            }
                        }
                    });
                });
            })
            .catch(error => {
                document.getElementById("serviciosContainer").innerHTML = `
                    <div class='col-12 text-center'>
                        <p class='text-danger'>Error al cargar datos.</p>
                    </div>
                `;
                console.error("Error cargando los datos:", error);
            });
        });
    </script>
@stop
