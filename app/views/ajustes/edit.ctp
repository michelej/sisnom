<div class="box">
    <div class="title"><h2>Datos del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:10%'>"; ?>
            <?php echo $this->Form->label('Cedula'); ?>
            <?php echo number_format($empleado['Empleado']['CEDULA'], 0, ',', '.'); ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:30%'>"; ?>
            <?php echo $this->Form->label('Nombre Completo'); ?>
            <?php echo $empleado['Empleado']['NOMBRE'] . " " . $empleado['Empleado']['APELLIDO']; ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:15%'>"; ?>
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
    <div class="title"><h2>Historial de Ajustes del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:20%"><?php echo $this->Paginator->sort('Fecha Inicio', 'FECHA_INI') ?></th>                    
                    <th style="width:20%"><?php echo $this->Paginator->sort('Fecha Final', 'FECHA_FIN') ?></th>                    
                    <th style="width:45%"></th>  
                    <th style="width:15%; text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($ajustes as $ajuste):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo fechaElegible($ajuste['Ajuste']['FECHA_INI']); ?></td>                        
                        <td><?php
                if ($ajuste['Ajuste']['FECHA_FIN'] == NULL) {
                    echo "Actual";
                } else {
                    echo fechaElegible($ajuste['Ajuste']['FECHA_FIN']);
                }
                    ?></td>                                                                        
                        <td></td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar Ajustes', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit_ajustes', $ajuste['Ajuste']['id'])));
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $ajuste['Ajuste']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Este empleado tiene %count% ajustes(s)'));
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
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Nuevo Ajuste', array('action' => 'add','empleadoId:'.$empleado['Empleado']['id'])); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('controller' => 'ajustes', 'action' => 'index')); ?>
            </div>
        </div>
    </div>
</div>