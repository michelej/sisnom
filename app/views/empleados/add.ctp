<div class="box">
    <div class="title"><h2><?php __('Datos Personales'); ?></h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
        <?php echo $this->element('plantilla_empleado'); ?>
</div>


<div class="box">
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row">
            <?php echo $this->Form->end(__('Agregar', true)); ?>            
        </div>
    </div>
</div>