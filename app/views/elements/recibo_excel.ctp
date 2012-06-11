<?php

$limite_asignaciones = 8;
$limite_deducciones = 9;

$letras = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I',
    '9' => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q',
    '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y',
    '25' => 'Z', '26' => 'AA', '27' => 'AB', '28' => 'AC', '29' => 'AD', '30' => 'AE', '31' => 'AF', '32' => 'AG', '33' => 'AH',
    '34' => 'AI', '35' => 'AJ', '36' => 'AK', '37' => 'AL', '38' => 'AM');


//--------------------------------------------------------------
$excel->_activeSheet("Recibo");
$inicio_plantilla=10; // FILA DONDE SE EMPIEZAN A AGREGAR LAS ASIGNACIONES
//-------------------------------------------------------------
//ASIGNACIONES
$asignaciones = array_keys($empleados['0']['Nomina_Empleado']['Asignaciones']);
$asig = count($asignaciones);
$marca = $inicio_plantilla; 
$marca_fila = 14 + ($limite_asignaciones - $asig); // VIENE DE LA NOMINA SON LAS COLUMNAS
$marca_fila++;
foreach ($asignaciones as $asignacion) {
    $excel->_campo('A' . $marca, $asignacion);
    // PHPExcel en INGLES ASI QUE LAS FORMULAS DE EXCEL SON EN INGLES NO IMPORTA QUE EL EXCEL ESTE EN ESPAÑOL 
    $formula='=VLOOKUP(G5,Nomina!$A$16:$AI$94,'.$marca_fila.')';        
    $excel->_campo('C' . $marca,$formula);    
    $marca_fila++;
    $marca++;
}

// TOTAL ASIGNACIONES
$formula='=VLOOKUP(G5,Nomina!$A$16:$AI$94,'.$marca_fila.')';        
$excel->_campo('G' . ($marca-1),$formula);    
$marca_fila=$marca_fila+2;

// ELIMINO LAS FILAS VACIAS
while ($marca < $limite_asignaciones + $inicio_plantilla) {
    $excel->_ocultarFila($marca);
    $marca++;
}

// DEDUCCIONES
$marca = $inicio_plantilla + $limite_asignaciones;
$deducciones = array_keys($empleados['0']['Nomina_Empleado']['Deducciones']);
$deduc = count($deducciones);
foreach ($deducciones as $deduccion) {
    $excel->_campo('A' . $marca, $deduccion);
    // PHPExcel en INGLES ASI QUE LAS FORMULAS DE EXCEL SON EN INGLES NO IMPORTA QUE EL EXCEL ESTE EN ESPAÑOL 
    $formula='=VLOOKUP(G5,Nomina!$A$16:$AI$94,'.$marca_fila.')';        
    $excel->_campo('E' . $marca,$formula);    
    $marca++;
    $marca_fila++;
}

// TOTAL DEDUCCIONES
$marca_fila=$marca_fila+($limite_deducciones-$deduc);
$formula='=VLOOKUP(G5,Nomina!$A$16:$AI$94,'.$marca_fila.')';        
//debug($formula);
$excel->_campo('G' . ($marca-1),$formula);    

//TOTAL SUELDO
$marca_fila++;
$formula='=VLOOKUP(G5,Nomina!$A$16:$AI$94,'.$marca_fila.')';        
$excel->_campo('G' . ($limite_deducciones + $inicio_plantilla + $limite_asignaciones),$formula);    

// ELIMINO LAS FILAS VACIAS
while ($marca < $limite_deducciones + $inicio_plantilla + $limite_asignaciones) {
    $excel->_ocultarFila($marca);
    $marca++;
}
?>