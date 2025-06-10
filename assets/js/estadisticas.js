// Configuración de gráficos con Chart.js
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de ventas por mes
    const ctxVentas = document.getElementById('ventasPorMes').getContext('2d');
    const ventasChart = new Chart(ctxVentas, {
        type: 'line',
        data: {
            labels: mesesData,
            datasets: [{
                label: 'Ventas ($)',
                data: ventasData,
                borderColor: '#0dcaf0',
                backgroundColor: 'rgba(13, 202, 240, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#0dcaf0'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#0dcaf0'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: '#0dcaf0'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });
    
    // Gráfico de productos por categoría
    const ctxCategorias = document.getElementById('productosPorCategoria').getContext('2d');
    const categoriasChart = new Chart(ctxCategorias, {
        type: 'doughnut',
        data: {
            labels: categoriasData,
            datasets: [{
                data: productosPorCategoriaData,
                backgroundColor: [
                    'rgba(13, 202, 240, 0.8)',
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(111, 66, 193, 0.8)'
                ],
                borderColor: '#212529',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#0dcaf0'
                    }
                }
            }
        }
    });
});