// Configuración de gráficos con Chart.js
document.addEventListener('DOMContentLoaded', function() {
    // Obtener los datos del servidor que fueron pasados como atributos data-*
    const ventasChart = document.getElementById('ventasPorMes');
    const mesesData = JSON.parse(ventasChart.getAttribute('data-meses') || '[]');
    const ventasData = JSON.parse(ventasChart.getAttribute('data-ventas') || '[]');
    
    const categoriasChart = document.getElementById('productosPorCategoria');
    const categoriasData = JSON.parse(categoriasChart.getAttribute('data-categorias') || '[]');
    const productosPorCategoriaData = JSON.parse(categoriasChart.getAttribute('data-productos') || '[]');
    
    // Gráfico de ventas por mes - muestra la evolución de ventas a lo largo del tiempo
    const ctxVentas = ventasChart.getContext('2d');
    const ventasChartInstance = new Chart(ctxVentas, {
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
    
    // Gráfico de productos por categoría - visualiza la distribución de productos
    const ctxCategorias = categoriasChart.getContext('2d');
    const categoriasChartInstance = new Chart(ctxCategorias, {
        type: 'doughnut',
        data: {
            labels: categoriasData,
            datasets: [{
                data: productosPorCategoriaData,
                backgroundColor: [
                    'rgba(13, 202, 240, 0.8)',  // Azul info
                    'rgba(13, 110, 253, 0.8)',  // Azul primario
                    'rgba(25, 135, 84, 0.8)',   // Verde
                    'rgba(255, 193, 7, 0.8)',   // Amarillo
                    'rgba(220, 53, 69, 0.8)',   // Rojo
                    'rgba(111, 66, 193, 0.8)'   // Púrpura
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