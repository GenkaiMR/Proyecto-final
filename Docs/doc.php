<?php
include_once('../conexion/connection.php');
$connection = connection();

// Incluir la librería TCPDF
include('../libs/tcpdf.php');

// Obtener los parámetros de la URL usando $_GET
$orderNumber = isset($_GET['orderNumber']) ? $_GET['orderNumber'] : '';
$productType = isset($_GET['TypeProd']) ? $_GET['TypeProd'] : '';
$productName = isset($_GET['NameProd']) ? $_GET['NameProd'] : '';


if($productType === 'Farmaceutico'){


    $Lot = '';

    $sqlLot = "select CONCAT((p.numero), MONTH(o.fechaOrden), YEAR(o.fechaOrden))
                                from pedido as p
                                INNER JOIN orden as o on o.pedido = p.numero
                                where p.numero = ?";
$resultado8 = $connection->prepare($sqlLot);
$resultado8->bind_param('s', $orderNumber);
$resultado8->execute();
$resultado8->store_result();
if ($resultado8->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado8->bind_result($Lot);
    
    // Obtener el primer resultado
    $resultado8->fetch();
}

$sql = "SELECT * FROM vw_PRODORD_info  WHERE noOrden = ? and Lot = ?";
$resultado = $connection->prepare($sql);
$resultado->bind_param('ss', $orderNumber, $Lot);
$resultado->execute();
$resultado->store_result();

$sql2 = "SELECT * FROM vw_PRODORD_formulsOrden  WHERE noOrden = ?";
$resultado2 = $connection->prepare($sql2);
$resultado2->bind_param('s', $orderNumber);
$resultado2->execute();
$resultado2->store_result();

$sql4 = "SELECT * FROM vw_PRODORD_formulsActive  WHERE noOrden = ?";
$resultado4 = $connection->prepare($sql4);
$resultado4->bind_param('s', $orderNumber);
$resultado4->execute();
$resultado4->store_result();

$sql5 = "SELECT codigo FROM producto where nombre = '$productName'";
$resultado5 = $connection->prepare($sql5);
$resultado5->execute();
$resultado5->store_result();
$resultado5->bind_result($codigo);
$resultado5->fetch();
$codigoprod = $codigo;

$sql3 = "SELECT * FROM vw_PRODORD_empaqueOrden  WHERE noOrden = ?  AND codProd = ?";
$resultado3 = $connection->prepare($sql3);
$resultado3->bind_param('ss', $orderNumber, $codigoprod);
$resultado3->execute();
$resultado3->store_result();

$sql6 = "SELECT * FROM vw_PRODORD_formuMatPrima  WHERE noOrden = ?";
$resultado6 = $connection->prepare($sql6);
$resultado6->bind_param('s', $orderNumber);
$resultado6->execute();
$resultado6->store_result();

$sql7 = "SELECT * FROM vw_PRODORD_formuMatPrimaAct  WHERE noOrden = ?";
$resultado7 = $connection->prepare($sql7);
$resultado7->bind_param('s', $orderNumber);
$resultado7->execute();
$resultado7->store_result();


// Inicializar las variables
$order = '';
$lotSize = '';
$capsTab = '';
$totalBlend = '';
$expiration = '';
$tradeMark = '';
$chemicalName = '';
$presentation = '';
$activeIngredients = '';
$activeIngredient = '';
$amountAct = '';
$ingredient = '';
$amountIngr = '';
$material = '';
$forUnit = '';
$totPerOrd = '';
$formuFinalW = '';
$blendFinalW = '';
$codi = '';
$totIngre = '';
$totIngreAct = '';

// Verificar si la consulta tiene resultados
if ($resultado->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado->bind_result($order, $lotSize, $capsTab, $totalBlend,  $tradeMark, 
                            $chemicalName, $presentation, $activeIngredients, $Lot, $expiration, $blendFinalW, $formuFinalW);
    
    // Obtener el primer resultado
    $resultado->fetch();
}

if ($resultado2->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado2->bind_result($order, $ingredient, $amountIngr);
}
if ($resultado4->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado4->bind_result($order, $activeIngredient, $amountAct);
}

if ($resultado3->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado3->bind_result($order, $material , $forUnit, $totPerOrd, $codi);
    
}
if ($resultado6->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado6->bind_result($order, $activeIngredient, $totIngre);
}
if ($resultado7->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado7->bind_result($order, $activeIngredient, $totIngreAct);
}

}else if($productType === 'Suplemento Alimenticio')
{

    $Lot = '';

    $sqlLot = "select CONCAT((p.numero), MONTH(o.fechaOrden), YEAR(o.fechaOrden))
                                from pedido as p
                                INNER JOIN orden as o on o.pedido = p.numero
                                where p.numero = ?";
$resultado8 = $connection->prepare($sqlLot);
$resultado8->bind_param('s', $orderNumber);
$resultado8->execute();
$resultado8->store_result();
if ($resultado8->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado8->bind_result($Lot);
    
    // Obtener el primer resultado
    $resultado8->fetch();
}

$sql = "SELECT * FROM vw_PRODORD_info_suple  WHERE noOrden = ? and Lot = ?";
$resultado = $connection->prepare($sql);
$resultado->bind_param('ss', $orderNumber, $Lot);
$resultado->execute();
$resultado->store_result();

$sql2 = "SELECT * FROM vw_PRODORD_formulsOrden  WHERE noOrden = ?";
$resultado2 = $connection->prepare($sql2);
$resultado2->bind_param('s', $orderNumber);
$resultado2->execute();
$resultado2->store_result();

$sql5 = "SELECT codigo FROM producto where nombre = '$productName'";
$resultado5 = $connection->prepare($sql5);
$resultado5->execute();
$resultado5->store_result();
$resultado5->bind_result($codigo);
$resultado5->fetch();
$codigoprod = $codigo;

$sql3 = "SELECT * FROM vw_PRODORD_empaqueOrden  WHERE noOrden = ?  AND codProd = ?";
$resultado3 = $connection->prepare($sql3);
$resultado3->bind_param('ss', $orderNumber, $codigoprod);
$resultado3->execute();
$resultado3->store_result();
$sql6 = "SELECT * FROM vw_PRODORD_formuMatPrima  WHERE noOrden = ?";
$resultado6 = $connection->prepare($sql6);
$resultado6->bind_param('s', $orderNumber);
$resultado6->execute();
$resultado6->store_result();



// Inicializar las variables
$order = '';
$lotSize = '';
$capsTab = 'N/A';
$totalBlend = '';
$expiration = '';
$tradeMark = '';
$chemicalName = '';
$presentation = '';
$activeIngredients = 'N/A';
$activeIngredient = 'N/A';
$amountAct = 'N/A';
$ingredient = '';
$amountIngr = '';
$material = '';
$forUnit = '';
$totPerOrd = '';
$formuFinalW = '';
$blendFinalW = '';
$codi = '';
$resultado4 = '';

    // Verificar si la consulta tiene resultados
    if ($resultado->num_rows > 0) {
        // Asociar las columnas de la consulta con las variables
        $resultado->bind_result($order, $lotSize, $totalBlend,  $tradeMark, 
                                $chemicalName, $presentation, $Lot, $expiration, $blendFinalW, $formuFinalW);
        // Obtener el primer resultado
        $resultado->fetch();
    }
if ($resultado2->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado2->bind_result($order, $ingredient, $amountIngr);
}

if ($resultado3->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado3->bind_result($order, $material , $forUnit, $totPerOrd, $codi);
}
if ($resultado6->num_rows > 0) {
    // Asociar las columnas de la consulta con las variables
    $resultado6->bind_result($order, $activeIngredient, $totIngre);
}
}



// Crear una nueva instancia de TCPDF
class MYPDF extends TCPDF {
    // Override del método Header() para personalizar el encabezado
    public function Header() {
        $this->SetFillColor(1, 61, 90); // Azul (puedes cambiarlo si prefieres otro color)

        // Dibujar un rectángulo azul en el encabezado (X, Y, ancho, alto)
        $this->Rect(0, 0, $this->getPageWidth(), 15 , 'F');  // 'F' indica que es un rectángulo relleno

        // Ruta del logo (asegúrate de que la ruta sea correcta)
        $logo = '../imagenes/logo.png';  // Cambia esta ruta por la ubicación de tu logo
        
        // Posiciona el logo a la izquierda del encabezado
        $this->Image($logo, 5, 5, 35, 5, 'PNG'); // (x, y, ancho, alto, formato)
        
        // Establece el texto a la derecha del logo
        $this->SetXY(87, 5);  // X=55mm (después del logo), Y=15mm (margen superior)
        $this->SetFont('Helvetica', 'B', 12); // Fuente en negrita, tamaño 12
        $this->SetTextColor(255, 255, 255);  // Blanco para el texto
        $this->Cell(0, 5, 'Production Order ', 0, 1, 'L'); // Muestra el tipo de producto
    }
}

// Crear una nueva instancia de TCPDF con la clase personalizada MYPDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PRODord');
$pdf->SetTitle('Production Order');
$pdf->SetSubject('Ejemplo de Documento con Logo y Texto');
$pdf->SetKeywords('TCPDF, ejemplo, logo, texto');

// Establecer márgenes (izquierda, superior, derecha)
$pdf->SetMargins(15, 25, 15); // Márgenes: 15mm a cada lado, 25mm para el margen superior (para dejar espacio para el encabezado)

// Establecer márgenes para el pie de página
$pdf->SetFooterMargin(10); // Márgenes del pie de página (abajo)

// Establecer auto-breaks de página
$pdf->SetAutoPageBreak(TRUE, 15); // Salto de página automático

// Establecer escala de imagen
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Establecer una fuente predeterminada
$pdf->SetFont('Helvetica', '', 12); // Fuente Helvetica, tamaño 12

// Agregar una página
$pdf->AddPage();

// Agregar los detalles de la orden al cuerpo del PDF
$html = '
<table border="1" cellpadding="4">
    <tr>
        <th align="center" colspan="6" style="background-color: rgb(1, 61, 90); color: white;">PRODUCTION ORDER</th>
    </tr>
    <tr>
        <th align="left" colspan="2">Lot size: ' . htmlspecialchars($lotSize) . '
        <br>Total number of capsules/ tablets: ' . htmlspecialchars($capsTab) . '
        <br>Total blend: ' . htmlspecialchars($totalBlend) . '</th>
        <th align="left" colspan="2">Trade Mark: ' . htmlspecialchars($tradeMark) . '
        <br>Chemical Name: ' . htmlspecialchars($chemicalName) . ' 
        <br>Presentation: ' . htmlspecialchars($presentation) . '
        <br>Active Ingredient: ' . htmlspecialchars($chemicalName) .'</th>
        <th align="left" colspan="2">Lot: ' . htmlspecialchars($Lot) . '
        <br>Expiration Date: ' . htmlspecialchars($expiration) . '</th>
    </tr>
    <tr>
        <td align="center" colspan="2" style="background-color: rgb(1, 61, 90); color: white;">Formulation</td>
        <td align="center" colspan="2" style="background-color: rgb(1, 61, 90); color: white;">Blend</td>
        <td align="center" colspan="2" style="background-color: rgb(1, 61, 90); color: white;">Weighing Process</td>
    </tr>
    <tr>
        <th align="left" style="background-color: rgb(202, 232, 246); ">Ingredients: </th>
        <th align="left" style="background-color: rgb(202, 232, 246); ">Amount: </th>
        <th align="left" style="background-color: rgb(202, 232, 246); ">Ingredients: </th>
        <th align="left" style="background-color: rgb(202, 232, 246); ">Amount: </th>
        <th align="left" style="background-color: rgb(202, 232, 246); ">Ingredients: </th>
        <th align="left" style="background-color: rgb(202, 232, 246); ">Weighing: </th>
    </tr>';

// Concatenar los datos de la consulta dentro del foreach
while ($resultado2->fetch() && $resultado6->fetch() ) {
    $html .= '
    <tr> 
    
        
        <td>' . htmlspecialchars($ingredient) . '</td>
        <td>' . htmlspecialchars($amountIngr) . '</td>
        <td>' . htmlspecialchars($ingredient) . '</td>
        <td>' . htmlspecialchars($totIngre) . '</td>
       
        <td>' . htmlspecialchars($ingredient) . '</td>
        <td></td>
    </tr>';
}
if($productType === 'Farmaceutico'){

    while ($resultado4->fetch() && $resultado7->fetch() ) {
        $html .= '
        <tr> 
        
            
            <td>' . htmlspecialchars($activeIngredient) . '</td>
            <td>' . htmlspecialchars($amountAct) . '</td>
            <td>' . htmlspecialchars($activeIngredient) . '</td>
            <td>' . htmlspecialchars($totIngreAct) . '</td>
            
            <td>' . htmlspecialchars($activeIngredient) . '</td>
            <td></td>
        </tr>';
    }
}

$html .= '
    <tr>
        <td style="background-color: rgb(202, 232, 246);">Final Weight:</td>
        <td>' . htmlspecialchars($formuFinalW) . '</td>
        <td style="background-color: rgb(202, 232, 246);">Final Weight: </td>
        <td>' . htmlspecialchars($blendFinalW) . '</td>
        <td style="background-color: rgb(202, 232, 246); ">Final Weight: </td>
        <td></td>
    </tr>
    <tr>
        <th align="center" colspan="6" style="background-color: rgb(1, 61, 90); color: white;">Packing Material</th>
    </tr>
    
    <tr>
        <td colspan="2" style="background-color: rgb(202, 232, 246); ">Material: </td>
        <td style="background-color: rgb(202, 232, 246); ">For Unit:</td>
        <td style="background-color: rgb(202, 232, 246);">Total per Order </td>
        <td colspan="2" style="background-color: rgb(202, 232, 246); ">Delivered/Received</td>
    </tr>';
    while ($resultado3->fetch()) {
        $html .= '
        <tr>
        <td colspan="2">' . htmlspecialchars($material) . '</td>
        <td>' . htmlspecialchars($forUnit) . '</td>
        <td>' . htmlspecialchars($totPerOrd) . '</td>
        <td colspan="2"></td>
    </tr>';
    }
    
    $html .= '</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y generar el PDF
$pdf->Output('Orden_' . $orderNumber . '.pdf', 'I');
?>
