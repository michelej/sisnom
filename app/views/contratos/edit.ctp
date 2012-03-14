<div class="box">
    <div class="title"><h2>Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:50%'>"; ?>
            <?php echo $this->Form->label('Nombre'); ?>
            <?php echo $empleado['Empleado']['NOMBRE']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:50%'>"; ?>
            <?php echo $this->Form->label('Descripcion'); ?>
            <?php echo $empleado['Empleado']['APELLIDO']; ?>
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
                    <th style="width:20%"><?php echo $this->Paginator->sort('Cargo', 'FECHA_INI') ?></th>
                    <th style="width:20%"><?php echo $this->Paginator->sort('Departamento', 'FECHA_INI') ?></th>
                    <th style="width:15%; text-align: center" class="actions"><?php __('Actions'); ?></th>
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
                        <td><?php echo $contrato['Cargo']['NOMBRE'];   ?></td>
                        <td><?php echo $contrato['Departamento']['NOMBRE'];  ?></td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $contrato['Contrato']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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
        echo $this->Form->label('Fecha Inicio');
        echo $this->Form->input('FECHA_INI', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "<div style='float:left;width:20%'>";
        echo $this->Form->label('Fecha Fin');
        echo $this->Form->input('FECHA_FIN', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "<div style='float:left;width:60%'>";
        echo $this->Form->label('Modalidad');
        $options = array('0' => 'Seleccione una opcion', 'Fijo' => 'Fijo', 'Contratado' => 'Contratado');
        echo $this->Form->input('MODALIDAD', array('div' => false, 'label' => false, 'class' => 'small', 'type' => 'select', 'options' => $options));
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