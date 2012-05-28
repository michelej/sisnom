<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>
<div class="box">
    <div class="title"><h2>Datos del Departamento</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Departamento',array('url' => array('controller' => 'departamentos', 'action' => 'asignar',$id)));
        echo "<div class='row'>";        
        echo $this->Form->input('programa_id', array('div' => false, 'label' => 'Programa', 'class' => 'medium' ,'type' => 'select', 'options' => $programas, 'empty' => 'No pertenece a ningun programa'));
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
            <?php echo $this->Form->end('Guardar'); ?>
        </div>
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>              
        </div>  
    </div>
</div>