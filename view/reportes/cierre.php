<?php
if (isset($ventas))
{

//Recibir detalles de factura
    $fecha_reporte = date('Y-m-d');

//Recibir los datos de la empresa
    $nombre_tienda = $empresa->empresa;
    $nombre_reporte='Cierre de caja';



//variable que guarda el nombre del archivo PDF
    $archivo="cieere-".$fecha_reporte."pdf";

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
    $pdf->SetFont('Arial','B',14);
    $pdf->MultiCell(190,5, $nombre_reporte."\n"."Fecha: $fecha_reporte", 0, "C", false);
    $pdf->Ln(2);


    $margenX=15;
//Creaci�n de la tabla de los detalles de los productos productos
    $top_productos = 40;

    $y = 10; // variable para la posici�n top desde la cual se empezar�n a agregar los datos
    $y2 = 54; // variable para la posici�n top desde la cual se empezar�n a agregar los datos
    $x=0;
    $lineaY=64+$y;
    $subtotal=0;
    $descuento=0;
    $total=0;
    $isv=0;
    foreach ($ventas as $producto)
    {
        $total+=$producto['total'];
        $isv=($isv)+(($producto['total'])-(($producto['total'])/(1+($producto['impuesto']/100))));
        $descuento+=$producto['descuento'];
        $subtotal=$total-$isv;

    }


    /*Datos de la apertura*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,44);
    $pdf->Cell(44, 5, 'DATOS DE LA APERTURA', 0, 1, 'L');


    /*caja*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$y2);
    $pdf->Cell(40, 5, 'Caja :', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$y2);
    $pdf->Cell(40, 5, '#'.$apertura[0]['caja'], 0, 1, 'L');

    /*monto aperturado*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$y2+5);
    $pdf->Cell(40, 5, 'Monto :', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$y2+5);
    $pdf->Cell(40, 5, 'L'.number_format($apertura[0]['monto'],2), 0, 1, 'L');





    $pdf->SetDrawColor(188,188,188);
    $pdf->Line($margenX,$lineaY,200,$lineaY);

    /*Datos de las ventas*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+5);
    $pdf->Cell(44, 5, 'TOATL VENTAS', 0, 1, 'L');

    /*subtotal*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+10);
    $pdf->Cell(40, 5+$y, 'Subtotal', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+10);
    $pdf->Cell(40, 5+$y, 'L. '.number_format($subtotal,2), 0, 1, 'L');

    /*descuento*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+15);
    $pdf->Cell(40, 5+$y, 'Descuentos', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+15);
    $pdf->Cell(40, 5+$y, 'L. '.number_format($descuento,2), 0, 1, 'L');

    /*ISV*/
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+20);
    $pdf->Cell(40, 5+$y, 'Isv', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+20);
    $pdf->Cell(40, 5+$y, 'L. '.number_format($isv,2), 0, 1, 'L');

    /*TOTAL*/
    $isv=$total-$subtotal;
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+25);
    $pdf->Cell(40, 5+$y, 'Total', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+25);
    $pdf->Cell(40, 5+$y, 'L. '.number_format($total,2), 0, 1, 'L');

    $pdf->SetDrawColor(188,188,188);
    $pdf->Line($margenX,$lineaY+40,200,$lineaY+40);

    /*saldo final*/
    $isv=$total-$subtotal;
    $pdf->SetFont('Arial','B',14);
    $pdf->SetXY($margenX+5,$lineaY+45);
    $pdf->Cell(40, 5+$y, 'Saldo Final', 0, 1, 'L');

    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($margenX+35,$lineaY+45);
    $pdf->Cell(40, 5+$y, 'L. '.number_format($total+$apertura[0]['monto'],2), 0, 1, 'L');
    $pdf->Output('',$archivo,'');//cierra el objeto pdf


}