<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Empresas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Listado de Empresas</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>RUC</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Contacto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empresas as $empresa)
                <tr>
                    <td>{{ $empresa->nombre }}</td>
                    <td>{{ $empresa->ruc }}</td>
                    <td>{{ $empresa->telefono }}</td>
                    <td>{{ $empresa->email }}</td>
                    <td>{{ $empresa->contacto }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
