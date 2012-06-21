<div class="box">
    <div class="title"><h2>Listado de Empleados</h2></div>
    <div class="content pages">                
        <div class="pagination">
            <?php echo $this->Paginator->prev(null, array(), null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(array('class' => 'disabled', 'separator' => '')); ?>
            <?php echo $this->Paginator->next(null, array(), null, array('class' => 'disabled')); ?>
        </div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:5%; text-align: center"><?php echo $this->Paginator->sort('Cedula', 'CEDULA'); ?></th>                    
                    <th style="width:28%;"><?php echo $this->Paginator->sort('Nombre(s) y Apellido(s)', 'NOMBRE'); ?></th>                                      
                    <th style="width:32%; text-align: left">Cargo</th>
                    <th style="width:35%; text-align: left">Departamento</th>
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
                    if (!empty($empleado['Contrato']['0'])) {
                        if ($empleado['Contrato']['0']['MODALIDAD'] == 'Contratado') {
                            $cargo = "CONTRATADO";
                            $departamento = $empleado['Contrato']['0']['Departamento']['NOMBRE'];
                        } else {
                            $cargo = $empleado['Contrato']['0']['Cargo']['NOMBRE'];
                            $departamento = $empleado['Contrato']['0']['Departamento']['NOMBRE'];
                        }
                    } else {
                        $cargo = " Esta persona se encuentra Inactiva";
                        $departamento = "Esta persona se encuentra Inactiva";
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <?php
                        if ($empleado['Empleado']['NACIONALIDAD'] == 'Venezolano') {
                            echo '<td style="text-align: right">' . 'V' . $empleado['Empleado']['CEDULA'] . '</td>';
                        } else {
                            echo '<td style="text-align: right">' . 'E' . $empleado['Empleado']['CEDULA'] . '</td>';
                        }
                        ?>                        
                        <td><?php echo normalizarPalabra($empleado['Empleado']['APELLIDO'] . " " . $empleado['Empleado']['NOMBRE']); ?></td>
                        <td style="text-align: left"><?php echo normalizarPalabra($cargo); ?></td>                                                                        
                        <td style="text-align: left"><?php echo normalizarPalabra($departamento); ?></td>                                                                        
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

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">
        <div class="row">
            <div class="boton">
<?php echo $this->Html->link('Regresar', array('action' => 'listados')); ?>
            </div>
        </div>
    </div>
</div>