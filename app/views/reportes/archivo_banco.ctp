<?php 
//debug($empleados);

$excel->_cargarTemplate("Template3.xls");
$excel->_changeFontSize();

$letras = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I',
    '9' => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q',
    '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y',
    '25' => 'Z', '26' => 'AA', '27' => 'AB', '28' => 'AC', '29' => 'AD', '30' => 'AE', '31' => 'AF', '32' => 'AG', '33' => 'AH',
    '34' => 'AI', '35' => 'AJ', '36' => 'AK', '37' => 'AL', '38' => 'AM');

$n = 9;
$excel->_autosizeColumna('B');
$excel->_centrarTexto('B' . $n);
$excel->_campo('B' . $n, "Cedula / Rif");
$excel->_autosizeColumna('C');
$excel->_centrarTexto('C' . $n);
$excel->_campo('C' . $n, "Apellidos y Nombres");
$excel->_autosizeColumna('D');
$excel->_centrarTexto('D' . $n);
$excel->_campo('D' . $n, "Banco");
$excel->_autosizeColumna('E');
$excel->_centrarTexto('E' . $n);
$excel->_campo('E' . $n, "Numero de Cuenta");
$excel->_autosizeColumna('F');
$excel->_centrarTexto('F' . $n);
$excel->_campo('F' . $n, "Tipo de Pago");


$excel->_grupoBold('B9:F9');
$excel->_anchoFila($n,'35');


$n++;

foreach ($empleados as $empleado) {    
    $excel->_anchoFila($n,'25');
    $excel->_campo('B' . $n, $empleado['Empleado']['CEDULA']);
    $excel->_centrarTexto('B' . $n);
    $excel->_campo('C' . $n, normalizarPalabra($empleado['Empleado']['APELLIDO'] . " " . $empleado['Empleado']['NOMBRE']));
    $excel->_campo('D' . $n, $empleado['Empleado']['BANCO']);
    $excel->_centrarTexto('D' . $n);
    $excel->_campo('E' . $n, $empleado['Empleado']['NCUENTA']);
    $excel->_centrarTexto('E' . $n);
    $excel->_campo('F' . $n, $empleado['Empleado']['TPAGO']);
    $excel->_centrarTexto('F' . $n);        
    $n++;
}
$n--;
$excel->_grupoAlinear("B9:F".$n);
$excel->_bordeGrupo("B9:F".$n);
$excel->_output('reporte');

?>
