<div class="box2">
    <div class="content2" >        
        <table  class="tabla" style="width: 1800px">
            <thead>                
                <tr>
                    <th style="text-align: center; width:1%"> Programa</th>
                    <th style="text-align: center; width:1%">Actividad / Proyecto</th>                                      
                    <th style="text-align: center; width:1%"> Nº</th>
                    <th style="text-align: center; width:15%"> Apellidos y Nombres</th>
                    <th style="text-align: center; width:5%"> Cedula de Identidad</th>
                    <th style="text-align: center; width:15%"> Cargo</th>
                    <th style="text-align: center; width:2%"> Fecha de Ingreso</th>
                    <th style="text-align: center; width:2%"> Dias Habiles</th>
                    <th style="text-align: center; width:2%"> Dias Habiles Laborados</th>
                    <th style="text-align: center; width:2%"> Dias Adicionales a Cancelar</th>
                    <th style="text-align: center; width:2%"> Total Dias a Cancelar</th>
                    <th style="text-align: center; width:2%"> Dias a Descontar</th>
                    <th style="text-align: center; width:2%"> Dias Efectivamente a Cancelar</th>
                    <th style="text-align: center; width:2%"> Valor del Beneficio de Alimentacion Bs. F /Diario</th>
                    <th style="text-align: center; width:3%"> Total a Cancelar</th>
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
                    echo '<td>' . $empleado['Cestaticket_Empleado']['PROGRAMA'] . '</td>';
                    echo '<td>' . $empleado['Cestaticket_Empleado']['ACTIVIDAD_PROYECTO'] . '</td>';
                    echo '<td>' . $num . '</td>';
                    echo '<td>' . $empleado['Cestaticket_Empleado']['APELLIDO'] . " " . $empleado['Cestaticket_Empleado']['NOMBRE'] . '</td>';
                    echo '<td style="text-align:center;">' . $empleado['Cestaticket_Empleado']['CEDULA']. '</td>';
                    echo '<td>' . $empleado['Cestaticket_Empleado']['CARGO'] . '</td>';
                    echo '<td style="text-align: center;">' . $empleado['Cestaticket_Empleado']['INGRESO'] . '</td>';                    
                    echo '<td style="text-align: center;">' . $empleado['Cestaticket_Empleado']['DIAS_HABILES'] . '</td>';
                    echo '<td style="text-align: center;">' . $empleado['Cestaticket_Empleado']['DIAS_LABORADOS'] . '</td>';
                    echo '<td style="text-align: center;">' . $empleado['Cestaticket_Empleado']['DIAS_ADICIONALES'] . '</td>';                    
                    echo '<td style="text-align: center;">' . $empleado['Cestaticket_Empleado']['TOTAL_DIAS'] . '</td>';
                    echo '<td style="text-align: center;">' . $empleado['Cestaticket_Empleado']['DIAS_DESCONTAR'] . '</td>';                    
                    echo '<td style="text-align: center;">' . $empleado['Cestaticket_Empleado']['TOTAL_DIAS_EFEC'] . '</td>';
                    echo '<td style="text-align: center;">' . number_format($empleado['Cestaticket_Empleado']['VALOR_DIARIO'], 2, ',', '.') . '</td>';
                    echo '<td style="text-align: center;">' . number_format($empleado['Cestaticket_Empleado']['TOTAL'], 2, ',', '.') . '</td>';
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