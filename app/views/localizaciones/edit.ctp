<div class="box">
    <div class="title"><h2>Datos del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:10%'>"; ?>
            <?php echo $this->Form->label('Cedula / Rif'); ?>
            <?php echo $empleado['Empleado']['CEDULA'] ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:30%'>"; ?>
            <?php echo $this->Form->label('Nombre Completo'); ?>
            <?php echo mb_convert_case(strtolower($empleado['Empleado']['APELLIDO']), MB_CASE_TITLE, "UTF-8") . ' ' . mb_convert_case(strtolower($empleado['Empleado']['NOMBRE']), MB_CASE_TITLE, "UTF-8"); ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:15%'>"; ?>
            <?php echo $this->Form->label('Fecha de Ingreso'); ?>
            <?php echo fechaElegible($empleado['Empleado']['INGRESO']); ?>
            <?php echo "</div>"; ?>                        
        </div>
    </div>   
</div>

<div class="box">
    <div class="title"><h2>Localizacion Fisica del Empleado</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <?php
        echo $this->Form->create('Localizacion', array('url' => array('controller' => 'localizaciones', 'action' => 'edit', $empleado['Empleado']['id'])));        
        
        echo "<div class='row'>";
        echo "<div style='float:left;width:50%'>";
        echo $this->Form->input('departamento_id', array('type'=>'select','div' => false, 'label' => 'Departamento','default'=>$empleado['Localizacion']['departamento_id'] ,'class' => 'medium', 'empty' => "SIN ESPECIFICAR"));
        echo "</div>";
        echo "</div>";
        echo $this->Form->input('id_empleado', array('value' => $empleado['Empleado']['id'], 'type' => 'hidden'));
        ?>
    </div>
</div>

<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row">
            <div class="boton">                
                <?php echo $this->Form->end('Modificar'); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>
        </div>        
    </div>
</div>