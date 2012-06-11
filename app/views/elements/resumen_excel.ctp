<?php

// Limites que se encuentran en el template usados a la hora de ocultar las filas o columnas en blanco
$limite_asignaciones = 8;
$limite_deducciones = 9;
$limite_programas = 9;

$letras = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I',
    '9' => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q',
    '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y',
    '25' => 'Z', '26' => 'AA', '27' => 'AB', '28' => 'AC', '29' => 'AD', '30' => 'AE', '31' => 'AF', '32' => 'AG', '33' => 'AH',
    '34' => 'AI', '35' => 'AJ', '36' => 'AK', '37' => 'AL', '38' => 'AM');


$data = array();

//--------------------------------------------------------------
$excel->_activeSheet("Resumen");
//-------------------------------------------------------------

if ($grupo == 'Empleado') {
    $excel->_campo("B14", "Sueldo Básicos a personal Fijo a tiempo completo");
    $excel->_campo("B15", "Partida: 4.01.01.01.00");
}
if ($grupo == 'Obrero') {
    $excel->_campo("B14", "Salarios a Obreros en Puestos Permanentes a Tiempo Completo");
    $excel->_campo("B15", "Partida: 4.01.01.10.00");
}
$asignaciones = array_keys($resumen['0']['Asignaciones']);
$asig = count($asignaciones);
$marca = 2;
foreach ($asignaciones as $asignacion) {
    $excel->_campo($letras[$marca] . '14', $asignacion);
    $marca++;
}

while ($marca < $limite_asignaciones + 2) {
    $excel->_ocultarColumna($letras[$marca]);
    $marca++;
}
$marca = $marca + 2;

$deducciones = array_keys($resumen['0']['Deducciones']);
$deduc = count($deducciones);
foreach ($deducciones as $deduccion) {
    $excel->_campo($letras[$marca] . '15', $deduccion);
    $marca++;
}
$tem = $marca;
while ($marca < $tem + ($limite_deducciones - $deduc)) {
    $excel->_ocultarColumna($letras[$marca]);
    $marca++;
}


$t = 16;
foreach ($resumen as $value) {
    if (isset($value['Programa']['CODIGO'])) {
        $text = $value['Programa']['NOMBRE'] . "\n" . "Programa: " . $value['Programa']['CODIGO'] . "  -  " . $value['Programa']['TIPO'] . ": " . $value['Programa']['NUMERO'];
        $excel->_campo("A" . $t, $text);
        $excel->_campo("B" . $t, $value['Programa']['TOTAL_SUELDO']);
        $marca = 2;
        foreach ($value['Asignaciones'] as $res_asig) {
            $excel->_campo($letras[$marca] . $t, $res_asig);
            $marca++;
        }
        $marca = $marca + ($limite_asignaciones - $asig);
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_ASIGNACIONES']);
        $marca++;
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_SUELDO_ASIGNACIONES']);
        $marca++;
        foreach ($value['Deducciones'] as $res_deduc) {
            $excel->_campo($letras[$marca] . $t, $res_deduc);
            $marca++;
        }
        $marca = $marca + ($limite_deducciones - $deduc);
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_DEDUCCIONES']);
        $marca++;
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_SUELDO_CANCELAR']);
        $marca++;
        $t++;
        //------------ TOTALES -------------- AL FINAL
    } else {
        $excel->_groupBold("A" . $t . ":AA" . $t);
        $text = $value['Programa']['NOMBRE'];
        $excel->_campo("A" . $t, $text);
        $excel->_campo("B" . $t, $value['Programa']['TOTAL_SUELDO']);
        $marca = 2;
        foreach ($value['Asignaciones'] as $res_asig) {
            $excel->_campo($letras[$marca] . $t, $res_asig);
            $marca++;
        }
        $marca = $marca + ($limite_asignaciones - $asig);
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_ASIGNACIONES']);
        $marca++;
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_SUELDO_ASIGNACIONES']);
        $marca++;
        foreach ($value['Deducciones'] as $res_deduc) {
            $excel->_campo($letras[$marca] . $t, $res_deduc);
            $marca++;
        }
        $marca = $marca + ($limite_deducciones - $deduc);
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_DEDUCCIONES']);
        $marca++;
        $excel->_campo($letras[$marca] . $t, $value['Programa']['TOTAL_SUELDO_CANCELAR']);
        $marca++;
        $t++;
    }
}

$pr = count($resumen);
$tem2 = $t;
while ($t < $tem2 + ($limite_programas - $pr)) {
    $excel->_ocultarFila($t);
    $t++;
}
?>