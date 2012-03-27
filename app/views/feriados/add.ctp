<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>
<div class="box">
    <div class="title"><h2>Datos del Feriado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Feriado');
        echo "<div class='row'>";
        echo "<div style='float:left;width:20%'>";
        echo $this->Form->label('Dia Feriado');
        echo $this->Form->input('FECHA', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";
        echo "<div class='row'>";
        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Breve Descripcion');
        echo $this->Form->input('DESCRIPCION', array('div' => false, 'label' => false, 'class' => 'medium'));
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
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>              
        </div>
    </div>
</div>