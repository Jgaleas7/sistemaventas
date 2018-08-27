<?php
if (isset($ventas))
{

//Recibir detalles de factura
    $fecha_reporte = $fecha;

//Recibir los datos de la empresa
    $nombre_tienda = $empresa->empresa;
    $nombre_reporte='Reporte de ventas por fecha';




//variable que guarda el nombre del archivo PDF
    $archivo="reporte-diario-".$fecha_reporte.".pdf";

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


    $margenX=5;
//Creaci�n de la tabla de los detalles de los productos productos
    $top_productos = 40;
    $pdf->SetXY(5+$margenX, $top_productos);
    $pdf->Cell(40, 5, 'Producto', 0, 1, 'L');

    $pdf->SetXY(55+$margenX, $top_productos);
    $pdf->Cell(40, 5, 'Medida', 0, 1, 'L');

    $pdf->SetXY(80+$margenX, $top_productos);
    $pdf->Cell(40, 5, 'Cantidad', 0, 1, 'L');

    $pdf->SetXY(105+$margenX, $top_productos);
    $pdf->Cell(40, 5, 'Precio', 0, 1, 'L');

    $pdf->SetXY(130+$margenX, $top_productos);
    $pdf->Cell(40, 5, 'Descuento', 0, 1, 'L');

    $pdf->SetXY(155+$margenX, $top_productos);
    $pdf->Cell(40, 5, 'Impuesto', 0, 1, 'L');

    $pdf->SetXY(180+$margenX, $top_productos);
    $pdf->Cell(40, 5, 'Total', 0, 1, 'L');


    $y = 44; // variable para la posici�n top desde la cual se empezar�n a agregar los datos
    $x=0;
    $lineaY=44;
    $subtotal=0;
    $descuento=0;
    $total=0;
    $isv=0;
    foreach ($ventas as $producto)
    {
        $lineaY=$lineaY+5;
        $pdf->SetFont('Arial','',9);

        $pdf->SetXY(5+$margenX, $y);
        $pdf->Cell(40, 5, $producto['nombre'], 0, 1, 'L');

        $pdf->SetXY(55+$margenX, $y);
        $pdf->Cell(40, 5, $producto['medida'], 0, 1, 'L');

        $pdf->SetXY(80+$margenX, $y);
        $pdf->Cell(40, 5, $producto['cantidad'],0, 1, 'L');

        $pdf->SetXY(105+$margenX, $y);
        $pdf->Cell(40, 5,'L. '.number_format($producto['precio'],2), 0, 1, 'L');

        $pdf->SetXY(130+$margenX, $y);
        $pdf->Cell(40, 5, 'L. '.number_format($producto['descuento'],2), 0, 1, 'L');

        $pdf->SetXY(155+$margenX, $y);
        $pdf->Cell(40, 5, $producto['impuesto'], 0, 1, 'L');

        $pdf->SetXY(180+$margenX, $y);
        $pdf->Cell(40, 5, 'L. '.number_format($producto['total'],2), 0, 1, 'L');

        $total+=$producto['total'];
        $isv=($isv)+(($producto['total'])-(($producto['total'])/(1+($producto['impuesto']/100))));
        $descuento+=$producto['descuento'];
        $subtotal=$total-$isv;

// aumento del top 5 cm
        $y = $y + 5;
    }

    $pdf->SetDrawColor(188,188,188);
    $pdf->Line($margenX,$lineaY,200,$lineaY);

    /*subtotal*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+5);
    $pdf->Cell(40, 5, 'Subtotal', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+5);
    $pdf->Cell(40, 5, 'L. '.number_format($subtotal,2), 0, 1, 'L');

    /*descuento*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+10);
    $pdf->Cell(40, 5, 'Descuentos', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+10);
    $pdf->Cell(40, 5, 'L. '.number_format($descuento,2), 0, 1, 'L');

    /*ISV*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+15);
    $pdf->Cell(40, 5, 'Isv', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+15);
    $pdf->Cell(40, 5, 'L. '.number_format($isv,2), 0, 1, 'L');

    /*TOTAL*/
    $isv=$total-$subtotal;
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+20);
    $pdf->Cell(40, 5, 'Total', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+20);
    $pdf->Cell(40, 5, 'L. '.number_format($total,2), 0, 1, 'L');


    $pdf->Output('',$archivo,'');//cierra el objeto pdf


}