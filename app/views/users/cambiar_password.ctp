<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title"><h2>Cambio de Contraseña</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'cambiar_password')));
        echo "<div class='row'>";
        echo "<div style='margin-right: auto;margin-left: auto;width:25%'>";        
        echo $this->Form->input('OLD_PASSWORD', array('type'=>'password','div' => false, 'label' => 'Contraseña Actual', 'class' => 'small'));
        echo "</div>";
        echo "</div>";
        echo "<div class='row'>";
        echo "<div style='margin-right: auto;margin-left: auto;width:25%'>";        
        echo $this->Form->input('PASSWORD', array('type'=>'password','div' => false, 'label' => 'Contraseña Nueva', 'class' => 'small'));
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
                <?php echo $this->Form->end('Cambiar'); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>              
        </div>        
    </div>
</div>
