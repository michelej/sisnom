<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title"><h2>Nuevo Ajuste</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Ajuste',array('url' => array('controller' => 'ajustes', 'action' => 'add',$id)));
        echo $this->Form->input('empleado_id', array('value' => $id, 'type' => 'hidden'));

        echo "<div class='row'>";
        echo "<div style='float:left;width:20%'>";
        echo $this->Form->input('FECHA_INI', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Inicio', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "<div style='float:left;width:20%'>";
        echo $this->Form->input('FECHA_FIN', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Finalizacion', 'class' => 'datepicker dp-applied')) . "</br>";
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
                <?php echo $this->Html->link('Regresar', array('action' => 'edit',$id)); ?>
            </div>
        </div>
    </div>
</div>