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
    $excel->_fechaExcel('F' . $n, $empleado['Cestaticket_Empleado']['INGRESO']);
    $excel->_campo('G' . $n, $empleado['Cestaticket_Empleado']['PROGRAMA']);
    $excel->_campo('H' . $n, $empleado['Cestaticket_Empleado']['ACTIVIDAD_PROYECTO']);
    $excel->_campo('I' . $n, $empleado['Cestaticket_Empleado']['DIAS_HABILES']);
    $excel->_campo('J' . $n, $empleado['Cestaticket_Empleado']['DIAS_LABORADOS']);
    $excel->_campo('K' . $n, $empleado['Cestaticket_Empleado']['DIAS_ADICIONALES']);    
    $excel->_campo('L' . $n, $empleado['Cestaticket_Empleado']['TOTAL_DIAS']);
    $excel->_campo('M' . $n, $empleado['Cestaticket_Empleado']['DIAS_DESCONTAR']);    
    $excel->_campo('N' . $n, $empleado['Cestaticket_Empleado']['TOTAL_DIAS_EFEC']);
    $excel->_campo('O' . $n, $empleado['Cestaticket_Empleado']['VALOR_DIARIO']);
    $excel->_campo('P' . $n, $empleado['Cestaticket_Empleado']['TOTAL']);
    $num++;
    $n++;
}

$t=98;
foreach ($resumen as $value) {
    $excel->_campo('G'.$t,$value['Programa']['CODIGO']);
    $excel->_campo('H'.$t,$value['Programa']['NUMERO']);
    $excel->_campo('I'.$t,$value['Programa']['DIAS_HABILES']);
    $excel->_campo('J'.$t,$value['Programa']['DIAS_LABORADOS']);
    $excel->_campo('K'.$t,$value['Programa']['DIAS_ADICIONALES']);
    $excel->_campo('L'.$t,$value['Programa']['TOTAL_DIAS']);
    $excel->_campo('M'.$t,$value['Programa']['DIAS_DESCONTAR']);
    $excel->_campo('N'.$t,$value['Programa']['TOTAL_DIAS_EFEC']);
    $excel->_campo('O'.$t,$empleados['0']['Cestaticket_Empleado']['VALOR_DIARIO']);
    $excel->_campo('P'.$t,$value['Programa']['TOTAL']);    
    $t++;
}
?>