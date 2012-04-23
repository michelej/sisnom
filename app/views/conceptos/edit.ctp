<div class="box">
    <div class="title"><h2>Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>        
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo $this->Form->create(false, array('url' => array('controller' => 'conceptos', 'action' => 'edit', $empleado['Empleado']['id']))); ?> 
            <?php echo "<div style='float:left;width:10%'>"; ?>
            <?php echo $this->Form->label('Cedula'); ?>
            <?php echo $empleado['Empleado']['CEDULA']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:30%'>"; ?>
            <?php echo $this->Form->label('Nombre Completo'); ?>
            <?php echo $empleado['Empleado']['NOMBRE'] . " " . $empleado['Empleado']['APELLIDO']; ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:20%'>"; ?>
            <?php echo $this->Form->label('Fecha de Ingreso'); ?>
            <?php echo fechaElegible($empleado['Empleado']['INGRESO']); ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:30%'>"; ?>
            <?php echo $this->Form->label('Grupo'); ?>
            <?php echo $empleado['Grupo']['NOMBRE']; ?>
            <?php echo "</div>"; ?>            
        </div>
    </div>   

</div>
<div class="box">
    <div class="title"><h2>Conceptos</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <caption>DEDUCCIONES</caption>
            <thead>                
                <tr>
                    <th></th>  
                    <th style="width:20%">Codigo</th>
                    <th style="width:60%">Descripcion</th>                    
                    <th style="width:10%">Porcentaje</th>
                    <th style="width:10%; text-align: center">Usada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($deducciones as $deduccion):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    $id = $deduccion['Deduccion']['id'];
                    $checked = false;
                    foreach ($empleado['Deduccion'] as $value) {
                        if ($value['id'] == $id) {
                            $checked = true;
                        }
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $deduccion['Deduccion']['CODIGO']; ?></td>                        
                        <td><?php echo $deduccion['Deduccion']['DESCRIPCION']; ?></td>                        
                        <td><?php echo $deduccion['Deduccion']['PORCENTAJE']; ?></td>                        
                        <td><?php echo $this->Form->input('Deduccion.' . $id, array('type' => 'checkbox', 'label' => false, 'checked' => $checked)); ?></td>                                              
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
        <br />
        <table cellpadding="0" cellspacing="0">
            <caption>ASIGNACIONES</caption>
            <thead>
                <tr>
                    <th></th>                      
                    <th style="width:90%">Descripcion</th>                    
                    <th style="width:10%; text-align: center">Usada</th>                    
                </tr>
            </thead>
            <tbody>                
                <?php
                $i = 0;
                foreach ($asignaciones as $asignacion):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    $id = $asignacion['Asignacion']['id'];
                    $checked = false;
                    foreach ($empleado['Asignacion'] as $value) {
                        if ($value['id'] == $id) {
                            $checked = true;
                        }
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>                        
                        <td><?php echo $asignacion['Asignacion']['DESCRIPCION']; ?></td>                                                
                        <td><?php echo $this->Form->input('Asignacion.' . $id, array('type' => 'checkbox', 'label' => false, 'checked' => $checked)); ?></td>                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<div class="box">
<?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title"><h2>Acciones</h2>
<?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
<?php echo $this->Form->end("Guardar Cambios"); ?>                
            </div>            
        </div>
        <div class="row boton">
            <div class="boton">
<?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>
        </div>
    </div>
</div>