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
    <div class="title"><h2>Historial de Deducciones por Tribunal</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:15%"><?php echo $this->Paginator->sort('Mes', 'FECHA') ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Año', 'FECHA') ?></th>
                    <th style="width:20%"><?php echo $this->Paginator->sort('Cantidad', 'CANTIDAD') ?></th>
                    <th style="width:50%"></th>
                    <th style="width:15%; text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($tribunales as $tribunal):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $tribunal['Tribunal']['MES']; ?></td>
                        <td><?php echo $tribunal['Tribunal']['AÑO']; ?></td>
                        <td><?php echo $tribunal['Tribunal']['CANTIDAD']; ?></td>
                        <td></td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $tribunal['Tribunal']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Este empleado tiene %count% deducciones por Tribunal(es)'));
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
                <?php echo $this->Html->link('Ingresar Deduccion por Tribunal', array('action' => 'add','empleadoId:'.$empleado['Empleado']['id'])); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('controller'=>'empleados','action' => 'listado')); ?>
            </div>
        </div>
    </div>
</div>