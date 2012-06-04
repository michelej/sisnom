<div class="box2">
    <div class="content2" >        
        <table class="tabla" style="width:1800px;">
            <thead>
                <tr>
                    <th rowspan="2" style="width:25%; text-align: center"> Dependencia</th> 
                    <th rowspan="2" style="width:8%; text-align: center"> Sueldos Basicos a personal fijo tiempo completo</th>
                    <?php $count = count(array_keys($resumen['0']['Asignaciones'])); ?>                    
                    <th style="text-align:center;" colspan=<?php echo '"' . $count . '"' ?>>Asignaciones</th>
                    <th  rowspan="2"  style="text-align: center; width:5% ">Total de Asignaciones</th>
                    <th  rowspan="2"  style="text-align: center; width:5%">Total  Sueldo + Asignaciones</th>
                    <?php $count = count(array_keys($resumen['0']['Deducciones'])); ?>
                    <th style="text-align: center" colspan=<?php echo '"' . $count . '"' ?>>Deducciones</th>                    
                    <th  rowspan="2"  style="text-align: center; width: 5%">Total de Deducciones</th>
                    <th  rowspan="2" style="text-align: center; width: 5%">Total Sueldo a Cancelar</th>
                </tr>
                <tr>                   

                    <?php
                    $asignaciones = array_keys($resumen['0']['Asignaciones']);
                    foreach ($asignaciones as $asignacion) {
                        echo '<th style="width:3%; text-align: center; word-wrap: break-word">' . $asignacion . "</td>";
                    }
                    ?>                    
                    <?php
                    $deducciones = array_keys($resumen['0']['Deducciones']);
                    foreach ($deducciones as $deduccion) {
                        echo '<th style="width:4%; text-align: center; word-wrap: break-word">' . $deduccion . "</td>";
                    }
                    ?> 
                </tr>
            </thead>
            <tbody>
                <?php
                $num=1;
                foreach ($resumen as $resu):
                    $class = 'modo1';
                    if ($num % 2 == 0) {
                        $class = 'modo2';
                    }                                    
                    echo '<tr class="'.$class.'">';                    
                    echo '<td>' . $resu['Programa']['NOMBRE'] . '</td>';
                    echo '<td style="text-align: center;">' . number_format($resu['Programa']['TOTAL_SUELDO'], 2, ',', '.') . '</td>';
                    foreach ($resu['Asignaciones'] as $value) {
                        echo '<td style="text-align: center;">' . number_format($value, 2, ',', '.') . '</td>';
                    }
                    echo '<td style="text-align: center;">' . number_format($resu['Programa']['TOTAL_ASIGNACIONES'], 2, ',', '.') . '</td>';
                    echo '<td style="text-align: center;">' . number_format($resu['Programa']['TOTAL_SUELDO_ASIGNACIONES'], 2, ',', '.') . '</td>';
                    foreach ($resu['Deducciones'] as $value) {
                        echo '<td style="text-align: center;">' . number_format($value, 2, ',', '.') . '</td>';
                    }
                    echo '<td style="text-align: center;">' . number_format($resu['Programa']['TOTAL_DEDUCCIONES'], 2, ',', '.') . '</td>';
                    echo '<td style="text-align: center;">' . number_format($resu['Programa']['TOTAL_SUELDO_CANCELAR'], 2, ',', '.') . '</td>';
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