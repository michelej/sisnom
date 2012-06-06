<?php

$letras = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I',
    '9' => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q',
    '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y',
    '25' => 'Z', '26' => 'AA', '27' => 'AB', '28' => 'AC', '29' => 'AD', '30' => 'AE', '31' => 'AF', '32' => 'AG', '33' => 'AH',
    '34' => 'AI', '35' => 'AJ', '36' => 'AK', '37' => 'AL', '38' => 'AM');


$data = array();

$i = 1;
foreach ($empleados as $key => $empleado):

    $data[$key]['Programa'] = $empleado['Nomina_Empleado']['PROGRAMA'];
    $data[$key]['Actividad o Proyecto'] = $empleado['Nomina_Empleado']['ACTIVIDAD_PROYECTO'];
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

$excel->_cargarTemplate();
$excel->_activeSheet("Nomina");

//-------------------------------------------------------------
$text = "NOMINA CORRESPONDIENTE A LA " . strtoupper($nomina['Nomina']['QUINCENA']) . " QUINCENA DEL MES DE " . strtoupper($nomina['Nomina']['MES'] . " " . $nomina['Nomina']['AÑO']);
$text = $text . " (DEL " . $nomina['Nomina']['FECHA_INI'] . " AL " . $nomina['Nomina']['FECHA_FIN'] . ")";
$excel->_campo("B6", $text);

$text = "PERSONAL " . strtoupper($grupo) . " " . strtoupper($modalidad);
$excel->_campo("B8", $text);

$excel->_campo("U12", "15"); // DIAS 15
$excel->_campo("S13", "2");  // SEMANAS DE LA QUINCENA 2

$excel->_campo("W12", $nomina['Nomina']['FECHA_INI']);
$excel->_campo("W13", $nomina['Nomina']['FECHA_FIN']);
$excel->_campo("U13", $info_extra['Quincena']);

//------------------------------------------------------
$asignaciones = array_keys($empleados['0']['Nomina_Empleado']['Asignaciones']);
$asig = count($asignaciones);
$marca = 14 + (8 - $asig);
foreach ($asignaciones as $asignacion) {
    $excel->_campo($letras[$marca] . '15', $asignacion);
    $marca++;
}


$deducciones = array_keys($empleados['0']['Nomina_Empleado']['Deducciones']);
$deduc = count($deducciones);
$marca = 24;
foreach ($deducciones as $deduccion) {
    $excel->_campo($letras[$marca] . '15', $deduccion);
    $marca++;
}

$n = 16;
foreach ($data as $empleado) {
    $excel->_campo('B' . $n, $empleado['N']);
    $excel->_campo('C' . $n, $empleado['Nombres y Apellidos']);
    $excel->_campo('D' . $n, $empleado['Cedula de Identidad']);
    $excel->_campo('E' . $n, $empleado['Cargo']);
    $excel->_campo('F' . $n, $empleado['Sueldo Basico Mensual']);
    $excel->_campo('G' . $n, $empleado['Fecha de Ingreso']);
    $excel->_campo('H' . $n, $empleado['Programa']);
    $excel->_campo('I' . $n, $empleado['Actividad o Proyecto']);
    $excel->_campo('J' . $n, $empleado['Salario Diario']);
    $excel->_campo('K' . $n, fechaElegibleNomina($empleado['Desde']));
    //$excel->_formatoFecha('K' . $n);
    $excel->_campo('L' . $n, fechaElegibleNomina($empleado['Hasta']));
    //$excel->_formatoFecha('L' . $n);
    $excel->_campo('M' . $n, $empleado['Dias Laborados']);
    $excel->_campo('N' . $n, $empleado['Sub Total Sueldo Basico']);

    $temp = 14 + (8 - $asig);
    foreach ($empleado['Asignaciones'] as $value) {
        $excel->_campo($letras[$temp] . $n, $value);
        $temp++;
    }

    for ($index = 14; $index < 14 + (8 - $asig); $index++) {
        $excel->_ocultarColumna($letras[$index]);
    }

    $excel->_campo("W" . $n, $empleado['Total Asignaciones']);
    $excel->_campo("X" . $n, $empleado['Total Sueldo + Asignaciones']);

    $temp = 24;
    foreach ($empleado['Deducciones'] as $value) {
        $excel->_campo($letras[$temp] . $n, $value);
        $temp++;
    }

    for ($index = 24 + $deduc; $index < 24 + 9; $index++) {
        $excel->_ocultarColumna($letras[$index]);
    }

    $excel->_campo("AH" . $n, $empleado['Total de Deducciones']);
    $excel->_campo("AI" . $n, $empleado['Total a Cancelar']);
    $n++;
}


$t = 98;
foreach ($resumen as $value) {
    if (isset($value['Programa']['CODIGO'])) {
        $prg = $value['Programa']['CODIGO'];
        $tip = strtoupper($value['Programa']['TIPO']);
        $act = $value['Programa']['NUMERO'];
        $excel->_campo("E" . $t, "TOTAL PROGRAMA " . $prg . " " . $tip . " " . $act);
        $excel->_campo("F" . $t, $value['Programa']['TOTAL_SUELDO_BASE']);
        $excel->_campo("H" . $t, $prg);
        $excel->_campo("I" . $t, $act);
        $excel->_campo("N" . $t, $value['Programa']['TOTAL_SUELDO']);

        $temp = 14 + (8 - $asig);
        foreach ($value['Asignaciones'] as $as) {
            $excel->_campo($letras[$temp] . $t, $as);
            $temp++;
        }

        $excel->_campo("W" . $t, $value['Programa']['TOTAL_ASIGNACIONES']);
        $excel->_campo("X" . $t, $value['Programa']['TOTAL_SUELDO_ASIGNACIONES']);

        $temp = 24;
        foreach ($value['Deducciones'] as $de) {
            $excel->_campo($letras[$temp] . $t, $de);
            $temp++;
        }

        $excel->_campo("AH" . $t, $value['Programa']['TOTAL_DEDUCCIONES']);
        $excel->_campo("AI" . $t, $value['Programa']['TOTAL_SUELDO_CANCELAR']);

        $t++;
    }else{
        $excel->_campo("F96", $value['Programa']['TOTAL_SUELDO_BASE']);        
        $excel->_campo("N96", $value['Programa']['TOTAL_SUELDO']);

        $temp = 14 + (8 - $asig);
        foreach ($value['Asignaciones'] as $as) {
            $excel->_campo($letras[$temp] ."96", $as);
            $temp++;
        }

        $excel->_campo("W96", $value['Programa']['TOTAL_ASIGNACIONES']);
        $excel->_campo("X96", $value['Programa']['TOTAL_SUELDO_ASIGNACIONES']);

        $temp = 24;
        foreach ($value['Deducciones'] as $de) {
            $excel->_campo($letras[$temp] ."96", $de);
            $temp++;
        }

        $excel->_campo("AH96", $value['Programa']['TOTAL_DEDUCCIONES']);
        $excel->_campo("AI96", $value['Programa']['TOTAL_SUELDO_CANCELAR']);
        
    }
}








// $excel->_autoFilter("H15:I15"); NO FUNCIONA PARA Excel5 .XLS solo 2007
$excel->_output('Nomina');
?>