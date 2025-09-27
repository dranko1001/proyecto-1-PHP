fetch("../CONTROLLERS/consultar_cargoCantidad.php")
  .then((response) => response.json())
  .then((data) => {
    console.log("Datos recibidos:", data); 
    const labels = data.map((item) => item.cargos);
    const valores = data.map((item) => item.cantidad);

    const ctx = document.getElementById("graficoCargo").getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Empleados por cargo",
            data: valores,
            backgroundColor: "rgba(247, 39, 12, 0.5)",
            borderColor: "rgba(161, 34, 3, 1)",
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: { y: { beginAtZero: true } },
      },
    });
  })
  .catch((error) => console.error("Error al cargar los datos:", error));
