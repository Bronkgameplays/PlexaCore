<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon.png') }}">
    <title>Administración de Hotel</title>

    <!-- Fonts y estilos -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .habitacion-card {
            flex: 1 1 calc(25% - 1rem);
            min-width: 250px;
            box-sizing: border-box;
        }

        .cajas {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card {
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 1;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            background-color: #f8f9fa;
            z-index: 2;
        }

        .card-Ocupada {
            cursor: not-allowed;
        }

        /* 🔍 Lista de sugerencias */
        .lista-conductores {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 9999 !important;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
            display: none;
        }

        .conductor-item {
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .conductor-item:hover {
            background-color: #e9ecef;
            z-index: 1000;
        }

        .conductor-item strong {
            color: #1a202c;
        }

        .conductor-item .text-muted {
            font-size: 0.9em;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        @include('layouts.menu')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.cabecera')

                <div class="container-fluid">
                    <h2 class="text-center mb-4">Gestión de Habitaciones</h2>

                    <!-- Mensajes -->
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    <div class="cajas">
                        @foreach ($habitaciones as $habitacion)
                            <div class="card card-{{ $habitacion['estado'] ?? '—' }} shadow p-3 habitacion-card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Habitación {{ $habitacion['numero'] ?? '—' }}</h5>

                                    <p class="estado {{ ($habitacion['estado'] ?? '') === 'Disponible' ? 'text-success' : 'text-danger' }}">
                                        {{ $habitacion['estado'] ?? '—' }}
                                    </p>

                                    <div class="mb-2 position-relative">
                                        <input type="text" id="buscadorConductor{{ $habitacion->numero }}"
                                            name="conductor" class="form-control"
                                            placeholder="Escriba cédula o nombre del conductor..."
                                            autocomplete="off">

                                        <div id="listaConductores{{ $habitacion->numero }}" class="lista-conductores">
                                            @foreach ($conductores as $conductor)
                                                <div class="conductor-item"
                                                    data-cedula="{{ $conductor->cedula }}"
                                                    data-nombre="{{ $conductor->nombre }} {{ $conductor->apellido }}">
                                                    <strong>{{ $conductor->nombre }} {{ $conductor->apellido }}</strong>
                                                    <div class="text-muted">{{ $conductor->cedula }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary w-100 mt-2 btn-asignar">
                                        Asignar Habitación
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @include('layouts.pie')
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- JS -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- ✅ SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('[id^="buscadorConductor"]');

            inputs.forEach(input => {
                const habitacion = input.id.replace('buscadorConductor', '');
                const lista = document.getElementById('listaConductores' + habitacion);
                const items = lista.querySelectorAll('.conductor-item');
                const boton = lista.closest('.card').querySelector('.btn-asignar');

                // 🔍 Filtrar conductores
                input.addEventListener('input', () => {
                    const texto = input.value.toLowerCase().trim();
                    let visible = false;

                    items.forEach(item => {
                        const nombre = item.dataset.nombre.toLowerCase();
                        const cedula = item.dataset.cedula.toLowerCase();
                        if (nombre.includes(texto) || cedula.includes(texto)) {
                            item.style.display = 'block';
                            visible = true;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    lista.style.display = visible ? 'block' : 'none';
                });

                // 👆 Seleccionar conductor
                items.forEach(item => {
                    item.addEventListener('click', () => {
                        input.value = item.dataset.nombre;
                        input.setAttribute('data-cedula', item.dataset.cedula);
                        lista.style.display = 'none';
                    });
                });

                // 🚫 Cerrar lista si se hace clic fuera
                document.addEventListener('click', (e) => {
                    if (!lista.contains(e.target) && e.target !== input) {
                        lista.style.display = 'none';
                    }
                });

                // ✅ Validar campos al presionar el botón
                boton.addEventListener('click', (event) => {
                    event.preventDefault();
                    const conductor = input.value.trim();

                    if (!conductor) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos incompletos',
                            text: 'Por favor, seleccione un conductor antes de asignar la habitación.',
                            confirmButtonText: 'Entendido'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Habitación asignada',
                            text: 'La habitación se ha asignado correctamente.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
