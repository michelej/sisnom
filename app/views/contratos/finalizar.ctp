<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title"><h2>Datos del Contrato</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">            
            <?php echo "<div style='float:left;width:15%'>"; ?>
            <?php echo $this->Form->label('Fecha de Inicio'); ?>
            <?php echo fechaElegible($contrato['Contrato']['FECHA_INI']); ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:30%'>"; ?>
            <?php echo $this->Form->label('Nombre Completo'); ?>
            <?php echo $contrato['Contrato']['MODALIDAD']; ?>
            <?php echo "</div>"; ?>                        
        </div>
    </div>
</div>

<div class="box">
    <div class="title"><h2>Finalizar Contrato</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Contrato', array('url' => array('controller' => 'contratos', 'action' => 'finalizar', $contrato['Contrato']['id'])));

        echo "<div class='row'>";
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
            <div class="boton">
                <?php echo $this->Form->submit('Modificar'); ?>                        
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'edit', $contrato['Contrato']['empleado_id'])); ?>
            </div>
        </div>                
    </div>
</div>