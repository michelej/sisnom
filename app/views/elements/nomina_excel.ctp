<?php

// Limites que se encuentran en el template usados a la hora de ocultar las filas o columnas en blanco
$limite_asignaciones = 10;
$limite_deducciones = 14;

$letras = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I',
    '9' => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q',
    '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y',
    '25' => 'Z', '26' => 'AA', '27' => 'AB', '28' => 'AC', '29' => 'AD', '30' => 'AE', '31' => 'AF', '32' => 'AG', '33' => 'AH',
    '34' => 'AI', '35' => 'AJ', '36' => 'AK', '37' => 'AL', '38' => 'AM','39'=>'AN','40'=>'AO','41'=>'AP');


$data = array();

$i = 1;
foreach ($empleados as $key => $empleado):

    $data[$key]['Programa'] = $empleado['Nomina_Empleado']['PROGRAMA'];
    $data[$key]['Actividad o Proyecto'] = $empleado['Nomina_Empleado']['ACTIVIDAD_PROYECTO'];
    $data[$key]['N'] = $i++;
    $data[$key]['Nombres y Apellidos'] = $empleado['Nomina_Empleado']['APELLIDO'] . " " . $empleado['Nomina_Empleado']['NOMBRE'];
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

//--------------------------------------------------------------
$excel->_activeSheet("Nomina");
//-------------------------------------------------------------
$text = "NOMINA CORRESPONDIENTE A LA " . strtoupper($nomina['Nomina']['QUINCENA']) . " QUINCENA DEL MES DE " . strtoupper($nomina['Nomina']['MES'] . " " . $nomina['Nomina']['AÑO']);
$text = $text . " (DEL " . $nomina['Nomina']['FECHA_INI'] . " AL " . $nomina['Nomina']['FECHA_FIN'] . ")";
$excel->_campo("B6", $text);

if ($modalidad == 'Contratado') {
    $text = "PERSONAL " . strtoupper($modalidad);
    $excel->_campo("B8", $text);
} else {
    $text = "PERSONAL " . strtoupper($grupo) . " " . strtoupper($modalidad);
    $excel->_campo("B8", $text);
}


//--------------------------------------------------------
// 
$excel->_campo("Y12", "15"); // DIAS 15
$excel->_campo("N13", "2");  // SEMANAS DE LA QUINCENA 2

$excel->_fechaExcel("AA12", $nomina['Nomina']['FECHA_INI']);
$excel->_fechaExcel("AA13", $nomina['Nomina']['FECHA_FIN']);
$excel->_campo("Y13", $info_extra['Quincena']);
//--------------------------------------------------------
//------------------------------------------------------
$asignaciones = array_keys($empleados['0']['Nomina_Empleado']['Asignaciones']);
$asig = count($asignaciones);
$marca = 14 + ($limite_asignaciones - $asig);
foreach ($asignaciones as $asignacion) {
    $excel->_campo($letras[$marca] . '15', $asignacion);
    $marca++;
}

$deducciones = array_keys($empleados['0']['Nomina_Empleado']['Deducciones']);
$deduc = count($deducciones);
$marca = $marca + 2;
foreach ($deducciones as $deduccion) {
    $excel->_campo($letras[$marca] . '15', $deduccion);
    $marca++;
}

$n = 16;
foreach ($data as $empleado) {
    $excel->_campoString('A' . $n, sprintf("%04d", (string) $empleado['N']));
    $excel->_campo('B' . $n, $empleado['N']);
    $excel->_campo('C' . $n, $empleado['Nombres y Apellidos']);
    $excel->_campo('D' . $n, $empleado['Cedula de Identidad']);
    $excel->_campo('E' . $n, $empleado['Cargo']);
    $excel->_campo('F' . $n, $empleado['Sueldo Basico Mensual']);
    $excel->_campo('G' . $n, $empleado['Fecha de Ingreso']);
    $excel->_campo('H' . $n, $empleado['Programa']);
    $excel->_campo('I' . $n, $empleado['Actividad o Proyecto']);
    $excel->_campo('J' . $n, $empleado['Salario Diario']);
    $excel->_fechaExcel('K' . $n, $empleado['Desde']);
    $excel->_fechaExcel('L' . $n, $empleado['Hasta']);
    $excel->_campo('M' . $n, $empleado['Dias Laborados']);
    $excel->_campo('N' . $n, $empleado['Sub Total Sueldo Basico']);

    $temp = 14 + ($limite_asignaciones - $asig);
    foreach ($empleado['Asignaciones'] as $value) {
        $excel->_campo($letras[$temp] . $n, $value);
        $temp++;
    }

    for ($index = 14; $index < 14 + ($limite_asignaciones - $asig); $index++) {
        $excel->_ocultarColumna($letras[$index]);
    }

    $excel->_campo($letras[$temp] . $n, $empleado['Total Asignaciones']);
    $temp++;
    $excel->_campo($letras[$temp] . $n, $empleado['Total Sueldo + Asignaciones']);
    $temp++;

    $limi = $temp;
    foreach ($empleado['Deducciones'] as $value) {
        $excel->_campo($letras[$temp] . $n, $value);
        $temp++;
    }

    for ($index = $limi + $deduc; $index < $limi + $limite_deducciones; $index++) {
        $excel->_ocultarColumna($letras[$index]);
    }
    $temp = $temp + ($limite_deducciones - $deduc);
    $excel->_campo($letras[$temp] . $n, $empleado['Total de Deducciones']);
    $temp++;
    $excel->_campo($letras[$temp] . $n, $empleado['Total a Cancelar']);
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

        $temp = 14 + ($limite_asignaciones - $asig);
        foreach ($value['Asignaciones'] as $as) {
            $excel->_campo($letras[$temp] . $t, $as);
            $temp++;
        }

        $excel->_campo($letras[$temp] . $t, $value['Programa']['TOTAL_ASIGNACIONES']);
        $temp++;
        $excel->_campo($letras[$temp] . $t, $value['Programa']['TOTAL_SUELDO_ASIGNACIONES']);
        $temp++;

        foreach ($value['Deducciones'] as $de) {
            $excel->_campo($letras[$temp] . $t, $de);
            $temp++;
        }
        $temp = $temp + ($limite_deducciones - $deduc);
        $excel->_campo($letras[$temp] . $t, $value['Programa']['TOTAL_DEDUCCIONES']);
        $temp++;
        $excel->_campo($letras[$temp] . $t, $value['Programa']['TOTAL_SUELDO_CANCELAR']);

        $t++;
    } else {
        $excel->_campo("F96", $value['Programa']['TOTAL_SUELDO_BASE']);
        $excel->_campo("N96", $value['Programa']['TOTAL_SUELDO']);

        $temp = 14 + ($limite_asignaciones - $asig);
        foreach ($value['Asignaciones'] as $as) {
            $excel->_campo($letras[$temp] . "96", $as);
            $temp++;
        }

        $excel->_campo($letras[$temp] . "96", $value['Programa']['TOTAL_ASIGNACIONES']);
        $temp++;
        $excel->_campo($letras[$temp] . "96", $value['Programa']['TOTAL_SUELDO_ASIGNACIONES']);
        $temp++;

        foreach ($value['Deducciones'] as $de) {
            $excel->_campo($letras[$temp] . "96", $de);
            $temp++;
        }
        $temp = $temp + ($limite_deducciones - $deduc);
        $excel->_campo($letras[$temp] . "96", $value['Programa']['TOTAL_DEDUCCIONES']);
        $temp++;
        $excel->_campo($letras[$temp] . "96", $value['Programa']['TOTAL_SUELDO_CANCELAR']);
    }
}
// $excel->_autoFilter("H15:I15"); NO FUNCIONA PARA Excel5 .XLS solo 2007
?>