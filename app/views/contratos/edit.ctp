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
    <div class="title"><h2>Historial del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:15%"><?php echo $this->Paginator->sort('Fecha Inicio', 'FECHA_INI') ?></th>                    
                    <th style="width:15%"><?php echo $this->Paginator->sort('Fecha Final', 'FECHA_FIN') ?></th>                                        
                    <th style="width:20%"><?php echo $this->Paginator->sort('Modalidad', 'MODELIDAD') ?></th>                    
                    <th style="width:25%"><?php echo $this->Paginator->sort('Cargo', 'cargo_id') ?></th>
                    <th style="width:25%"><?php echo $this->Paginator->sort('Departamento', 'departamento_id') ?></th>
                    <th style="width:15%; text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($contratos as $contrato):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo fechaElegible($contrato['Contrato']['FECHA_INI']); ?></td>                        
                        <td><?php
                if ($contrato['Contrato']['FECHA_FIN'] == NULL) {
                    echo "Actual";
                } else {
                    echo fechaElegible($contrato['Contrato']['FECHA_FIN']);
                }
                    ?></td>                                                
                        <td><?php echo $contrato['Contrato']['MODALIDAD']; ?></td>                        
                        <td><?php echo $contrato['Cargo']['NOMBRE']; ?></td>
                        <td><?php echo $contrato['Departamento']['NOMBRE']; ?></td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $contrato['Contrato']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Este empleado tiene %count% contrato(s)'));
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
                <?php echo $this->Html->link('Nuevo Contrato', array('action' => 'add',$empleado['Empleado']['id'])); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('controller'=>'empleados','action' => 'index')); ?>
            </div>
        </div>
    </div>
</div>