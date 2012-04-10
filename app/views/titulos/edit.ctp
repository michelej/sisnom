<div class="box">
    <div class="title"><h2>Datos del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:10%'>"; ?>
            <?php echo $this->Form->label('Cedula'); ?>
            <?php echo $empleado['Empleado']['CEDULA']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:30%'>"; ?>
            <?php echo $this->Form->label('Nombre Completo'); ?>
            <?php echo $empleado['Empleado']['APELLIDO']." ".$empleado['Empleado']['NOMBRE']; ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:35%'>"; ?>
            <?php echo $this->Form->label('Fecha de Ingreso'); ?>
            <?php echo fechaElegible($empleado['Empleado']['INGRESO']); ?>
            <?php echo "</div>"; ?>            
        </div>
    </div>   

</div>

<div class="box">
    <div class="title"><h2>Titulos del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:20%"><?php echo $this->Paginator->sort('Titulo', 'TITULO') ?></th>
                    <th style="width:30%"><?php echo $this->Paginator->sort('Especialidad', 'ESPECIALIDAD') ?></th>
                    <th style="width:30%"><?php echo $this->Paginator->sort('Institucion', 'INSTITUCION') ?></th>                                        
                    <th style="width:10%"><?php echo $this->Paginator->sort('Fecha', 'FECHA') ?></th>                                                            
                    <th style="width:10%; text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($titulos as $titulo):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $titulo['Titulo']['TITULO']; ?></td>                        
                        <td><?php echo $titulo['Titulo']['ESPECIALIDAD']; ?></td>                        
                        <td><?php echo $titulo['Titulo']['INSTITUCION']; ?></td>
                        <td><?php echo fechaElegible($titulo['Titulo']['FECHA']); ?></td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit_titulo', $titulo['Titulo']['id'])));
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $titulo['Titulo']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Este empleado tiene %count% Titulo(s)'));
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
                <?php echo $this->Html->link('Nuevo Titulo', array('action' => 'add',$empleado['Empleado']['id'])); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('controller'=>'empleados','action' => 'index')); ?>
            </div>
        </div>
    </div>
</div>