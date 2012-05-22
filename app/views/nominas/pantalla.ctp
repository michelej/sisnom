<?php //debug($empleados);?>
<div class="box2">
    <div class="content2" >        
        <table  class="tabla">
            <thead>
                <tr>
                    <th ></th>
                    <th style="width:8%"></th>
                    <th style="width:2%"></th>
                    <th ></th>
                    <th ></th>
                    <th ></th>
                    <th ></th>
                    <th colspan="2">Periodo Laborado</th>
                    <th  rowspan="2">DiasLaborados</th>
                    <th  rowspan="2">Sub Total Sueldo Basico</th>
                    <?php $count=count(array_keys($empleados['0']['Nomina_Empleado']['Asignaciones'])); ?>
                    <th colspan=<?php echo '"'.$count.'"'?>>Asignaciones</th>
                    <th  rowspan="2">Total de Asignaciones</th>
                    <th  rowspan="2">Total  Sueldo +Asignaciones</th>
                    <?php $count=count(array_keys($empleados['0']['Nomina_Empleado']['Deducciones'])); ?>
                    <th colspan=<?php echo '"'.$count.'"'?>>Deducciones</th>                    
                    <th  rowspan="2">Total de Deducciones</th>
                    <th  rowspan="2">TOTAL A CANCELAR</th>
                </tr>
                <tr>
                    <th style="width:1%">N#</th>
                    <th style="width:25%">Nombres y Apellidos</th>
                    <th style="width:5%">Cedula de Identidad / Rif</th>
                    <th style="width:25%">Cargo</th>
                    <th style="width:5%">Salario Basico Mensual</th>
                    <th style="width:5%">Fecha de Ingreso</th>
                    <th style="width:5%">Salario Diario</th>
                    <th style="width:5%">Desde</th>
                    <th style="width:5%">Hasta</th>                    
                    <?php                    
                        $asignaciones=array_keys($empleados['0']['Nomina_Empleado']['Asignaciones']);                        
                        foreach ($asignaciones as $asignacion) {
                            echo '<th style="width:5%">'.$asignacion."</td>";
                        }
                    ?>                    
                    <?php                    
                        $deducciones=array_keys($empleados['0']['Nomina_Empleado']['Deducciones']);                        
                        foreach ($deducciones as $deduccion) {
                            echo '<th style="width:5%">'.$deduccion."</td>";
                        }
                    ?> 
                </tr>
            </thead>
            <tbody>	
                <?php
                $i = 1;
                foreach ($empleados as $empleado):
                    echo '<tr class="modo1">';
                    echo '<td>' . $i++ . '</td>';
                    echo '<td>' . $empleado['Nomina_Empleado']['NOMBRE'] . " " . $empleado['Nomina_Empleado']['APELLIDO'] . '</td>';
                    echo '<td style="text-align:center;">' . $empleado['Nomina_Empleado']['CEDULA']. '</td>';
                    echo '<td>' . $empleado['Nomina_Empleado']['CARGO'] . '</td>';
                    echo '<td>' . number_format($empleado['Nomina_Empleado']['SUELDO_BASE'], 2, ',', '.') . '</td>';
                    echo '<td>' . $empleado['Nomina_Empleado']['INGRESO'] . '</td>';
                    echo '<td>' . number_format($empleado['Nomina_Empleado']['SUELDO_DIARIO'], 2, ',', '.') . '</td>';
                    echo '<td>' . formatoFechaAfterFind($empleado['Nomina_Empleado']['FECHA_INI']) . '</td>';
                    echo '<td>' . formatoFechaAfterFind($empleado['Nomina_Empleado']['FECHA_FIN']) . '</td>';
                    echo '<td>' . $empleado['Nomina_Empleado']['DIAS_LABORADOS'] . '</td>';
                    echo '<td>' . number_format($empleado['Nomina_Empleado']['SUELDO_BASICO'], 2, ',', '.') . '</td>';
                    foreach ($empleado['Nomina_Empleado']['Asignaciones'] as $value) {
                        echo '<td>' . number_format($value,2,',','.') . '</td>';
                    }                    
                    echo '<td>' . number_format($empleado['Nomina_Empleado']['TOTAL_ASIGNACIONES'], 2, ',', '.') . '</td>';
                    echo '<td>' . number_format($empleado['Nomina_Empleado']['SUELDO_BASICO_ASIGNACIONES'], 2, ',', '.') . '</td>';
                    foreach ($empleado['Nomina_Empleado']['Deducciones'] as $value) {
                        echo '<td>' . number_format($value,2,',','.') . '</td>';
                    }
                    echo '<td>' . number_format($empleado['Nomina_Empleado']['TOTAL_DEDUCCIONES'], 2, ',', '.') . '</td>';
                    echo '<td>' . number_format($empleado['Nomina_Empleado']['TOTAL_SUELDO'], 2, ',', '.') . '</td>';
                    echo '</tr>';
                endforeach;
                ?>
            </tbody>
            <tfoot>
            </tfoot>
        </table>        
    </div>
</div>