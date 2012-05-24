<script>
    $(function() {
        $( "#dialog-pantalla" ).dialog({
            autoOpen: false,
            modal: true,
            zIndex:1500,
            resizable: false,
            height:250,
            width:250,
            draggable:false
        });
        $( "#dialog-archivo" ).dialog({
            autoOpen: false,
            modal: true,
            zIndex:1500,
            resizable: false,
            height:150,
            width:250,
            draggable:false
        });
        $( "#opener-pantalla" ).click(function() {
            $( "#dialog-pantalla" ).dialog( "open" );
            return false;
        });
        $( "#opener-archivo" ).click(function() {
            $( "#dialog-archivo" ).dialog( "open" );
            return false;
        });
        $( ".closer-pantalla" ).click(function() {
            $( "#dialog-pantalla" ).dialog( "close" );            
            var url = $(this).attr("href"); 
            windows.open(url);            
            return false;
        });
        $( ".closer-archivo" ).click(function() {
            $( "#dialog-archivo" ).dialog( "close" );            
            var url = $(this).attr("href"); 
            windows.open(url);            
            return false;
        });
    });
</script>

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
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">        
        <div class="row">
            <div class="boton">
                <?php echo $this->Html->link('Generar Nomina', array('action' => 'generar', $nomina['Nomina']['id'])); ?>
            </div>  
            <div class="boton">
                <?php echo $this->Html->link('Mostrar Pantalla', array(), array('id' => 'opener-pantalla')); ?>
            </div> 
            <div class="boton">
                <?php echo $this->Html->link('Mostrar Archivo', array(), array('id' => 'opener-archivo')); ?>
            </div> 
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div> 
        </div>                         
    </div>
</div>

<div id="dialog-pantalla" title="Opciones Pantalla">
    <div class="row">
        <div class="boton">
            <?php echo $this->Html->link('Nomina Empleados', array('action' => 'mostrar', $nomina['Nomina']['id'], 'pantalla_nomina', 'Empleado'), array('target' => '_blank', 'class' => 'closer-pantalla')); ?>
        </div>
    </div>
    <div class="row">
        <div class="boton">
            <?php echo $this->Html->link('Resumen Empleados', array('action' => 'mostrar', $nomina['Nomina']['id'], 'pantalla_resumen', 'Empleado'), array('target' => '_blank', 'class' => 'closer-pantalla')); ?>
        </div>
    </div>
    <div class="row">
        <div class="boton">
            <?php echo $this->Html->link('Nomina Obreros', array('action' => 'mostrar', $nomina['Nomina']['id'], 'pantalla_nomina', 'Obrero'), array('target' => '_blank', 'class' => 'closer-pantalla')); ?>
        </div>
    </div>
    <div class="row">
        <div class="boton">
            <?php echo $this->Html->link('Resumen Obreros', array('action' => 'mostrar', $nomina['Nomina']['id'], 'pantalla_resumen', 'Obrero'), array('target' => '_blank', 'class' => 'closer-pantalla')); ?>
        </div>
    </div>
</div>

<div id="dialog-archivo" title="Opciones Archivo">
    <div class="row">
        <div class="boton">
            <?php echo $this->Html->link('Nomina Empleados', array('action' => 'mostrar', $nomina['Nomina']['id'], 'archivo', 'Empleado'), array('target' => '_blank', 'class' => 'closer-archivo')); ?>
        </div>
    </div>
    <div class="row">
        <div class="boton">
            <?php echo $this->Html->link('Nomina Obreros', array('action' => 'mostrar', $nomina['Nomina']['id'], 'archivo', 'Obrero'), array('target' => '_blank', 'class' => 'closer-archivo')); ?>
        </div>
    </div>
</div>


