<?php if (!empty($this->validationErrors)) { ?>
    <div class="box">  
        <div class="flash_error">        
            <?php echo $this->Html->image('test-fail-icon.png', array('alt' => 'flash_error')) ?>   
            <?php echo "Existen errores en la forma corrigalos antes de continuar" ?>
        </div>
    </div>
<?php } ?>
<div class="box">
    <div class="title"><h2><?php __('Datos de la Ausencia'); ?></h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <?php echo $this->Form->create('Ausencia',array('url' => array('controller' => 'ausencias', 'action' => 'editause',$this->data['Ausencia']['id']))); ?>        
        <?php
        echo $this->Form->input('id', array('type' => 'hidden'));
        echo $this->Form->input('empleado_id', array('type' => 'hidden'));
        // INI ROW
        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";
        $options = array('Remunerada' => 'Remunerada', 'No Remunerada' => 'No Remunerada');
        echo $this->Form->input('TIPO', array('div' => false, 'label' => 'Tipo de Ausencia', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->input('FECHA_INI', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Inicio', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->input('FECHA_FIN', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Finalizacion', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";
        echo "</div>";
        // END ROW

        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";        
        echo $this->Form->input('JUSTIFICACION', array('div' => false, 'label' => 'Justificacion'));
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
            <?php echo $this->Form->end(__('Agregar', true)); ?>            
        </div>
    </div>
</div>