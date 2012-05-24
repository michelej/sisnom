<?php debug($resumen);?>
<div class="box2">
    <div class="content2" >        
        <table class="tabla" style="table-layout: fixed; width:1800px;">
            <thead>
                <tr>
                    <th rowspan="2" style="width:15%; text-align: center"> Dependencia</th> 
                    <th rowspan="2" style="width:8%; text-align: center"> Sueldos Basicos a personal fijo tiempo completo</th>
                    <?php $count=count(array_keys($empleados['0']['Nomina_Empleado']['Asignaciones'])); ?>                    
                    <th style="text-align:center;" colspan=<?php echo '"'.$count.'"'?>>Asignaciones</th>
                    <th  rowspan="2"  style="text-align: center; width:5% ">Total de Asignaciones</th>
                    <th  rowspan="2"  style="text-align: center; width:5%">Total  Sueldo + Asignaciones</th>
                    <?php $count=count(array_keys($empleados['0']['Nomina_Empleado']['Deducciones'])); ?>
                    <th style="text-align: center" colspan=<?php echo '"'.$count.'"'?>>Deducciones</th>                    
                    <th  rowspan="2"  style="text-align: center; width: 5%">Total de Deducciones</th>
                    <th  rowspan="2" style="text-align: center; width: 5%">Total Sueldo a Cancelar</th>
                </tr>
                <tr>                   
                    
                    <?php                    
                        $asignaciones=array_keys($empleados['0']['Nomina_Empleado']['Asignaciones']);                        
                        foreach ($asignaciones as $asignacion) {
                            echo '<th style="width:3%; text-align: center; word-wrap: break-word">'.$asignacion."</td>";
                        }
                    ?>                    
                    <?php                    
                        $deducciones=array_keys($empleados['0']['Nomina_Empleado']['Deducciones']);                        
                        foreach ($deducciones as $deduccion) {
                            echo '<th style="width:4%; text-align: center; word-wrap: break-word">'.$deduccion."</td>";
                        }
                    ?> 
                </tr>
            </thead>
            <tbody>	

            </tbody>
            <tfoot>
            </tfoot>
        </table>        
    </div>
</div>