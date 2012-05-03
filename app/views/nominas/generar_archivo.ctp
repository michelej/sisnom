<?php

$data = array();

$i = 1;
foreach ($empleados as $key => $empleado):

    $data[$key]['N'] = $i++;
    $data[$key]['Nombres y Apellidos'] = $empleado['Nomina_Empleado']['NOMBRE'] . " " . $empleado['Nomina_Empleado']['APELLIDO'];
    $data[$key]['Cedula de Identidad'] = number_format($empleado['Nomina_Empleado']['CEDULA'], 0, ',', '.');
    $data[$key]['Cargo'] = $empleado['Nomina_Empleado']['CARGO'];
    $data[$key]['Sueldo Basico Mensual'] = number_format($empleado['Nomina_Empleado']['SUELDO_BASE'], 2, ',', '.');
    $data[$key]['Fecha de Ingreso'] = $empleado['Nomina_Empleado']['INGRESO'];
    $data[$key]['Salario Diario'] = number_format($empleado['Nomina_Empleado']['SUELDO_DIARIO'], 2, ',', '.');
    $data[$key]['Desde'] = $empleado['Nomina_Empleado']['FECHA_INI'];
    $data[$key]['Hasta'] = $empleado['Nomina_Empleado']['FECHA_FIN'];
    $data[$key]['Dias Laborados'] = $empleado['Nomina_Empleado']['DIAS_LABORADOS'];
    $data[$key]['Sub Total Sueldo Basico'] = number_format($empleado['Nomina_Empleado']['SUELDO_BASICO'], 2, ',', '.');

    foreach ($empleado['Nomina_Empleado']['Asignaciones'] as $asigkey => $value) {
        $data[$key][$asigkey] = number_format($value, 2, ',', '.');
    }
    $data[$key]['Total Asignaciones'] = number_format($empleado['Nomina_Empleado']['TOTAL_ASIGNACIONES'], 2, ',', '.');
    $data[$key]['Total Sueldo +Asignaciones'] = number_format($empleado['Nomina_Empleado']['SUELDO_BASICO_ASIGNACIONES'], 2, ',', '.');

    foreach ($empleado['Nomina_Empleado']['Deducciones'] as $deduckey => $value) {
        $data[$key][$deduckey] = number_format($value, 2, ',', '.');
    }
    $data[$key]['Total de Deducciones'] = number_format($empleado['Nomina_Empleado']['TOTAL_DEDUCCIONES'], 2, ',', '.');
    $data[$key]['Total a Cancelar'] = number_format($empleado['Nomina_Empleado']['TOTAL_SUELDO'], 2, ',', '.');
endforeach;

//$excel->generate($data,'');


$tamTexto = 10;
$estiloTexto = 'Arial';

$excel->_anchoColumna('A', 5);
$excel->_campo('A15', "Nro");
$excel->_texto('A15', $tamTexto, $estiloTexto);
$excel->_borde('A15');

$excel->_anchoColumna('B', 43);
$excel->_campo('B15', "APELLIDO Y NOMBRES");
$excel->_texto('B15', $tamTexto, $estiloTexto);
$excel->_borde('B15');

$excel->_anchoColumna('C', 13);
$excel->_campo('C15', "CEDULA DE IDENTIDAD");
$excel->_texto('C15', $tamTexto, $estiloTexto);
$excel->_borde('C15');

$excel->_anchoColumna('D', 45);
$excel->_campo('D15', "CARGO");
$excel->_texto('D15', $tamTexto, $estiloTexto);
$excel->_borde('D15');

$excel->_anchoColumna('E', 13);
$excel->_campo('E15', "SALARIO BASICO MENSUAL");
$excel->_texto('E15', $tamTexto, $estiloTexto);
$excel->_borde('E15');

$excel->_anchoColumna('F', 13);
$excel->_campo('F15', "FECHA DE INGRESO");
$excel->_texto('F15', $tamTexto, $estiloTexto);
$excel->_borde('F15');

$excel->_anchoColumna('G', 13);
$excel->_campo('G15', "SALARIO DIARIO");
$excel->_texto('G15', $tamTexto, $estiloTexto);
$excel->_borde('G15');

$excel->_anchoColumna('H', 13);
$excel->_campo('H15', "DESDE");
$excel->_texto('H15', $tamTexto, $estiloTexto);
$excel->_borde('H15');

$excel->_anchoColumna('I', 13);
$excel->_campo('I15', "HASTA");
$excel->_texto('I15', $tamTexto, $estiloTexto);
$excel->_borde('I15');

$excel->_anchoColumna('J', 13);
$excel->_campo('J14', "DIAS LABORADOS");
$excel->_texto('J14', $tamTexto, $estiloTexto);
$excel->_unir('J14:J15');
$excel->_borde('J14:J15');

$excel->_unir('H14:I14');
$excel->_campo('H14',"PERIODO LABORADO");
$excel->_texto('H14',12,$estiloTexto);
$excel->_borde('H14:AB14');
$excel->_anchoFila('H',50);


$nombre = 'nomina';
$excel->_output($nombre);
?> 
