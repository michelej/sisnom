<?php

//***************************************************
$time = time();
//***************************************************
$letras = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I',
    '9' => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q',
    '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y',
    '25' => 'Z', '26' => 'AA', '27' => 'AB', '28' => 'AC', '29' => 'AD', '30' => 'AE', '31' => 'AF', '32' => 'AG', '33' => 'AH',
    '34' => 'AI', '35' => 'AJ', '36' => 'AK', '37' => 'AL', '38' => 'AM');

$data = array();

$i = 1;
foreach ($empleados as $key => $empleado):

    $data[$key]['N'] = $i++;
    $data[$key]['Nombres y Apellidos'] = $empleado['Nomina_Empleado']['NOMBRE'] . " " . $empleado['Nomina_Empleado']['APELLIDO'];
    $data[$key]['Cedula de Identidad'] = $empleado['Nomina_Empleado']['CEDULA'];
    $data[$key]['Cargo'] = $empleado['Nomina_Empleado']['CARGO'];
    $data[$key]['Sueldo Basico Mensual'] = $empleado['Nomina_Empleado']['SUELDO_BASE'];
    $data[$key]['Fecha de Ingreso'] = $empleado['Nomina_Empleado']['INGRESO'];
    $data[$key]['Salario Diario'] = $empleado['Nomina_Empleado']['SUELDO_DIARIO'];
    $data[$key]['Desde'] = formatoFechaAfterFind($empleado['Nomina_Empleado']['FECHA_INI']);
    $data[$key]['Hasta'] = formatoFechaAfterFind($empleado['Nomina_Empleado']['FECHA_FIN']);
    $data[$key]['Dias Laborados'] = $empleado['Nomina_Empleado']['DIAS_LABORADOS'];
    $data[$key]['Sub Total Sueldo Basico'] = $empleado['Nomina_Empleado']['SUELDO_BASICO'];

    foreach ($empleado['Nomina_Empleado']['Asignaciones'] as $asigkey => $value) {
        $data[$key]['Asignaciones'][$asigkey] = $value;
    }
    $data[$key]['Total Asignaciones'] = $empleado['Nomina_Empleado']['TOTAL_ASIGNACIONES'];
    $data[$key]['Total Sueldo + Asignaciones'] = $empleado['Nomina_Empleado']['SUELDO_BASICO_ASIGNACIONES'];

    foreach ($empleado['Nomina_Empleado']['Deducciones'] as $deduckey => $value) {
        $data[$key]['Deducciones'][$deduckey] = $value;
    }
    $data[$key]['Total de Deducciones'] = $empleado['Nomina_Empleado']['TOTAL_DEDUCCIONES'];
    $data[$key]['Total a Cancelar'] = $empleado['Nomina_Empleado']['TOTAL_SUELDO'];
endforeach;


$excel->_bordeGrupo('A15:I15');
$excel->_headersTabla('A15:I15');

$excel->_anchoColumna('A', 5);
$excel->_campo('A15', "Nro");

$excel->_anchoColumna('B', 43);
$excel->_centrarTexto('B15');
$excel->_campo('B15', "APELLIDOS Y NOMBRES");

$excel->_anchoColumna('C', 13);
$excel->_centrarTexto('C15');
$excel->_campo('C15', "CEDULA DE IDENTIDAD");


$excel->_anchoColumna('D', 45);
$excel->_centrarTexto('D15');
$excel->_campo('D15', "CARGO");


$excel->_anchoColumna('E', 13);
$excel->_centrarTexto('E15');
$excel->_campo('E15', "SALARIO BASICO MENSUAL");

$excel->_anchoColumna('F', 13);
$excel->_centrarTexto('F15');
$excel->_campo('F15', "FECHA DE INGRESO");

$excel->_anchoColumna('G', 13);
$excel->_centrarTexto('G15');
$excel->_campo('G15', "SALARIO DIARIO");

$excel->_anchoColumna('H', 13);
$excel->_centrarTexto('H15');
$excel->_campo('H15', "DESDE");

$excel->_anchoColumna('I', 13);
$excel->_centrarTexto('I15');
$excel->_campo('I15', "HASTA");

$excel->_anchoColumna('J', 13);
$excel->_centrarTexto('J14');
$excel->_campo('J14', "DIAS LABORADOS");
$excel->_unir('J14:J15');
$excel->_bordeSimple('J14:J15');
$excel->_headersTabla('J14:J15');

$excel->_anchoColumna('K', 13);
$excel->_centrarTexto('K14');
$excel->_campo('K14', "SUB TOTAL SUELDO BASICO");
$excel->_unir('K14:K15');
$excel->_bordeSimple('K14:K15');
$excel->_headersTabla('K14:K15');

$marca = 11;
$asig = 0;
$asignaciones = array_keys($empleados['0']['Nomina_Empleado']['Asignaciones']);
foreach ($asignaciones as $asignacion) {
    $excel->_anchoColumna($letras[$marca], 16);
    $excel->_centrarTexto($letras[$marca] . '15');
    $excel->_campo($letras[$marca] . '15', $asignacion);
    $marca++;
    $asig++;
}
$excel->_bordeGrupo($letras[11] . '15:' . $letras[11 + $asig] . '15');
$excel->_headersTabla($letras[11] . '15:' . $letras[11 + $asig] . '15');

$excel->_anchoColumna($letras[$marca], 15);
$excel->_centrarTexto($letras[$marca] . '14');
$excel->_campo($letras[$marca] . '14', "TOTAL ASIGNACIONES");
$excel->_unir($letras[$marca] . '14' . ':' . $letras[$marca] . '15');
$excel->_bordeSimple($letras[$marca] . '14' . ':' . $letras[$marca] . '15');
$excel->_headersTabla($letras[$marca] . '14' . ':' . $letras[$marca] . '15');

$excel->_anchoColumna($letras[$marca + 1], 15);
$excel->_centrarTexto($letras[$marca + 1] . '14');
$excel->_campo($letras[$marca + 1] . '14', "TOTAL SUELDO + ASIGNACIONES");
$excel->_unir($letras[$marca + 1] . '14' . ':' . $letras[$marca + 1] . '15');
$excel->_bordeSimple($letras[$marca + 1] . '14' . ':' . $letras[$marca + 1] . '15');
$excel->_headersTabla($letras[$marca + 1] . '14' . ':' . $letras[$marca + 1] . '15');

$marca = $marca + 2;
$deduc = 0;
$tp = $marca;
$deducciones = array_keys($empleados['0']['Nomina_Empleado']['Deducciones']);
foreach ($deducciones as $deduccion) {
    $excel->_anchoColumna($letras[$marca], 13);
    $excel->_centrarTexto($letras[$marca] . '15');
    $excel->_campo($letras[$marca] . '15', $deduccion);
    $marca++;
    $deduc++;
}
$excel->_headersTabla($letras[$tp] . '15:' . $letras[$tp + $deduc] . '15');
$excel->_bordeGrupo($letras[$tp] . '15:' . $letras[$tp + $deduc] . '15');

$excel->_anchoColumna($letras[$marca], 14);
$excel->_centrarTexto($letras[$marca] . '14');
$excel->_campo($letras[$marca] . '14', "TOTAL DEDUCCIONES");
$excel->_unir($letras[$marca] . '14' . ':' . $letras[$marca] . '15');
$excel->_bordeSimple($letras[$marca] . '14' . ':' . $letras[$marca] . '15');
$excel->_headersTabla($letras[$marca] . '14' . ':' . $letras[$marca] . '15');

$excel->_anchoColumna($letras[$marca + 1], 13);
$excel->_centrarTexto($letras[$marca + 1] . '14');
$excel->_campo($letras[$marca + 1] . '14', "TOTAL A CANCELAR");
$excel->_unir($letras[$marca + 1] . '14' . ':' . $letras[$marca + 1] . '15');
$excel->_bordeSimple($letras[$marca + 1] . '14' . ':' . $letras[$marca + 1] . '15');
$excel->_headersTabla($letras[$marca + 1] . '14' . ':' . $letras[$marca + 1] . '15');

$asig--;
$excel->_unir($letras[11] . '14:' . $letras[11 + $asig] . '14');
$excel->_centrarTexto($letras[11] . '14');
$excel->_campo($letras[11] . '14', "ASIGNACIONES");
$excel->_bordeSimple($letras[11] . '14:' . $letras[11 + $asig] . '14');
$excel->_headersTabla($letras[11] . '14:' . $letras[11 + $asig] . '14');
$excel->_anchoFila($letras[11], 50);

$deduc--;
$excel->_unir($letras[12 + $asig + 2] . '14:' . $letras[12 + $asig + 2 + $deduc] . '14');
$excel->_centrarTexto($letras[12 + $asig + 2] . '14');
$excel->_campo($letras[12 + $asig + 2] . '14', "DEDUCCIONES");
$excel->_bordeSimple($letras[12 + $asig + 2] . '14:' . $letras[12 + $asig + 2 + $deduc] . '14');
$excel->_headersTabla($letras[12 + $asig + 2] . '14:' . $letras[12 + $asig + 2 + $deduc] . '14');
$excel->_anchoFila($letras[12 + $asig + 2], 50);

$excel->_unir('H14:I14');
$excel->_centrarTexto('H14');
$excel->_campo('H14', "PERIODO LABORADO");
$excel->_bordeSimple('H14:I14');
$excel->_headersTabla('H14:I14');
$excel->_anchoFila('H', 50);

$n = 16;
foreach ($data as $empleado) {
    $excel->_campo('A' . $n, $empleado['N']);
    $excel->_campo('B' . $n, $empleado['Nombres y Apellidos']);
    $excel->_centrarTexto('C' . $n);
    $excel->_campo('C' . $n, $empleado['Cedula de Identidad']);
    $excel->_campo('D' . $n, $empleado['Cargo']);
    $excel->_formatoNumero('E' . $n);
    $excel->_campo('E' . $n, $empleado['Sueldo Basico Mensual']);
    $excel->_campo('F' . $n, $empleado['Fecha de Ingreso']);
    $excel->_formatoNumero('G' . $n);
    $excel->_campo('G' . $n, $empleado['Salario Diario']);
    $excel->_campo('H' . $n, $empleado['Desde']);
    $excel->_campo('I' . $n, $empleado['Hasta']);
    $excel->_campo('J' . $n, $empleado['Dias Laborados']);
    $excel->_campo('K' . $n, $empleado['Sub Total Sueldo Basico']);
    $temp = 11;
    foreach ($empleado['Asignaciones'] as $value) {
        $excel->_formatoNumero($letras[$temp] . $n);
        $excel->_campo($letras[$temp] . $n, $value);
        $temp++;
    }

    $excel->_formatoNumero($letras[$temp] . $n);
    $excel->_campo($letras[$temp] . $n, $empleado['Total Asignaciones']);    

    $excel->_formatoNumero($letras[$temp + 1] . $n);
    $excel->_campo($letras[$temp + 1] . $n, $empleado['Total Sueldo + Asignaciones']);    

    $temp = $temp + 2;
    foreach ($empleado['Deducciones'] as $value) {
        $excel->_formatoNumero($letras[$temp] . $n);
        $excel->_campo($letras[$temp] . $n, $value);
        $temp++;
    }

    $excel->_formatoNumero($letras[$temp] . $n);
    $excel->_campo($letras[$temp] . $n, $empleado['Total de Deducciones']);    

    $excel->_formatoNumero($letras[$temp + 1] . $n);
    $excel->_campo($letras[$temp + 1] . $n, $empleado['Total a Cancelar']);    

    $n++;
}
$n--;
$excel->_bordeGrupo('A16:' . $letras[$temp + 1] . $n);

//**************************************************
$time_end = time() - $time;
$tm = "TIEMPO: " . $time_end . " seg";
$mem_usage = memory_get_usage(true);

if ($mem_usage < 1024)
    $mem = $mem_usage . " bytes";
elseif ($mem_usage < 1048576)
    $mem = round($mem_usage / 1024, 2) . " kilobytes";
else
    $mem = round($mem_usage / 1048576, 2) . " megabytes";

//**************************************************


$excel->_campo('B10', $tm);
$excel->_bordeSimple('B10');

$excel->_campo('C10', $mem);
$excel->_bordeSimple('C10');

$nombre = 'nomina';
$excel->_output($nombre);
?> 
