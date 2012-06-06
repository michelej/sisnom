<div class="box2">
    <div class="content2" >        
        <table  class="tabla" style="width: 3000px">
            <thead>
                <tr>
                    <th style="width:2%"></th>
                    <th style="width:2%"></th>
                    <th style="width:0.5%"></th>
                    <th style="width:9%"></th>
                    <th style="width:3%"></th>
                    <th style="width:12%"></th>
                    <th style="width:2.5%"></th>
                    <th style="width:2.5%"></th>                    
                    <th style="width:2%"></th>
                    <th colspan="2" style="text-align: center;width:6%">Periodo Laborado</th>
                    <th style="width:2%;text-align: center" rowspan="2" >Dias Laborados</th>
                    <th  rowspan="2"  style="text-align: center;width:3%">Sub Total Sueldo Basico</th>
                    <?php $count=count(array_keys($empleados['0']['Nomina_Empleado']['Asignaciones'])); ?>
                    <th style="text-align: center" colspan=<?php echo '"'.$count.'"'?>>Asignaciones</th>
                    <th  rowspan="2"  style="text-align: center">Total de Asignaciones</th>
                    <th  rowspan="2"  style="text-align: center">Total  Sueldo + Asignaciones</th>
                    <?php $count=count(array_keys($empleados['0']['Nomina_Empleado']['Deducciones'])); ?>
                    <th style="text-align: center" colspan=<?php echo '"'.$count.'"'?>>Deducciones</th>                    
                    <th  rowspan="2"  style="text-align: center">Total de Deducciones</th>
                    <th  rowspan="2" style="text-align: center">TOTAL A CANCELAR</th>
                </tr>
                <tr>
                    <th style="text-align: center"> Programa</th>
                    <th style="text-align: center">Actividad / Proyecto</th>
                    <th>N#</th>                    
                    <th style="text-align: center">Apellidos y Nombres</th>
                    <th style="text-align: center">Cedula de Identidad / Rif</th>
                    <th style="text-align: center">Cargo</th>
                    <th style="text-align: center">Salario Basico Mensual</th>
                    <th style="text-align: center">Fecha de Ingreso</th>                    
                    <th style="text-align: center">Salario Diario</th>
                    <th style="text-align: center">Desde</th>
                    <th style="text-align: center">Hasta</th>                    
                    <?php                    
                        $asignaciones=array_keys($empleados['0']['Nomina_Empleado']['Asignaciones']);                        
                        foreach ($asignaciones as $asignacion) {
                            echo '<th style="width:2.5%; text-align: center; word-wrap: break-word">'.$asignacion."</td>";
                        }
                    ?>                    
                    <?php                    
                        $deducciones=array_keys($empleados['0']['Nomina_Empleado']['Deducciones']);                        
                        foreach ($deducciones as $deduccion) {
                            echo '<th style="width:2.5%; text-align: center; word-wrap: break-word">'.$deduccion."</td>";
                        }
                    ?> 
                </tr>
            </thead>
            <tbody>	
                <?php
                $num = 1;                                    
                foreach ($empleados as $empleado):
                    $class = 'modo1';                    
                    if ($num % 2 == 0) {
                        $class = 'modo2';
                    }                       
                    echo '<tr class="'.$class.'">';
                    echo '<td>' . $empleado['Nomina_Empleado']['PROGRAMA'] . '</td>';
                    echo '<td>' . $empleado['Nomina_Empleado']['ACTIVIDAD_PROYECTO'] . '</td>';
                    echo '<td>' . $num . '</td>';
                    echo '<td>' . $empleado['Nomina_Empleado']['APELLIDO'] . " " . $empleado['Nomina_Empleado']['NOMBRE'] . '</td>';
                    echo '<td style="text-align:center;">' . $empleado['Nomina_Empleado']['CEDULA']. '</td>';
                    echo '<td>' . $empleado['Nomina_Empleado']['CARGO'] . '</td>';
                    echo '<td style="text-align: right;">' . number_format($empleado['Nomina_Empleado']['SUELDO_BASE'], 2, ',', '.') . '</td>';
                    echo '<td style="text-align: center;">' . $empleado['Nomina_Empleado']['INGRESO'] . '</td>';                    
                    echo '<td style="text-align: right;">' . number_format($empleado['Nomina_Empleado']['SUELDO_DIARIO'], 2, ',', '.') . '</td>';
                    echo '<td style="text-align: center;">' . fechaElegible(formatoFechaAfterFind($empleado['Nomina_Empleado']['FECHA_INI'])) . '</td>';
                    echo '<td style="text-align: center;">' . fechaElegible(formatoFechaAfterFind($empleado['Nomina_Empleado']['FECHA_FIN'])) . '</td>';
                    echo '<td style="text-align: center;">' . $empleado['Nomina_Empleado']['DIAS_LABORADOS'] . '</td>';
                    echo '<td style="text-align: center;">' . number_format($empleado['Nomina_Empleado']['SUELDO_BASICO'], 2, ',', '.') . '</td>';
                    foreach ($empleado['Nomina_Empleado']['Asignaciones'] as $value) {
                        echo '<td style="text-align: center;">' . number_format($value,2,',','.') . '</td>';
                    }                    
                    echo '<td style="text-align: center;">' . number_format($empleado['Nomina_Empleado']['TOTAL_ASIGNACIONES'], 2, ',', '.') . '</td>';
                    echo '<td style="text-align: center;">' . number_format($empleado['Nomina_Empleado']['SUELDO_BASICO_ASIGNACIONES'], 2, ',', '.') . '</td>';
                    foreach ($empleado['Nomina_Empleado']['Deducciones'] as $value) {
                        echo '<td style="text-align: center;">' . number_format($value,2,',','.') . '</td>';
                    }
                    echo '<td style="text-align: right;">' . number_format($empleado['Nomina_Empleado']['TOTAL_DEDUCCIONES'], 2, ',', '.') . '</td>';
                    echo '<td style="text-align: right;">' . number_format($empleado['Nomina_Empleado']['TOTAL_SUELDO'], 2, ',', '.') . '</td>';
                    echo '</tr>';
                    $num++;
                endforeach;
                ?>
            </tbody>
            <tfoot>
            </tfoot>
        </table>        
    </div>
</div>