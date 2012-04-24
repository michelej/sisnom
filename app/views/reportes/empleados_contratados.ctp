<div class="box">
    <div class="title"><h2>Empleados Contratados</h2></div>
    <div class="content pages">                
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:5%; text-align: center"><?php echo $this->Paginator->sort('Cedula', 'CEDULA'); ?></th>                    
                    <th style="width:20%;"><?php echo $this->Paginator->sort('Nombre(s) y Apellido(s)', 'NOMBRE'); ?></th>                    
                    <th style="width:10%;"><?php echo $this->Paginator->sort('Grupo', 'Grupo.NOMBRE'); ?></th>
                    <th style="width:10%;"><?php echo $this->Paginator->sort('Fecha Ingreso', 'INGRESO'); ?></th>
                    <th style="width:5%;"><?php echo $this->Paginator->sort('Sexo', 'SEXO'); ?></th>
                    <th style="width:10%;"><?php echo $this->Paginator->sort('Estado Civil', 'EDOCIVIL'); ?></th>
                    <th style="width:20%;">Cargo</th>
                    <th style="width:20%;">Departamento</th>                    
                    <th></th>  
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($empleados as $empleado):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <?php if($empleado['Empleado']['NACIONALIDAD']=='Venezolano'){
                            echo '<td style="text-align: right">'.'V-'.$empleado['Empleado']['CEDULA'].'</td>';
                        }else{
                            echo '<td style="text-align: right">'.'E-'.$empleado['Empleado']['CEDULA'].'</td>';
                        }?>
                        
                        <td><?php echo $empleado['Empleado']['NOMBRE'].' '.$empleado['Empleado']['APELLIDO']; ?></td>
                        <td><?php echo $empleado['Empleado']['Grupo']['NOMBRE']; ?></td>
                        <td><?php echo $empleado['Empleado']['INGRESO']; ?></td>
                        <td><?php echo $empleado['Empleado']['SEXO']; ?></td>
                        <td><?php echo $empleado['Empleado']['EDOCIVIL']; ?></td>
                        <td><?php echo $empleado['Cargo']['NOMBRE']; ?></td>                        
                        <td><?php echo $empleado['Departamento']['NOMBRE']; ?></td>    
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>            
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Mostrando %current% Empleado(s), de un total de  %count% Empleados'));
                ?>
            </div>
            <div class="pagination">
                <?php echo $this->Paginator->prev(null, array(), null, array('class' => 'disabled')); ?>
                <?php echo $this->Paginator->numbers(array('class' => 'disabled', 'separator' => '')); ?>
                <?php echo $this->Paginator->next(null, array(), null, array('class' => 'disabled')); ?>
            </div>
        </div>

    </div>
</div>