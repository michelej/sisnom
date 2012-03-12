<div class="box">
    <div class="title"><h2>Modificar Cargo</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Historial');
        echo "<div class='row'>";
        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Sueldo Base');
        echo $this->Form->input('0.SUELDO_BASE', array('div' => false, 'label' => false, 'class' => 'medium'));
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
            <?php echo $this->Form->end(__('Modificar', true)); ?>

        </div>
    </div>
</div>
<?php echo $this->element('sql_dump'); ?>
