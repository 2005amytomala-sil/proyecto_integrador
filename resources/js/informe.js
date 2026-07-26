document.addEventListener('DOMContentLoaded', function () {

    const formulario = document.getElementById('formFiltros');

    if (!formulario) return;

    document.querySelectorAll('.filtro-auto').forEach(function (control) {

        control.addEventListener('change', function () {
            formulario.submit();
        });

    });

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


    const ctxEvolucion = document.getElementById('graficoEvolucionProvincia');
    if(ctxEvolucion && window.evolucionMensual){
        new Chart(ctxEvolucion, {
            type:'line',
            data:{
                labels: window.evolucionMensual.labels,
                datasets:[
                    {
                        label:'Incidencias registradas',
                        data: window.evolucionMensual.datasets[0].data,
                        tension:0.4,
                        fill:false,
                        pointRadius:5,
                        pointHoverRadius:7
                    }
                ]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false,
                plugins:{

                    legend:{
                        position:'top'
                    },

                    tooltip:{

                        callbacks:{

                            label:function(context){

                                return context.raw + ' incidencias';

                            }

                        }

                    }

                },


                scales:{

                    y:{

                        beginAtZero:true,

                        ticks:{
                            precision:0
                        },

                        title:{
                            display:true,
                            text:'Cantidad de incidencias'
                        }
                    },
                    x:{
                        title:{
                            display:true,
                            text:'Mes'
                        }
                    }
                }
            }
        });
    }

});

