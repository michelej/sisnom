<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">    
    <div class="title"><h2>Nuevo Sueldo</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">                
        <?php
        echo $this->Form->create('Historial',array('url' => array('controller' => 'historiales', 'action' => 'add_group',implode(',',$grupo))));        

        echo "<div class='row'>";        
        echo "<div style='float:left;width:20%'>";
        echo $this->Form->input('FECHA_RET', array('type' => 'text', 'div' => false, 'label' => 'Fecha Retroactiva', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";
        
        echo "<div class='row'>";        
        echo "<div style='float:left;width:20%'>";
        echo $this->Form->input('FECHA_INI', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Inicio', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";        

        echo "<div style='float:left;width:20%'>";        
        echo $this->Form->input('FECHA_FIN', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Finalizacion', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";        
        echo "<div style='float:left;width:20%'>";        
        echo $this->Form->input('SUELDO_BASE', array('div' => false, 'label' => 'Sueldo Base', 'class' => 'small'));
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
            <?php echo $this->Form->end('Agregar'); ?>
        </div>
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('controller'=>'cargos','action' => 'grupo')); ?>
            </div>
        </div>
    </div>
</div>