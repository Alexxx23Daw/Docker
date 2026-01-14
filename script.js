'use strict';

//Obtener referencia al elemento canvas
const $grafica = document.querySelector("#grafica"); 
const $grafica2 = document.querySelector("#grafica2");

// Comprobar que hay datos (el array tiene al menos un elemento)
if (preciosPorHora.length > 0) {
  
  // Extraer las horas y precios desde el array PHP
  const etiquetas = preciosPorHora.map(p => `${p.hora}:00`);
  const datos = preciosPorHora.map(p => p.precio);

  //Color segun precio
  const colores = preciosPorHora.map(p => {
    const precio = parseFloat(p.precio);
      if (precio < 0.1){
        return 'rgba(0, 200, 0, 0.8)';
      }else if(precio < 0.2){
        return 'rgba(255, 215, 0, 0.8)';
      }else{
        return 'rgba(255, 0, 0, 0.8)';
      }
    });

  new Chart($grafica, {
      type: 'bar',
      data: {
        labels: etiquetas,
        datasets: [{
          label: 'Precio de la luz por hora (€ / kWh)',
          data: datos,
          backgroundColor: colores,
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        },
        maintainAspectRatio: false
      }
    });

  new Chart($grafica2, {
  type: 'line',
  data: {
    labels: etiquetas,
    datasets: [{
      label: 'Precio de la luz por hora (€ / kWh)',
      data: datos,
      backgroundColor: 'transparent',
      borderColor: 'orange',
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: false
      }
    }
  }
});

} else {
  console.warn("No hay datos para mostrar en la gráfica.");
}

