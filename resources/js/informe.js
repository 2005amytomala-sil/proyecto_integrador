document.addEventListener('DOMContentLoaded', function () {

    const formulario = document.getElementById('formFiltros');
    if(formulario){
        document.querySelectorAll('.filtro-auto')
        .forEach(function(control){
            control.addEventListener('change', function(){
                formulario.submit();
            });
        });
    }

    const ctxFlujo = document.getElementById('graficoFlujoEstados');
        if(ctxFlujo && window.flujoEstados){
            new Chart(ctxFlujo, {
                type:'bar',
                data:{
                    labels: window.flujoEstados.labels,
                    datasets:[{
                        label:'Cantidad de incidencias',
                        data:window.flujoEstados.data,
                        backgroundColor:[
                            '#6c757d', // Registrada
                            '#0d6efd', // Validada
                            '#ffc107', // En proceso
                            '#198754', // Resuelta
                            '#dc3545', // Rechazada
                            '#6f42c1'  // Cancelada
                        ],
                        borderRadius:8
                    }]
                },
                options:{
                    responsive:true,
                    maintainAspectRatio:false,
                    plugins:{
                        legend:{
                            display:false
                        }
                    },
                    scales:{
                        y:{
                            beginAtZero:true,
                            ticks:{
                                precision:0
                            }
                        }
                    }
                }
            });
    }

    const ctxCategoria = document.getElementById('graficoCategoria');
    if(ctxCategoria && window.incidenciasCategoria){
        new Chart(ctxCategoria, {
            type:'doughnut',
            data:{
                labels: window.incidenciasCategoria.labels,
                datasets:[{
                    data: window.incidenciasCategoria.data
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false,
                plugins:{
                    legend:{
                        position:'right'
                    },
                    tooltip:{
                        callbacks:{
                            label:function(context){
                                return context.label + ': ' +
                                context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    }

   const ctxEvolucion = document.getElementById(
    'graficoEvolucionTemporal'
    );

    if (ctxEvolucion && window.evolucionTemporal) {
        new Chart(ctxEvolucion, {
            type: 'line',
            data: {
                labels: window.evolucionTemporal.labels,
                datasets: window.evolucionTemporal.datasets.map((dataset) => ({
                    label: dataset.label,
                    data: dataset.data,
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHitRadius: 12
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    title: {
                        display: true,
                        text: window.evolucionTemporal.titulo,
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return (
                                    context.dataset.label +
                                    ': ' +
                                    context.raw +
                                    ' incidencias'
                                );
                            }
                        }
                    }
                },
                elements: {
                    line: {
                        tension: 0.4
                    },
                    point: {
                        radius: 5,
                        hoverRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: 8,

                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    const ctxPrioridad = document.getElementById(
    'graficoPrioridad'
    );


    if(ctxPrioridad && window.prioridad){

        new Chart(ctxPrioridad, {

            type:'bar',

            data:{

                labels: window.prioridad.labels,

                datasets:[{

                    label:'Cantidad de incidencias',

                    data: window.prioridad.data,

                    backgroundColor: window.prioridad.labels.map((prioridad)=>{

                        if(prioridad === 'Alta'){
                            return '#dc3545'; // rojo
                        }

                        if(prioridad === 'Media'){
                            return '#ffc107'; // amarillo
                        }

                        if(prioridad === 'Baja'){
                            return '#198754'; // verde
                        }

                        return '#6c757d'; // cualquier otra prioridad

                    }),

                    borderRadius:8

                }]

            },


            options:{

                indexAxis:'y',


                responsive:true,

                maintainAspectRatio:false,


                plugins:{

                    legend:{
                        display:false
                    },


                    tooltip:{

                        callbacks:{

                            label:function(context){

                                return context.raw +
                                ' incidencias';

                            }

                        }

                    }

                },


                scales:{

                    x:{

                        beginAtZero:true,

                        ticks:{
                            precision:0
                        }

                    }

                }

            }

        });

    }


});

