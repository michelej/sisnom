<div class="box2">
    <div class="content2" >
        <table  class="tabla">
            <thead>
                <tr>
                    <th ></th>
                    <th style="width:8%; overflow:scroll"></th>
                    <th style="width:2%"></th>
                    <th ></th>
                    <th ></th>
                    <th ></th>
                    <th ></th>
                    <th colspan="2">Periodo Laborado</th>
                    <th  rowspan="2">DiasLaborados</th>
                    <th  rowspan="2">Sub Total Sueldo Basico</th>
                    <th colspan="6">Asignaciones</th>
                    <th  rowspan="2">Total de Asignaciones</th>
                    <th  rowspan="2">Total  Suseldo +Asignaciones</th>
                    <th colspan="9">Deducciones</th>
                    <th  rowspan="2">Total de Deducciones</th>
                    <th  rowspan="2">TOTAL A CANCELAR</th>
                </tr>
                <tr>
                    <th style="width:1%">N#</th>
                    <th style="width:25%">Apellidos y Nombre</th>
                    <th style="width:5%">Cedula de Identidad / Rif</th>
                    <th style="width:25%">Cargo</th>
                    <th style="width:5%">Salario Basico Mensual</th>
                    <th style="width:5%">Fecha de Ingreso</th>
                    <th style="width:5%">Salario Diario</th>
                    <th style="width:5%">Desde</th>
                    <th style="width:5%">Hasta</th>
                    <th style="width:5%">Prima Por Reconocimiento</th>
                    <th style="width:5%">Prima Por Hogar</th>
                    <th style="width:5%">Prima Por Antiguedad</th>
                    <th style="width:5%">Prima por Transporte</th>
                    <th style="width:5%">Prima Por Hijos</th>
                    <th style="width:5%">Nivelacion Profesional</th>
                    <th style="width:5%">SSO(4%)</th>
                    <th style="width:5%">Regimen Prestacional del Empleado</th>
                    <th style="width:5%">Fondo de Ahorro Obligatorio de Vivienda(FAOV)(1%)</th>
                    <th style="width:5%">Fondo de Pensiones(3%)</th>
                    <th style="width:5%" >Caja de Ahorro (10% del Sueldo)</th>
                    <th style="width:5%">Prestamos de Caja de Ahorro</th>
                    <th style="width:5%">Deducciones por creditos Comerciales</th>
                    <th style="width:5%" >Deducciones por Tribunales</th>
                    <th style="width:5%">Retenciones de Impuestos sobre la Renta</th>
                </tr>
            </thead>
            <tbody>	
                <?php
                //debug($personas);
                $i = 1;
                foreach ($empleados as $empleado):
                    echo '<tr class="modo1">';
                    echo '<td>' . $i++ . '</td>';
                    echo '<td>' . $empleado['Empleado']['APELLIDO'] ." ".$empleado['Empleado']['NOMBRE'] .'</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '<td>' . 'asdf' . '</td>';
                    echo '</tr>';
                endforeach;
                ?>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</div>