<?php
include('../../app/config.php');
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
$id_estudiante = $_GET['id'];
include('../../app/controllers/configuraciones/institucion/listado_de_instituciones.php');
include('../../app/controllers/estudiantes/datos_de_estudiantes.php');
//datos institucion

foreach($instituciones as $institucione) {
    $nombre_institucion = $institucione['nombre_institucion'];
    $direccion = $institucione['direccion'];
    $telefono = $institucione['telefono'];
    $celular = $institucione['celular'];
    $correo = $institucione['correo'];
    $logo = $institucione['logo'];
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
$pdf->setFont('Times', '', 13);

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

$QR = 'Este contrato es verificado por el sistema de inscripcion de:'.$nombre_institucion.' por '.$nombres_apellidos_ppff.' habil por derecho en:'.$dia_actual.' '.$mes_actual.' '.$ano_actual.' ';
$pdf->write2DBarcode($QR,'QRCODE,L',180,5,30,30, $style);
// Set some content to print
$html = '

<table border="0">
<tr>
   <td width="150px" style="text-align: center"><img src="../../public/images/configuracion/'.$logo.'" width="100px" alt=""></td>
   <td style="text-align: center"><b> CONTRATO DE INSCRIPCIÓN ESCOLAR</b></td>
</tr>
<tr>
<td style="text-align: center"><b>'.$nombre_institucion.'</b></td>
<td style="text-align: center"><b>'.$direccion.'</b><br>
<small>'.$telefono.' '.$correo.'</small></td>
</tr>

</table>
<p style="text-align: justify">

<b>Entre: </b>'.$nombre_institucion.', con domicilio en '.$direccion.', representada por Carlos Andrei Saucedo Aguilar, a quien en lo sucesivo se le denominará “<b>LA INSTITUCIÓN</b>”,

y <b>'.$nombres_apellidos_ppff.'</b>, mayor de edad, con domicilio en '.$direccion.', identificado con <b>'.$ci_ppff.'</b>, en representación del estudiante <b>'.$nombres.' '.$apellidos.'</b>, a quien en lo sucesivo se le denominará “<b>EL TUTOR</b>”,

se celebra el presente Contrato de Inscripción, sujeto a las siguientes cláusulas:<br><br>
<b>PRIMERA. OBJETO DEL CONTRATO</b><br> 

El presente contrato tiene por objeto formalizar la inscripción y prestación del servicio educativo brindado por <b>LA INSTITUCIÓN</b> 
al estudiante <b>'.$nombres.' '.$apellidos.'</b> durante el ciclo escolar '.$ano_actual.' '.$curso.',
conforme al plan de estudios autorizado y las disposiciones vigentes.<br><br>

<b>SEGUNDA. OBLIGACIONES DE LA INSTITUCIÓN</b><br>

<b>LA INSTITUCIÓN</b> se compromete a:<br>
a) Brindar educación conforme a los programas oficiales.<br>
b) Proporcionar instalaciones adecuadas para el desarrollo de actividades académicas.<br>
c) Mantener comunicación con <b>EL TUTOR</b> sobre el desempeño y conducta del estudiante.<br>
d) Garantizar un ambiente seguro y respetuoso.<br><br>

<b>TERCERA. OBLIGACIONES DEL TUTOR</b><br>

<b>EL TUTOR</b> se compromete a:<br>
a) Proporcionar información verídica del estudiante.<br>
b) Cumplir con los pagos en tiempo y forma.<br>
c) Respetar el reglamento interno de <b>LA INSTITUCIÓN</b>.<br>
d) Fomentar en el estudiante el cumplimiento de las normas escolares.<br><br>

<b>CUARTA. PAGOS Y CUOTAS</b><br>

<b>EL TUTOR pagará</b>:<br>

Cuota de inscripción: $ _<b><u> 3,000 </u> </b>__<br>

Colegiatura mensual: $ __<b><u> 5,000 </u></b>__<br>

Forma de pago: _____<u>Pago con tarjeta</u>____<br>
Los pagos deberán realizarse dentro de los primeros 7 días de cada mes. El retraso generará recargos conforme al reglamento.<br><br>


<b>QUINTA. DURACIÓN DEL CONTRATO</b><br>

El presente contrato tendrá vigencia durante el ciclo escolar '.$ano_actual.'. Podrá renovarse previo acuerdo entre las partes.<br><br>


<b>SEXTA. CAUSALES DE SUSPENSIÓN O BAJA</b><br>

Podrá darse de baja al estudiante por:<br>
a) Incumplimiento reiterado de pago.<br>
b) Faltas graves contra el reglamento.<br>
c) Conducta que afecte la seguridad, integridad o disciplina escolar.<br>

<b>EL TUTOR </b>podrá solicitar baja voluntaria, sin devolución de pagos ya realizados.<br><br>

<b>SÉPTIMA. CONFIDENCIALIDAD Y MANEJO DE DATOS</b><br>

<b>LA INSTITUCIÓN</b> se compromete a resguardar y proteger los datos personales del estudiante y <b>EL TUTOR</b> conforme a la legislación vigente.<br><br>


<b>OCTAVA. JURISDICCIÓN</b><br>

Para la interpretación y cumplimiento del presente contrato, las partes se someten a las leyes y tribunales de Guadalajara, Jalisco.<br><br>


Leído y entendido el presente contrato, ambas partes lo firman en señal de conformidad.<br><br>

Lugar: __________________________ <br> <br>
Fecha: _<u>'.$dia_actual.'</u>___ / _<u>'.$mes_actual.'</u>___ / _<u>'.$ano_actual.'</u>_ <br> <br><br><br><br><br><br><br><br><br><br><br><br>
<table border="0">
<tr>
<td> <br>__________________________ <br>
<b>LA INSTITUCIÓN</b> <br>
                               '.$nombre_institucion.'<br>
   Carlos Andrei Saucedo Aguilar</td>
<td>__________________________ <br>
<b>EL TUTOR</b> <br>
'.$nombres_apellidos_ppff.' <br><br>
</td>
<td>
__________________________ <br>
<b>ESTUDIANTE</b> (si corresponde) <br></td>
</tr></table><br><br><br><br><br>

Fecha: '.$fecha_actual.'
</p>

'
;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+