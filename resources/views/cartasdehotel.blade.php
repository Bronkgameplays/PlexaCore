<!DOCTYPE html>

<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Habitaciones - Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 15px;
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .estado {
      font-weight: bold;
    }
  </style>
</head>
<body class="p-4">

  <div class="container">
    <h2 class="text-center mb-4">Gestión de Habitaciones</h2>

```
<div class="row" id="habitaciones-container"></div>

<hr class="my-5">

<h4>Inventario de Habitaciones</h4>
<div class="table-responsive">
  <table class="table table-striped text-center" id="tablaInventario">
    <thead class="table-dark">
      <tr>
        <th># Habitación</th>
        <th>Conductor</th>
        <th>Estado</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
```

  </div>

  <script>
    const habitaciones = Array.from({ length: 10 }, (_, i) => ({
      id: i + 1,
      conductor: "",
      estado: "Disponible"
    }));

    const contenedor = document.getElementById("habitaciones-container");
    const tabla = document.querySelector("#tablaInventario tbody");

    function renderCards() {
      contenedor.innerHTML = "";
      habitaciones.forEach(h => {
        const card = document.createElement("div");
        card.className = "col-md-4 mb-4";
        card.innerHTML = `
          <div class="card shadow p-3">
            <div class="card-body text-center">
              <h5 class="card-title">Habitación ${h.id}</h5>
              <p class="estado ${h.estado === "Disponible" ? "text-success" : "text-danger"}">${h.estado}</p>
              <input type="text" class="form-control mb-2" placeholder="Nombre del conductor" id="conductor-${h.id}" ${h.estado === "Ocupada" ? "disabled" : ""}>
              <button class="btn btn-primary w-100" onclick="asignarHabitacion(${h.id})" ${h.estado === "Ocupada" ? "disabled" : ""}>Asignar habitación</button>
            </div>
          </div>`;
        contenedor.appendChild(card);
      });
    }

    function renderTabla() {
      tabla.innerHTML = "";
      habitaciones.forEach(h => {
        tabla.innerHTML += `
          <tr>
            <td>${h.id}</td>
            <td>${h.conductor || "-"}</td>
            <td class="${h.estado === "Disponible" ? "text-success" : "text-danger"}">${h.estado}</td>
            <td>
              ${h.estado === "Ocupada" 
                ? `<button class="btn btn-danger btn-sm" onclick="desasignar(${h.id})">Desasignar</button>`
                : `<button class="btn btn-secondary btn-sm" disabled>Libre</button>`
              }
            </td>
          </tr>`;
      });
    }

    function asignarHabitacion(id) {
      const habitacion = habitaciones.find(h => h.id === id);
      const input = document.getElementById(`conductor-${id}`);
      const nombre = input.value.trim();

      if (!nombre) {
        alert("Por favor ingrese el nombre del conductor.");
        return;
      }

      habitacion.conductor = nombre;
      habitacion.estado = "Ocupada";

      alert(`La habitación ${id} ha sido asignada correctamente a ${nombre}.`);

      renderCards();
      renderTabla();
    }

    function desasignar(id) {
      const habitacion = habitaciones.find(h => h.id === id);
      habitacion.conductor = "";
      habitacion.estado = "Disponible";

      renderCards();
      renderTabla();
    }

    // Inicializar vista
    renderCards();
    renderTabla();
  </script>

</body>
</html>
