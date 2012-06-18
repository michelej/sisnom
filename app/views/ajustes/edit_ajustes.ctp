<div class="box">
    <div class="title"><h2>Conceptos</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'ajustes', 'action' => 'edit_ajustes', $ajuste['Ajuste']['id']))); ?> 
        <?php echo $this->Form->input("empleado_id", array('type' => 'hidden', 'value' => $ajuste['Ajuste']['empleado_id'])); ?>
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
                    foreach ($ajuste['Deduccion'] as $value) {
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
                    foreach ($ajuste['Asignacion'] as $value) {
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
        <div class="row">
            <div class="boton">
                <?php echo $this->Form->end("Guardar Cambios"); ?>                
            </div>            
            <div class="boton">
                <?php echo $this->Html->link('Salir sin Guardar', array('action' => 'edit', $ajuste['Ajuste']['empleado_id'])); ?>
            </div>
        </div>
    </div>
</div>