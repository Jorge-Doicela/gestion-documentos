<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificado Oficial</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 30px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .contenido {
            font-size: 16px;
            margin: 30px 0;
        }

        .firmas {
            margin-top: 60px;
            display: flex;
            justify-content: center;
            gap: 80px;
        }

        .firma {
            border-top: 1px solid black;
            padding-top: 5px;
            width: 200px;
            font-size: 14px;
        }

        .qr {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <h1>CERTIFICADO DE VALIDACIÓN DOCUMENTAL</h1>

    <div class="contenido">
        El Instituto Tecnológico certifica que el estudiante:<br>
        <strong>{{ $estudiante->name }}</strong><br>
        ha completado satisfactoriamente su proceso de revisión y validación de documentos de prácticas
        preprofesionales.
    </div>

    <div class="contenido">
        Fecha de emisión: <strong>{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y H:i') }}</strong><br>
        Firma digital (SHA256): <strong>{{ $hash }}</strong><br>
        Código de verificación: <strong>{{ $uuid }}</strong>
    </div>

    <div class="firmas">
        <div class="firma">Firma del Tutor Académico</div>
        <div class="firma">Firma del Coordinador</div>
    </div>

    @if ($qr)
        <div class="qr">
            <img src="data:image/png;base64,{{ $qr }}" alt="QR de verificación" width="100" height="100">
        </div>
    @endif
</body>

</html>
