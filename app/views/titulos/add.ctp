<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>
<div class="box">
    <div class="title"><h2>Datos del Titulo</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <?php echo $this->Form->create('Titulo', array('url' => array('controller' => 'titulos', 'action' => 'add', 'empleadoId:' . $empleadoId))); ?>        
        <?php
        echo $this->Form->input('empleado_id', array('type' => 'hidden', 'value' => $empleadoId));
        // INI ROW
        echo "<div class='row'>";
        echo "<div style='float:left;width:35%'>";
        $options = array('T.S.U' => 'T.S.U', 'Profesional Universitario' => 'Profesional Universitario', 'Post-Grado' => 'Post-Grado', 'Maestria' => 'Maestria', 'Doctorado' => 'Doctorado');
        echo $this->Form->input('TITULO', array('div' => false, 'label' => 'Titulo', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Selecione una Opcion'));
        echo "</div>";

        echo "<div style='float:left;width:40%'>";
        echo $this->Form->input('FECHA', array('type' => 'text', 'div' => false, 'label' => 'Fecha Efectiva', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:50%'>";
        echo $this->Form->input('INSTITUCION', array('div' => false, 'label' => 'Institucion', 'class' => 'medium'));
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->input('ESPECIALIDAD', array('div' => false, 'label' => 'Especialidad', 'class' => 'medium'));
        echo "</div>";
        echo "</div>";
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