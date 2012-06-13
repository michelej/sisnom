<?php

//--------------------------------------------------------------
$excel->_activeSheet("Cestaticket");
//-------------------------------------------------------------

$text = "NOMINA DEL BENEFICIO DE ALIMENTACION DEL PERSONAL ";
if ($modalidad == 'Contratado') {
    $text = $text . strtoupper($modalidad);
} else {
    $text = $text . strtoupper($grupo) . " " . strtoupper($modalidad);
}
$text=$text.", "."CORRESPONDIENTE AL MES DE ".strtoupper($mes)." DE ".$año;
$excel->_campo("B11", $text);


$n = 16;
$num = 1;
foreach ($empleados as $empleado) {
    $excel->_campo('B' . $n, $num);
    $excel->_campo('C' . $n, $empleado['Cestaticket_Empleado']['NOMBRE'] . " " . $empleado['Cestaticket_Empleado']['APELLIDO']);
    $excel->_campo('D' . $n, $empleado['Cestaticket_Empleado']['CEDULA']);
    $excel->_campo('E' . $n, $empleado['Cestaticket_Empleado']['CARGO']);
    $excel->_campo('F' . $n, $empleado['Cestaticket_Empleado']['INGRESO']);
    $excel->_campo('G' . $n, $empleado['Cestaticket_Empleado']['PROGRAMA']);
    $excel->_campo('H' . $n, $empleado['Cestaticket_Empleado']['ACTIVIDAD_PROYECTO']);
    $excel->_campo('I' . $n, $empleado['Cestaticket_Empleado']['DIAS_HABILES']);
    $excel->_campo('J' . $n, $empleado['Cestaticket_Empleado']['DIAS_LABORADOS']);
    $excel->_campo('K' . $n, $empleado['Cestaticket_Empleado']['DIAS_ADICIONALES']);
    $total1 = $empleado['Cestaticket_Empleado']['DIAS_ADICIONALES'] + $empleado['Cestaticket_Empleado']['DIAS_LABORADOS'];
    $excel->_campo('L' . $n, $total1);
    $excel->_campo('M' . $n, $empleado['Cestaticket_Empleado']['DIAS_DESCONTAR']);
    $efec = $total1 - $empleado['Cestaticket_Empleado']['DIAS_DESCONTAR'];
    $excel->_campo('N' . $n, $efec);
    $excel->_campo('O' . $n, $empleado['Cestaticket_Empleado']['VALOR_DIARIO']);
    $excel->_campo('P' . $n, $empleado['Cestaticket_Empleado']['TOTAL']);
    $num++;
    $n++;
}
?>