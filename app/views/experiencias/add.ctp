<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title"><h2>Nueva Experiencia</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Experiencia', array('url' => array('controller' => 'experiencias', 'action' => 'add', 'empleadoId:' . $empleadoId)));
        echo $this->Form->input('empleado_id', array('value' => $empleadoId, 'type' => 'hidden'));

        echo "<div class='row'>";
        echo "<div style='float:left;width:35%'>";
        echo $this->Form->input('FECHA_INI', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Inicio', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "<div style='float:left;width:20%'>";
        echo $this->Form->input('FECHA_FIN', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Culminacion', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";
        echo $this->Form->input('ORGANISMO', array('div' => false, 'label' => 'Organismo', 'class' => 'medium'));
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";
        echo $this->Form->input('CARGO', array('div' => false, 'label' => 'Cargo', 'class' => 'medium'));
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";
        echo $this->Form->input('OBSERVACIONES', array('div' => false, 'label' => 'Observaciones', 'class' => 'large'));
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
            <div class="boton">
                <?php echo $this->Form->end('Agregar'); ?>                        
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'edit', $empleadoId)); ?>
            </div>
        </div>                
    </div>
</div>