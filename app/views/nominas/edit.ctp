<?php //debug($nomina); ?>
<?php //debug($empleados); ?>
<div class="box">
    <div class="title"><h2>Datos de la Nomina</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:10%'>"; ?>            
            <?php echo $nomina['Nomina']['MES']; ?>
            <?php echo "</div>"; ?>           
            <?php echo "<div style='float:left;width:5%'>"; ?>            
            <?php echo " / " ?>
            <?php echo "</div>"; ?>           
            <?php echo "<div style='float:left;width:10%'>"; ?>            
            <?php echo $nomina['Nomina']['AÑO']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:70%'>"; ?>            
            <?php echo $nomina['Nomina']['QUINCENA'] . " Quincena"; ?>
            <?php echo "</div>"; ?>           
        </div>   
        <div class="row">
            <?php echo "<div style='float:left;width:20%'>"; ?>
            <?php echo $this->Form->label('Codigo'); ?>
            <?php echo $nomina['Nomina']['CODIGO']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:20%'>"; ?>
            <?php echo $this->Form->label('Fecha de Inicio'); ?>
            <?php echo fechaElegible($nomina['Nomina']['FECHA_INI']); ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:60%'>"; ?>
            <?php echo $this->Form->label('Fecha de Finalizacion'); ?>
            <?php echo fechaElegible($nomina['Nomina']['FECHA_FIN']); ?>
            <?php echo "</div>"; ?>            
        </div>
    </div>
</div>

<div class="box">
    <div class="title"><h2></h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        
    </div>
</div>

<div class="box">
<?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">
        <div class="row boton">            
            <div class="boton">
                <?php echo $this->Html->link('Generar Nomina', array('action' => 'generar',$nomina['Nomina']['id']),array('target' => '_blank')); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>            
        </div>        
    </div>
</div>