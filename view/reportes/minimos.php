<?php
if (isset($minimos))
{

//Recibir detalles de factura
    $fecha_reporte = date('d-m-Y');

//Recibir los datos de la empresa
    $nombre_tienda = $empresa->empresa;
    $nombre_reporte='Productos bajos en existencia';



//variable que guarda el nombre del archivo PDF
    $archivo="bajos-en-existencia.pdf";

    $archivo_de_salida=$archivo;
    $orientation='P';
    $unit='mm';
    $size='Letter';
    $pdf=new FPDF($orientation, $unit, $size);  //crea el objeto
    $pdf->AddPage();  //a�adimos una p�gina. Origen coordenadas, esquina superior izquierda, posici�n por defeto a 1 cm de los bordes.


//logo de la tienda
    $pdf->Image(VISTA_RUTA.'/reportes/logo.png', 5 ,5, 40 , 40,'PNG');

// Encabezado de la factura
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(190, 10, $nombre_tienda, 0, 2, "C");
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(190,5, $nombre_reporte."\n"."Fecha: $fecha_reporte", 0, "C", false);
    $pdf->Ln(2);



//Creaci�n de la tabla de los detalles de los productos productos
    $top_productos = 40;
    $pdf->SetXY(5, $top_productos);
    $pdf->Cell(40, 5, 'Codigo', 0, 1, 'L');

    $pdf->SetXY(35, $top_productos);
    $pdf->Cell(40, 5, 'Descripcion', 0, 1, 'L');

    $pdf->SetXY(80, $top_productos);
    $pdf->Cell(40, 5, 'Medida', 0, 1, 'L');

    $pdf->SetXY(110, $top_productos);
    $pdf->Cell(40, 5, 'Existencia', 0, 1, 'L');

    $pdf->SetXY(145, $top_productos);
    $pdf->Cell(40, 5, 'Minimo', 0, 1, 'L');

    $pdf->SetXY(175, $top_productos);
    $pdf->Cell(40, 5, 'Precio', 0, 1, 'L');


    $y = 44; // variable para la posici�n top desde la cual se empezar�n a agregar los datos
    $x=0;
    foreach ($minimos as $producto)
    {
        $pdf->SetFont('Arial','',9);

        $pdf->SetXY(5, $y);
        $pdf->Cell(40, 5, $producto['codigo'], 0, 1, 'L');
        $pdf->SetXY(35, $y);
        $pdf->Cell(40, 5, $producto['nombre'],0, 1, 'L');
        $pdf->SetXY(80, $y);
        $pdf->Cell(40, 5,$producto['medida'], 0, 1, 'L');
        $pdf->SetXY(110, $y);
        $pdf->Cell(40, 5, $producto['existencia'], 0, 1, 'L');
        $pdf->SetXY(145, $y);
        $pdf->Cell(40, 5, $producto['minimo'], 0, 1, 'L');
        $pdf->SetXY(175, $y);
        $pdf->Cell(40, 5, 'L. '.number_format($producto['precio'],2), 0, 1, 'L');

// aumento del top 5 cm
        $y = $y + 5;
    }
    $pdf->Output('',$archivo,'');//cierra el objeto pdf


}