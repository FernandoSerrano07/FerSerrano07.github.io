<?php
require 'fpdf/fpdf.php';

 // Conectar a la base de datos
 $conexion = new mysqli("localhost", "root", "", "sistema");

 if ($conexion->connect_error) {
     die("Error de conexión a la base de datos: " . $conexion->connect_error);
 }

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $fecha = $_POST["fecha"];
    $tecnico = $_POST["tecnico"];
    $telefono = $_POST["telefono"];
    $cliente = $_POST["cliente"];
    $contacto = $_POST["contacto"];
    $direccion = $_POST["direccion"];
    $tipoServicio = $_POST["tipo_servicio"];
    $fallaSolicitud = $_POST["falla_solicitud"];
    $diagnosticoResultado = $_POST["diagnostico_resultado"];
    $serviciosBrindados = $_POST["servicios_brindados"];
    $firmaBase64 = $_POST["firma"];
    $firmaBase64_2 = $_POST["firma2"];
    $firmaBase64_3 = $_POST["firma3"];

    $firma = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $firmaBase64));
    $firma2 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $firmaBase64_2));
    $firma3 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $firmaBase64_3));

    $firmaPath = 'firma.png';
    $firmaPath2 = 'firma2.png';
    $firmaPath3 = 'firma3.png';

    file_put_contents($firmaPath, $firma);
    file_put_contents($firmaPath2, $firma2);
    file_put_contents($firmaPath3, $firma3);

    // Llamar a la función para generar y mostrar el PDF
    generarPDF($fecha, $tecnico, $telefono, $cliente, $contacto, $direccion, $tipoServicio, $fallaSolicitud, $diagnosticoResultado, $serviciosBrindados, $firmaPath, $firmaPath2, $firmaPath3);
}

// Función para generar y mostrar el PDF
function generarPDF($fecha, $tecnico, $telefono, $cliente, $contacto, $direccion, $tipoServicio, $fallaSolicitud, $diagnosticoResultado, $serviciosBrindados, $firmaPath, $firmaPath2, $firmaPath3)
{
    $pdf = new FPDF();
    $pdf->AddPage();

    // Añadir imagen de fondo si es necesario
    $pdf->Image('hoja.jpeg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetTextColor(0, 0, 0); // Establecer color de texto negro

    // Títulos
    $pdf->SetXY(10, 10);
    $pdf->Cell(0, 10, '', 0, 1, 'C');

    // Contenido
    $pdf->SetXY(115, 33);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, '' . $fecha);

    $pdf->SetXY(50, 39);
    $pdf->Cell(0, 10, '' . $tecnico);

    $pdf->SetXY(160, 39);
    $pdf->Cell(0, 10, '' . $telefono);

    $pdf->SetXY(50, 45);
    $pdf->Cell(0, 10, '' . $cliente);

    $pdf->SetXY(35, 50);
    $pdf->Cell(0, 10, '' . $contacto);

    $pdf->SetXY(35, 56);
    $pdf->Cell(0, 10, '' . $direccion);

    $pdf->SetXY(45, 63);
    $pdf->Cell(0, 10, '' . $tipoServicio);

    $pdf->SetXY(35, 71);
    $pdf->SetFont('Arial', '', 13); // Ajusta el tamaño de la letra
    $pdf->MultiCell(0, 7, '' . $fallaSolicitud, 0, 'L'); // Ajusta la alineación a la izquierda

    // Nuevo campo con texto grande después de Falla o Solicitud Reportada
    $pdf->SetXY(35, 88);
    $pdf->SetFont('Arial', '', 13); // Ajusta el tamaño de la letra
    $pdf->MultiCell(160, 7, '' . $diagnosticoResultado);

    // Nuevos campos con texto grande uno al lado del otro
    $pdf->SetXY(9, 113);
    $pdf->MultiCell(80, 7, ' ' . $serviciosBrindados);

    // Campo de dibujo
    $pdf->Image($firmaPath, 90, 120, 100, 90);

    // Campo de firma cliente
    $pdf->Image($firmaPath2, 162, 220, 40, 30);

    // Campo de firma técnico
    $pdf->Image($firmaPath3, 162, 265, 40, 30);

    // Agregar segunda página
    $pdf->AddPage();

    // Contenido de la segunda página
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetTextColor(0, 0, 0); // Establecer color de texto negro
    $pdf->SetXY(10, 10);
    $pdf->Cell(0, 10, 'Segunda Página', 0, 1, 'C');

    // Puedes agregar más contenido según tus necesidades en la segunda página

    // Salida del PDF al navegador
    $pdf->Output();
}
?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>sistema B-tech</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="images/fevicon.png" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />

      <script src = "jSignature/jquery.js"></script>
    <script src = "jSignature/jSignature.min.js"></script>
    <script src = "jSignature/modernizr.js"></script>
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
<!-- Formulario HTML con estilos de Bootstrap -->
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fecha">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="tecnico">Técnico:</label>
                    <input type="text" class="form-control" id="tecnico" name="tecnico" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="cliente">Cliente/Empresa:</label>
                    <input type="text" class="form-control" id="cliente" name="cliente" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="contacto">Contacto:</label>
                    <input type="text" class="form-control" id="contacto" name="contacto" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tipo_servicio">Tipo de Servicio:</label>
                    <input type="text" class="form-control" id="tipo_servicio" name="tipo_servicio" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="falla_solicitud">Falla o Solicitud Reportada:</label>
                    <textarea class="form-control" id="falla_solicitud" name="falla_solicitud" rows="5" required></textarea>
                </div>

                <!-- Nuevo campo -->
                <div class="form-group col-md-6">
                    <label for="diagnostico_resultado">diagnostico / Resultado:</label>
                    <textarea class="form-control" id="diagnostico_resultado" name="diagnostico_resultado" rows="5" required></textarea>
                </div>
            </div>

            <!-- Nuevos campos -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="servicios_brindados">Servicios Brindados y productos Utilizados en esta Orden:</label>
                    <textarea class="form-control" id="servicios_brindados" name="servicios_brindados" rows="9" required></textarea>
                </div>

                <div class="form-group col-md-6">
        <label for="firma">Programa de Ubicacion de Sistema Aprobado por Cliente:</label>
        <!-- Ajusta el ancho y alto del canvas según tus preferencias y agrega clases de Bootstrap -->
        <canvas id="firmaCanvas" class="form-control border border-dark rounded" style="width: 100%; max-width: 500px; height: 200px;"></canvas>
        <button type="button" class="btn btn-danger mt-2" id="borrarFirma">Borrar Firma</button>
        <input type="hidden" name="firma" id="firmaInput">
    </div>
</div>

     
            <!-- Campos de firma -->
            <div class="form-row">
            <div class="form-group col-md-6">
        <label for="firma2">Firma Cliente:</label>
        <!-- Ajusta el ancho y alto del canvas según tus preferencias y agrega clases de Bootstrap -->
        <canvas id="firmaCanvas2" class="form-control border border-dark rounded" style="width: 100%; max-width: 500px; height: 200px;"></canvas>
        <button type="button" class="btn btn-danger mt-2" id="borrarFirma2">Borrar Firma</button>
        <input type="hidden" name="firma2" id="firmaInput2">
    </div>
    <div class="form-group col-md-6">
        <label for="firma3">Firma De Tecnico:</label>
        <!-- Ajusta el ancho y alto del canvas según tus preferencias y agrega clases de Bootstrap -->
        <canvas id="firmaCanvas3" class="form-control border border-dark rounded" style="width: 100%; max-width: 500px; height: 200px;"></canvas>
        <button type="button" class="btn btn-danger mt-2" id="borrarFirma3">Borrar Firma</button>
        <input type="hidden" name="firma3" id="firmaInput3">
    </div>

    

</div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
             
      <!-- Scripts de Bootstrap y Signature Pad -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

   


     <!-- Scripts de Bootstrap y Signature Pad -->
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

    <script>
    // Inicializar Signature Pad para la Firma 1
    var canvas = document.getElementById('firmaCanvas');
    var signaturePad = new SignaturePad(canvas);

    // Botón para borrar la Firma 1
    document.getElementById('borrarFirma').addEventListener('click', function (e) {
        e.preventDefault();
        signaturePad.clear();
    });

    // Al enviar el formulario, convertir la firma a base64 y establecer el valor del campo oculto
    document.querySelector('form').addEventListener('submit', function (e) {
        var firmaInput = document.getElementById('firmaInput');
        firmaInput.value = signaturePad.isEmpty() ? '' : signaturePad.toDataURL();
    });

    // Inicializar Signature Pad para la Firma 2
    var canvas2 = document.getElementById('firmaCanvas2');
    var signaturePad2 = new SignaturePad(canvas2);

    // Botón para borrar la Firma 2
    document.getElementById('borrarFirma2').addEventListener('click', function (e) {
        e.preventDefault();
        signaturePad2.clear();
    });

    // Al enviar el formulario, convertir la firma 2 a base64 y establecer el valor del campo oculto 2
    document.querySelector('form').addEventListener('submit', function (e) {
        var firmaInput2 = document.getElementById('firmaInput2');
        firmaInput2.value = signaturePad2.isEmpty() ? '' : signaturePad2.toDataURL();
    });

    // Inicializar Signature Pad para la Firma 3
    var canvas3 = document.getElementById('firmaCanvas3');
    var signaturePad3 = new SignaturePad(canvas3);

    // Botón para borrar la Firma 3
    document.getElementById('borrarFirma3').addEventListener('click', function (e) {
        e.preventDefault();
        signaturePad3.clear();
    });

    // Al enviar el formulario, convertir la firma 3 a base64 y establecer el valor del campo oculto 3
    document.querySelector('form').addEventListener('submit', function (e) {
        var firmaInput3 = document.getElementById('firmaInput3');
        firmaInput3.value = signaturePad3.isEmpty() ? '' : signaturePad3.toDataURL();
    });
</script>
   </body>
</html>