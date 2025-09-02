<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Plazas de Práctica</title>
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
    <h2>Listado de Plazas de Práctica</h2>
    <table>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Área</th>
                <th>Período</th>
                <th>Carrera</th>
                <th>Vacantes</th>
                <th>Fechas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plazas as $plaza)
                <tr>
                    <td>{{ $plaza->empresa->nombre }}</td>
                    <td>{{ $plaza->area_practica }}</td>
                    <td>{{ $plaza->periodo_academico }}</td>
                    <td>{{ $plaza->carrera }}</td>
                    <td>{{ $plaza->vacantes }}</td>
                    <td>{{ $plaza->fecha_inicio }} - {{ $plaza->fecha_fin }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
