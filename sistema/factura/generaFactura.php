<?php

	session_start();
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}
	include "../../conexion.php";
	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$consulta = mysqli_query($conexion, "SELECT * FROM configuracion");
		$resultado = mysqli_fetch_assoc($consulta);
		$ventas = mysqli_query($conexion, "SELECT * FROM factura WHERE nofactura = $noFactura");
		$result_venta = mysqli_fetch_assoc($ventas);
		$clientes = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $codCliente");
		$result_cliente = mysqli_fetch_assoc($clientes);
		$productos = mysqli_query($conexion, "SELECT d.nofactura, d.codproducto, d.cantidad, p.codproducto, p.servicio, p.precio FROM detallefactura d INNER JOIN producto p ON d.nofactura = $noFactura WHERE d.codproducto = p.codproducto");
		require_once 'fpdf/fpdf.php';
		$pdf = new FPDF('P', 'mm', 'A3');
		$pdf->AddPage();
		$pdf->SetMargins(10, 0, 0);
		$pdf->SetTitle("BOLETA");
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(280, 5, utf8_decode($resultado['nombre']), 0, 1, 'C');
		$pdf->Ln(20);
		$pdf->image("img/cic.jpg", 250, 25, 25, 25, 'JPG');

		$pdf->SetFont('Arial', 'B', 11);
		$pdf->Cell(25, 5, "Ruc: ", 0, 0, 'L');
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(20, 5, $resultado['ruc'], 0, 1, 'L');

		$pdf->SetFont('Arial', 'B', 11);
		$pdf->Cell(25, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(20, 5, $resultado['telefono'], 0, 1, 'L');

		$pdf->SetFont('Arial', 'B', 11);
		$pdf->Cell(25, 5, utf8_decode("Dirección: "), 0, 0, 'L');
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(20, 5, utf8_decode($resultado['direccion']), 0, 1, 'L');

		$pdf->SetFont('Arial', 'B', 11);
		$pdf->Cell(25, 5, "Ticked: ", 0, 0, 'L');
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(20, 5, $noFactura, 0, 0, 'L');

		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(160, 5, "Fecha: ", 0, 0, 'R');
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(33, 5, $result_venta['fecha'], 0, 1, 'R');
		$pdf->Ln(10);
        //--------------cliente---
		$pdf->SetFillColor(25,25,112);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(275, 5, "Datos del cliente", 0, 1, 'C',true);
		$pdf->Ln();
		$pdf->SetFillColor(98, 119, 135);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(35, 5, "Ruc", 0, 0, 'L', true);
		$pdf->Cell(190, 5, utf8_decode("Razón Social"), 0, 0, 'L', true);
		$pdf->Cell(50, 5, utf8_decode("Teléfono"), 0, 0, 'L', true);
		
		$pdf->Ln(9);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(35, 5, utf8_decode($result_cliente['ruc']), 0, 0, 'L');
		$pdf->Cell(190, 5, utf8_decode($result_cliente['razonsocial']), 0, 0, 'L');
		$pdf->Cell(50, 5, utf8_decode($result_cliente['telefono']), 0, 1, 'L');
		$pdf->Ln(5);

		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(165, 5, utf8_decode("Dirección"), 0, 0, 'L', true);
		$pdf->Cell(110, 5, "Persona C.", 0, 0, 'L', true);
        $pdf->Ln(9);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(165, 5, utf8_decode($result_cliente['direccion']), 0, 0, 'L');
		$pdf->Cell(110, 5, utf8_decode($result_cliente['personacontacto']), 0, 1, 'L');
		$pdf->Ln(5);
        //---------------------------
        $pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(100, 5, "Cargo", 0, 0, 'L', true);
		$pdf->Cell(100, 5, utf8_decode("Área"), 0, 0, 'L', true);
		$pdf->Cell(75, 5, "Correo", 0, 0, 'L', true);
        $pdf->Ln(9);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(100, 5, utf8_decode($result_cliente['cargo']), 0, 0, 'L');
		$pdf->Cell(100, 5, utf8_decode($result_cliente['area']), 0, 0, 'L');
		$pdf->Cell(75, 5, utf8_decode($result_cliente['correo']), 0, 1, 'L');
		$pdf->Ln(5);
		//---------------
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(275, 5, "Web", 0, 0, 'L', true);
        $pdf->Ln(9);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(275, 5, utf8_decode($result_cliente['web']), 0, 1, 'L');
		$pdf->Ln(5);
        //--------------- Detalle de Servicios ----------
		$pdf->SetFillColor(25,25,112);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(275, 5, "Detalle de Servicio", 0, 1, 'C', true);
		$pdf->Ln();
		$pdf->SetFillColor(98, 119, 135);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(220, 5, 'Servicio', 0, 0, 'L', true);
		$pdf->Cell(20, 5, 'Cantidad', 0, 0, 'L', true);
		$pdf->Cell(20, 5, 'Precio', 0, 0, 'L', true);
		$pdf->Cell(15, 5, 'Total', 0, 1, 'L', true);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Ln(2);

		$pdf->SetFont('Arial', '', 9);
		while ($row = mysqli_fetch_assoc($productos)) {
			$pdf->Cell(220, 5, utf8_decode($row['servicio']), 0, 0, 'L');
			$pdf->Cell(20, 5, $row['cantidad'], 0, 0, 'L');
			$pdf->Cell(20, 5, number_format($row['precio'], 2, '.', ','), 0, 0, 'L');
			$importe = number_format($row['cantidad'] * $row['precio'], 2, '.', ',');
			$pdf->Cell(15, 5, $importe, 0, 1, 'L');
		}
		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 10);

		$pdf->Cell(275, 5, 'Total: ' . number_format($result_venta['totalfactura'], 2, '.', ','), 0, 1, 'R');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', 11);
		$pdf->Cell(260, 5, utf8_decode("Gracias por su adquisión"), 0, 1, 'C');
		$pdf->Output("compra.pdf", "I");
		}

?>