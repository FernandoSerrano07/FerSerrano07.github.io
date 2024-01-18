<?php
require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', '', );

// Ruta de la imagen de fondo
$imagePath = 'hoja.jpeg';

// Configurar la posición y el tamaño de la imagen de fondo
$pdf->Image($imagePath, 0, 0, 210, 297); // A4 size: 210x297 mm

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha proporcionado un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para obtener los datos del ID específico
    $sql = "SELECT * FROM formulario WHERE id = $id";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error en la consulta: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            // Encabezado de la tabla en el PDF
            // ... otras celdas
            $pdf->Ln();

            // Agregar los datos de la base de datos al PDF
            while ($row = $result->fetch_assoc()) {
                $pdf->SetXY(170, 26);
                $pdf->SetFont('Arial', 'B', 12); // Establecer el formato y el estilo del texto del ID
                $pdf->Cell(10, 7, $row["id"], 0); // Sin bordes
                $pdf->SetFont('Arial', '', 12); // Restaurar formato y estilo del texto
                $pdf->SetXY(50, 45);
                $pdf->Cell(20, 15, $row["fecha"], 0); // Sin bordes
                $pdf->Cell(30, 20, $row["tecnico"], 0); // Sin bordes
                $pdf->Cell(40, 30, $row["telefono"], 0); // Sin bordes
                $pdf->Cell(50, 40, $row["cliente"], 0); // Sin bordes
                $pdf->Cell(60, 50, $row["contacto"], 0); // Sin bordes
                // ... otras celdas
                $pdf->Ln();
            }

            // Establecer un nombre personalizado para el archivo PDF (por ejemplo, usando el nombre del cliente)
            $nombreCliente = $row["cliente"]; // Cambia esto según la columna de tu base de datos que contenga el nombre del cliente
            $pdf_filename = "formulario" . $nombreCliente . ".pdf";

            // Salida del PDF
            $pdf->Output($pdf_filename, 'I');
        } else {
            echo "No se encontraron resultados para el ID $id";
        }
    }
} else {
    echo "ID no proporcionado o no válido";
}

$conn->close();
?>
