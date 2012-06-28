<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title"><h2>Datos del Familiar</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <?php echo $this->Form->create('Familiar', array('url' => array('controller' => 'familiares', 'action' => 'add', 'empleadoId:' . $empleadoId))); ?>        
        <?php
        // INI ROW
        echo "<div class='row'>";
        echo "<div style='float:left;width:70%'>";
        echo $this->Form->input('NOMBRE', array('div' => false, 'label' => 'Nombre Completo', 'class' => 'medium'));
        echo "</div>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->input('FECHA', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Nacimiento', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:35%'>";
        $options = array('Hijo(a)' => 'Hijo(a)', 'Padre' => 'Padre', 'Madre' => 'Madre', 'Hermano(a)' => 'Hermano(a)');
        echo $this->Form->input('PARENTESCO', array('div' => false, 'label' => 'Parentesco', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
        echo "</div>";                
        
        echo "<div style='float:left;width:35%'>";
        $options = array('Si' => 'Si', 'No' => 'No');
        echo $this->Form->input('DISCAPACIDAD', array('div' => false, 'label' => 'Discapacidad', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
        echo "</div>";

        echo "<div style='float:left;width:30%'>";
        $options = array('Ninguna' => 'Ninguna', 'T.S.U' => 'T.S.U', 'Pregrado' => 'Pregrado');
        echo $this->Form->input('INSTRUCCION', array('div' => false, 'label' => 'Instruccion', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";
        echo $this->Form->input('FECHA_EFEC', array('type' => 'text', 'div' => false, 'label' => 'Fecha Efectiva', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";
        echo $this->Form->input('empleado_id', array('type' => 'hidden', 'value' => $empleadoId));
        // END ROW                                       
        ?>            	                      
    </div>
</div>

<div class="box">
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row">
            <div class="boton">
                <?php echo $this->Form->end('Agregar'); ?>            
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'edit', $empleadoId)); ?>
            </div>
        </div>        
    </div>
</div>