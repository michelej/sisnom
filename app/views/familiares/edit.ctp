<div class="box">
    <div class="title"><h2>Datos del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:10%'>"; ?>
            <?php echo $this->Form->label('Cedula / Rif'); ?>
            <?php echo $empleado['Empleado']['CEDULA'] ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:30%'>"; ?>
            <?php echo $this->Form->label('Nombre Completo'); ?>
            <?php echo mb_convert_case(strtolower($empleado['Empleado']['APELLIDO']), MB_CASE_TITLE, "UTF-8") . ' ' . mb_convert_case(strtolower($empleado['Empleado']['NOMBRE']), MB_CASE_TITLE, "UTF-8"); ?>
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
    <div class="title"><h2>Familiares del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:25%"><?php echo $this->Paginator->sort('Nombre Completo', 'Familiar.NOMBRE') ?></th>
                    <th style="width:10%"><?php echo $this->Paginator->sort('Parentesco', 'PARENTESCO') ?></th>
                    <th style="width:10%"><?php echo $this->Paginator->sort('Fecha de Nacimiento', 'FECHA') ?></th>
                    <th style="width:10%"><?php echo $this->Paginator->sort('Fecha Efectiva', 'FECHA') ?></th>
                    <th style="width:10%"><?php echo $this->Paginator->sort('Discapacidad', 'DISCAPACIDAD') ?></th>                                        
                    <th style="width:20%"><?php echo $this->Paginator->sort('Instruccion', 'INSTRUCCION') ?></th>                                        
                    <th style="width:15%; text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($familiares as $familiar):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $familiar['Familiar']['NOMBRE']; ?></td>                        
                        <td><?php echo $familiar['Familiar']['PARENTESCO']; ?></td>
                        <td><?php echo fechaElegible($familiar['Familiar']['FECHA']); ?></td>
                        <td><?php echo fechaElegible($familiar['Familiar']['FECHA_EFEC']); ?></td>
                        <td><?php echo $familiar['Familiar']['DISCAPACIDAD']; ?></td>
                        <td><?php echo $familiar['Familiar']['INSTRUCCION']; ?></td>                        
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit_familiar', $familiar['Familiar']['id'])));
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $familiar['Familiar']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Este empleado tiene %count% familiar(es)'));
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
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Nuevo Familiar', array('action' => 'add','empleadoId:'.$empleado['Empleado']['id'])); ?>
            </div>
              <div class="boton">
                <?php echo $this->Html->link('Regresar', array('controller'=>'empleados','action' => 'index')); ?>
            </div>
        </div>        
    </div>
</div>