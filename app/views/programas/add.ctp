<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>
<div class="box">
    <div class="title"><h2>Datos del Programa</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Programa');
        echo "<div class='row'>";
        echo "<div style='float:left;width:30%'>";        
        echo $this->Form->input('CODIGO', array('div' => false, 'label' => 'Programa', 'class' => 'small'));
        echo "</div>";
        
        echo "<div style='float:left;width:25%'>";        
        echo $this->Form->input('NOMBRE', array('div' => false, 'label' => 'Nombre', 'class' => 'medium'));
        echo "</div>";
        echo "</div>";
        
        echo "<div class='row'>";
        echo "<div style='float:left;width:30%'>";        
        $options = array('Actividad' => 'Actividad', 'Proyecto' => 'Proyecto');
        echo $this->Form->input('TIPO', array('div' => false, 'label' => 'Tipo', 'class' => 'small' ,'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:25%'>";                
        echo $this->Form->input('NUMERO', array('div' => false, 'label' => 'Numero', 'class' => 'small'));
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