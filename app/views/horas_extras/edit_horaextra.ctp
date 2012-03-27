<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>
<div class="box">
    <div class="title"><h2>Datos de la Hora Extra</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <?php echo $this->Form->create('HorasExtra',array('url' => array('controller' => 'horas_extras', 'action' => 'edit_horaextra',$this->data['HorasExtra']['id']))); ?>        
        <?php
        echo $this->Form->input('id', array('type' => 'hidden'));
        echo $this->Form->input('empleado_id', array('type' => 'hidden'));
        // INI ROW
        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";
        $options = array('Nocturno' => 'Nocturno', 'Domingos y Dias Feriados' => 'Domingos y Dias Feriados');
        echo $this->Form->input('TIPO', array('div' => false, 'label' => 'Tipo de Hora Extra', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->input('FECHA', array('type' => 'text', 'div' => false, 'label' => 'Fecha', 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";               
        echo "</div>";
        // END ROW

        echo "<div class='row'>";
        echo "<div style='float:left;width:40%'>";        
        echo $this->Form->input('COMENTARIO', array('type' => 'text','div' => false, 'label' => 'Comentario'));
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
            <?php echo $this->Form->end('Guardar Cambios'); ?>            
        </div>
        <div class="row boton">                     
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'edit',$this->data['HorasExtra']['empleado_id'])); ?>
            </div>        
        </div>
    </div>
</div>