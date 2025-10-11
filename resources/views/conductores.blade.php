<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conductores CloudFleet</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Listado de Conductores (CloudFleet)</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Tipo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($conductores as $index => $conductor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $conductor['personalId'] ?? '—' }}</td>
                    <td>{{ $conductor['firstName'] ?? '—' }}</td>
                    <td>{{ $conductor['lastName'] ?? '—' }}</td>
                    <td>{{ $conductor['email'] ?? '—' }}</td>
                    <td>{{ $conductor['landlinePhone'] ?? '—' }}</td>
                    <td>{{ $conductor['position'] ?? '—' }}</td>
                    <td>{{ $conductor['isActive'] ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
