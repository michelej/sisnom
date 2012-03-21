<div class="box">
    <div class="title"><h2>Empleado</h2>
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
                    <th style="width:15%"><?php echo $this->Paginator->sort('Modalidad', 'MODELIDAD') ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Grupo', 'GRUPO') ?></th>
                    <th style="width:20%"><?php echo $this->Paginator->sort('Cargo', 'cargo_id') ?></th>
                    <th style="width:20%"><?php echo $this->Paginator->sort('Departamento', 'departamento_id') ?></th>
                    <th style="width:15%; text-align: center" class="actions"><?php __('Acciones'); ?></th>
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
                        <td><?php echo $contrato['Contrato']['GRUPO']; ?></td>
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
                echo $this->Paginator->counter(array('format' => __('Este empleado tiene %count% contrato(s)', true)));
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
    <div class="title"><h2>Nuevo Contrato</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Contrato');
        echo $this->Form->input('empleado_id', array('value' => $empleado['Empleado']['id'], 'type' => 'hidden'));
        
        echo "<div class='row'>";
        echo "<div style='float:left;width:20%'>";        
        echo $this->Form->input('FECHA_INI', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Inicio', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "<div style='float:left;width:20%'>";        
        echo $this->Form->input('FECHA_FIN', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Finalizacion', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";                
        
        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";        
        $options = array('Fijo' => 'Fijo', 'Contratado' => 'Contratado');
        echo $this->Form->input('MODALIDAD', array('div' => false, 'label' => 'Modalidad del Contrato', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione una opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:60%'>";        
        $options = array('Administrativo' => 'Administrativo', 'Obrero' => 'Obrero');
        echo $this->Form->input('GRUPO', array('div' => false, 'label' => 'Grupo', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione una opcion'));
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";
        echo $this->Form->label('Departamento');
        echo $this->Form->input('departamento_id', array('div' => false, 'label' => false, 'class' => 'small', 'empty' => "Seleccione una opción"));
        echo "</div>";

        echo "<div style='float:left;width:60%'>";
        echo $this->Form->label('Cargo');
        echo $this->Form->input('cargo_id', array('div' => false, 'label' => false, 'class' => 'small', 'empty' => "Seleccione una opción"));
        echo "</div>";
        echo "</div>";
        ?>
    </div>    
</div>

<div class="box">
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row">
            <?php echo $this->Form->end(__('Nuevo', true)); ?>

        </div>
    </div>
</div>