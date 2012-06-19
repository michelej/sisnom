<div class="box">
    <div class="title"><h2>Conceptos</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'ajustes', 'action' => 'edit_ajustes', $ajuste['Ajuste']['id']))); ?> 
        <?php echo $this->Form->input("empleado_id", array('type' => 'hidden', 'value' => $ajuste['Ajuste']['empleado_id'])); ?>
    </div>
    <div class="content pages">

        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;width: 50%">Asignaciones</th>
                    <th colspan="4" style="text-align: center;width: 50%">Deducciones</th>
                </tr>                
            </thead>
            <tbody>                
                <?php
                $ta = count($ajuste['Asignacion']);
                $td = count($ajuste['Deduccion']);
                if (count($asignaciones) > count($deducciones)) {
                    $total = count($asignaciones);
                } else {
                    $total = count($deducciones);
                }

                $i = 0;
                for ($ct = 0; $ct < $total; $ct++):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    if ($ct < $td) {
                        $id_deduccion = $ajuste['Deduccion'][$ct]['id'];
                        $checked_deduccion = false;
                        foreach ($ajuste['Deduccion'] as $value_deduccion) {
                            if ($value_deduccion['id'] == $id_deduccion) {
                                $checked_deduccion = true;
                            }
                        }
                    } else {
                        $checked_deduccion = false;
                    }

                    if ($ct < $ta) {
                        $id_asignacion = $ajuste['Asignacion'][$ct]['id'];
                        $checked_asignacion = false;
                        foreach ($ajuste['Asignacion'] as $value_asignacion) {
                            if ($value_asignacion['id'] == $id_asignacion) {
                                $checked_asignacion = true;
                            }
                        }
                    }else{
                        $checked_asignacion = false;
                    }
                    
                    ?>
                    <tr<?php echo $class; ?>>
                        <?php
                        if ($ct < count($asignaciones)) {
                            echo "<td>" . $asignaciones[$ct]['Asignacion']['DESCRIPCION'] . "</td>";
                            echo "<td>" . $this->Form->input('Asignacion.' . $id_asignacion, array('type' => 'checkbox', 'label' => false, 'checked' => $checked_asignacion)) . "</td>";
                        } else {
                            echo "<td>  </td>";
                            echo "<td>  </td>";
                        }

                        if ($ct < count($deducciones)) {
                            echo "<td>" . $deducciones[$ct]['Deduccion']['CODIGO'] . "</td>";
                            echo "<td>" . $deducciones[$ct]['Deduccion']['DESCRIPCION'] . "</td>";
                            echo "<td>" . $deducciones[$ct]['Deduccion']['PORCENTAJE'] . "</td>";
                            echo "<td>" . $this->Form->input('Deduccion.' . $id_deduccion, array('type' => 'checkbox', 'label' => false, 'checked' => $checked_deduccion)) . "</td>";
                        } else {
                            echo "<td>  </td>";
                            echo "<td>  </td>";
                            echo "<td>  </td>";
                        }
                        ?>                                                
                    <?php endfor; ?> 
                </tr>                
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