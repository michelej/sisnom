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
$excel->_campo('D' . $n, "Sexo");
//$excel->_autosizeColumna('E');
$excel->_anchoColumna('E','15');
$excel->_centrarTexto('E' . $n);
$excel->_campo('E' . $n, "Fecha de Nacimiento");
$excel->_autosizeColumna('F');
$excel->_centrarTexto('F' . $n);
$excel->_campo('F' . $n, "Edad");
//$excel->_autosizeColumna('G');
$excel->_anchoColumna('G','15');
$excel->_centrarTexto('G' . $n);
$excel->_campo('G' . $n, "Fecha de Ingreso");
$excel->_autosizeColumna('H');
$excel->_centrarTexto('H' . $n);
$excel->_campo('H' . $n, "Estado Civil");
$excel->_centrarTexto('I' . $n);
$excel->_autosizeColumna('I');
$excel->_campo('I' . $n, "Cargo");
$excel->_autosizeColumna('J');
$excel->_centrarTexto('J' . $n);
$excel->_campo('J' . $n, "Departamento");
$excel->_autosizeColumna('K');
$excel->_centrarTexto('K' . $n);
$excel->_campo('K' . $n, "Nº de Hijos");
$excel->_autosizeColumna('L');
$excel->_centrarTexto('L' . $n);
$excel->_campo('L' . $n, "Localizacion Fisica");
$excel->_autosizeColumna('M');
$excel->_centrarTexto('M' . $n);
$excel->_campo('M' . $n, "Modalidad");
$excel->_autosizeColumna('N');
$excel->_centrarTexto('N' . $n);
$excel->_campo('N' . $n, "Grupo");

$excel->_grupoBold('B9:N9');
$excel->_anchoFila($n,'35');


$n++;

foreach ($empleados as $empleado) {    
    $excel->_anchoFila($n,'25');
    $excel->_campo('B' . $n, $empleado['Empleado']['CEDULA']);
    $excel->_centrarTexto('B' . $n);
    $excel->_campo('C' . $n, normalizarPalabra($empleado['Empleado']['APELLIDO'] . " " . $empleado['Empleado']['NOMBRE']));
    $excel->_campo('D' . $n, $empleado['Empleado']['SEXO']);
    $excel->_centrarTexto('D' . $n);
    $excel->_campo('E' . $n, $empleado['Empleado']['FECHANAC']);
    $excel->_centrarTexto('E' . $n);
    $excel->_campo('F' . $n, $empleado['Empleado']['EDAD']);
    $excel->_centrarTexto('F' . $n);
    $excel->_campo('G' . $n, $empleado['Empleado']['INGRESO']);
    $excel->_centrarTexto('G' . $n);
    $excel->_campo('H' . $n, $empleado['Empleado']['EDOCIVIL']);
    $excel->_centrarTexto('H' . $n);        
    $excel->_campo('I' . $n, normalizarPalabra($empleado['Empleado']['CARGO']));    
    $excel->_campo('J' . $n, normalizarPalabra($empleado['Empleado']['DEPARTAMENTO']));        
    $excel->_campo('K' . $n, $empleado['Empleado']['HIJOS']);
    $excel->_centrarTexto('K' . $n);        
    $excel->_campo('L' . $n, normalizarPalabra($empleado['Empleado']['LOCALIZACION']));        
    $excel->_campo('M' . $n, $empleado['Empleado']['MODALIDAD']);
    $excel->_centrarTexto('M' . $n);       
    $excel->_campo('N' . $n, $empleado['Empleado']['GRUPO']);
    $excel->_centrarTexto('N' . $n);       
    $n++;
}
$n--;
$excel->_grupoAlinear("B9:N".$n);
$excel->_bordeGrupo("B9:N".$n);
$excel->_output('reporte');

?>
