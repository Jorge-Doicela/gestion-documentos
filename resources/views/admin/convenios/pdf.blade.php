<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Convenios de Práctica</title>
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
    <h2>Listado de Convenios de Práctica</h2>
    <table>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Firmado por Instituto</th>
                <th>Firmado por Empresa</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($convenios as $convenio)
                <tr>
                    <td>{{ $convenio->empresa->nombre }}</td>
                    <td>{{ $convenio->fecha_inicio->format('d/m/Y') }}</td>
                    <td>{{ $convenio->fecha_fin->format('d/m/Y') }}</td>
                    <td>{{ $convenio->firmado_por_instituto }}</td>
                    <td>{{ $convenio->firmado_por_empresa }}</td>
                    <td>{{ $convenio->descripcion ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
