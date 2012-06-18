<div class="box">
    <div class="title"><h2>Datos de la Nomina</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:10%'>"; ?>            
            <?php echo $cestaticket['Cestaticket']['MES']; ?>
            <?php echo "</div>"; ?>           
            <?php echo "<div style='float:left;width:5%'>"; ?>            
            <?php echo " / " ?>
            <?php echo "</div>"; ?>           
            <?php echo "<div style='float:left;width:10%'>"; ?>            
            <?php echo $cestaticket['Cestaticket']['AÑO']; ?>
            <?php echo "</div>"; ?>            
        </div>   
        <div class="row">            
            <?php echo "<div style='float:left;width:20%'>"; ?>
            <?php echo $this->Form->label('Fecha de Inicio'); ?>
            <?php echo fechaElegible($cestaticket['Cestaticket']['FECHA_INI']); ?>
            <?php echo "</div>"; ?>            
            <?php echo "<div style='float:left;width:60%'>"; ?>
            <?php echo $this->Form->label('Fecha de Finalizacion'); ?>
            <?php echo fechaElegible($cestaticket['Cestaticket']['FECHA_FIN']); ?>
            <?php echo "</div>"; ?>            
        </div>
    </div>
</div>

<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2></h2></div>
    <div class="content form">
        
        <div class="row">
            <?php
            echo $this->Form->create(false, array('target' => '_blank','url' => array('controller' => 'cestatickets', 'action' => 'mostrar')));            
            echo "<div style='float:left;width:40%;'>";
            $options = array('1' => 'Empleado - Fijo', '2' => 'Obrero - Fijo','3'=>'Contratado');
            echo $this->Form->input('cestaticket_id', array('type' => 'hidden','value'=>$cestaticket['Cestaticket']['id']));
            echo $this->Form->input('PERSONAL', array('div' => false, 'label' => 'Tipo de Nomina', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione una Opcion'));
            echo "</div>";            
            
            echo "<div style='float:left;width:50%;'>";
            $options = array('Pantalla' => 'Pantalla', 'Archivo' => 'Archivo');                        
            echo $this->Form->input('VISUALIZAR', array('div' => false, 'label' => 'Visualizar', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione una Opcion'));
            echo "</div>";                        
            ?>
        </div>        
        
        <div class="row">                                    
            <div class="boton">
                <?php echo $this->Form->End('Mostrar'); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Generar Nomina', array('action' => 'generar', $cestaticket['Cestaticket']['id'])); ?>
            </div> 
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>  
        </div>        
    </div>
</div>