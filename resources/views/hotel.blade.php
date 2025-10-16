<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon.png') }}">

    <title>Administracion de Hotel</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <STYle>
        
.habitacion-card {
    flex: 1 1 calc(25% - 1rem); /* 4 cards por fila con gap de 1rem */
    min-width: 250px; /* Evita que se encojan demasiado */
    box-sizing: border-box;
}
.cajas {
    width: 100%;
    display: flex;
    flex-wrap: wrap; /* Permite que se vayan a la siguiente fila */
    gap: 1rem; /* Espacio entre cards */
}
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;

}

.card:hover {
    transform: scale(1.05); /* zoom pequeño */
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    background-color: #f8f9fa; /* o el color que quieras */
}
.card-Ocupada{
        cursor: not-allowed; /* para que el usuario vea que es interactivo */
}
    </STYle>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
         @include('layouts.menu')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                
                <!-- Topbar -->
                @include('layouts.cabecera')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- hotel -->
                    {{-- @include('layouts.gestiondehotel') --}}
                        <h2 class="text-center mb-4"> Gestión de Habitaciones</h2>
                        <div class="cajas">
                            @foreach ($habitaciones as $habitacion)
                                <div class="card card-{{ $habitacion['estado'] ?? '—' }} shadow p-3 habitacion-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Habitación {{ $habitacion['numero'] ?? '—' }}</h5>

                                        <p class="estado {{ ($habitacion['estado'] ?? '') === 'Disponible' ? 'text-success' : 'text-danger' }}">
                                            {{ $habitacion['estado'] ?? '—' }}
                                        </p>

                                        <input type="text"
                                            class="form-control mb-2"
                                            placeholder="Nombre del conductor"
                                            value="{{ $habitacion->hconductor->nombre ?? '' }} {{ $habitacion->hconductor->apellido ?? '' }}"
                                            id="conductor-{{ $habitacion['numero'] }}"
                                            {{ ($habitacion['estado'] ?? '') === 'Ocupada' ? 'disabled' : '' }}>

                                        <button class="btn btn-primary w-100"
                                                onclick="asignarHabitacion({{ $habitacion['numero'] ?? '—' }})"
                                                {{ ($habitacion['estado'] ?? '') === 'Ocupada' ? 'disabled' : '' }}>
                                            Asignar habitación
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
             @include('layouts.pie')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para partir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccionaste "Cerrar Sesion" a continuación si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="login.html">Cerrar Sesion</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>