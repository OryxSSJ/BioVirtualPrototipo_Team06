<?php
include ('../../app/config.php');

// Defect 1031: Error 500 al descargar PDF
http_response_code(500);
echo "Internal Server Error: Error al generar PDF - Librería TCPDF no encontrada o corrupta. (Defecto 1031)";
exit;

//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 * @group header
 * @group footer
 * @group page
 * @group pdf
 */

// Include the main TCPDF library (search for installation path).
require_once('../../public/TCPDF-main/tcpdf.php');
$id_pago = $_GET['id'];
$id_estudiante = $_GET['id_estudiante'];
include('../../app/controllers/configuraciones/institucion/listado_de_instituciones.php');
include('../../app/controllers/estudiantes/datos_de_estudiantes.php');
include('../../app/controllers/pagos/datos_pago_estudiante.php');
//datos institucion

foreach($instituciones as $institucione) {
    $nombre_institucion = $institucione['nombre_institucion'];
    $direccion = $institucione['direccion'];
    $telefono = $institucione['telefono'];
    $celular = $institucione['celular'];
    $correo = $institucione['correo'];
    $logo = $institucione['logo'];
}

foreach($pagos as $pago){
   $mes_pagado = $pago['mes_pagado'];
   $monto_pagado = $pago['monto_pagado'];
   $fecha_pagado = $pago['fecha_pagado'];
}


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(216,280), true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor(APP_NAME);
$pdf->setTitle('Contrato');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(10, 10, 10);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
$pdf-> setPrintHeader(false);
// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->setFont('Times', '', 11);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$style = array(
	'border' => 0,
	'vpadding' =>'3',
	'hpadding' =>'3',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false,
	'module_width' => 1,
	'module_height' => 1,
);


// Set some content to print
$html_recibo = '
<table border="0">
<tr>
<td width="120"><img src="../../public/images/configuracion/'.$logo.'" width="90"></td>
<td width="380" style="text-align:center">
<b>'.$nombre_institucion.'</b><br>
'.$direccion.'<br>
Tel: '.$telefono.'  Email: '.$correo.'
</td>
<td width="150" style="text-align:right">
<b>Recibo N°:</b> '.$id_pago.'<br>
<b>Fecha:</b> '.$fecha_pagado.'
</td>
</tr>
</table>

<br>
<h3 style="text-align:center"><b>RECIBO DE PAGO - <u>ORIGINAL</u></b></h3>
<br>

<b>Estudiante:</b> '.$nombres.' '.$apellidos.'<br>
<b>CI:</b> '.$ci.'<br>
<b>Nivel:</b> '.$nivel.' &nbsp;&nbsp;&nbsp; <b>Curso:</b> '.$curso.' '.$paralelo.'<br>
<b>Tutor:</b> '.$nombres_apellidos_ppff.'<br><br>

<b>Mes Pagado:</b> '.$mes_pagado.'<br>
<b>Monto Pagado:</b> $'.$monto_pagado.' MXN<br><br>

<hr>
<p style="text-align:justify">
Se hace constar que la institución ha recibido el pago correspondiente a la prestación del servicio educativo durante el periodo indicado.
</p>
<hr>

<br><br>

<table width="100%" border="0">
<tr>
<td style="text-align:center">
_____________________________<br>
<b>LA INSTITUCIÓN</b><br>
'.$nombre_institucion.'
</td>

<td style="text-align:center">
_____________________________<br>
<b>EL TUTOR</b><br>
'.$nombres_apellidos_ppff.'
</td>
</tr>
</table>
';


// COPIA (solo cambiamos título)

$html_copia = str_replace('ORIGINAL', 'COPIA', $html_recibo);

// Ahora imprimimos ambos en una sola hoja, divididos por una línea
$html = ''.$html_recibo.'
<br><br><hr style="border-top: 2px dashed #000"><br><br>
'.$html_copia.'';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('recibo_pago_'.$id_pago.'.pdf', 'I');