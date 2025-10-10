

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Archivo CSS propio -->

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

  <div class="container">
    <h2 class="text-center mb-4"> Gestión de Habitaciones </h2>


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


  </div>

  <!-- Bootstrap JS -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Archivo JS propio -->

  <script src="{{ asset('js/script.js') }}"></script>

</body>

