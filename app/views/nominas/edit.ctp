<script>
    $(function() {
        $( "#dialog" ).dialog({
            autoOpen: false,
            modal: true,
            zIndex:1500,
            resizable: false,
            height:400,
            width:400,
            draggable:false
        });        
        $( "#opener" ).click(function() {
            $( "#dialog" ).dialog( "open" );
            return false;
        });        
        $( ".closer" ).click(function() {
            $( "#dialog" ).dialog( "close" );            
            //var url = $(this).attr("href"); 
            //windows.open(url);            
            return false;
        });
        $("#ordenable").sortable({
            placeholder: "ui-state-highlight"
        }); 
        $("#ordenable").disableSelection(); 
        $("#ordenable .delete").click(function() { 
            $(this).parent().remove();
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
            <?php
            echo $this->Form->create(false, array('target' => '_blank', 'url' => array('controller' => 'nominas', 'action' => 'mostrar')));
            echo "<div style='float:left;width:30%;'>";
            $options = array('1' => 'Empleado - Fijo', '2' => 'Obrero - Fijo', '3' => 'Contratado');
            echo $this->Form->input('nomina_id', array('type' => 'hidden', 'value' => $nomina['Nomina']['id']));
            echo $this->Form->input('PERSONAL', array('div' => false, 'label' => 'Personal', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
            echo "</div>";

            echo "<div style='float:left;width:30%;'>";
            $options = array('Nomina' => 'Nomina', 'Resumen' => 'Resumen de Nomina','Completo'=>'Completo');
            echo $this->Form->input('TIPO', array('div' => false, 'label' => 'Tipo', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
            echo "</div>";

            echo "<div style='float:left;width:30%;'>";
            $options = array('Pantalla' => 'Pantalla', 'Archivo' => 'Archivo');
            echo $this->Form->input('VISUALIZAR', array('div' => false, 'label' => 'Visualizar', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
            echo "</div>";

            echo "</div>";

            echo "<div class='row'>";
            echo "<div style='float:left;width:20%;padding-top:16px'>";
            echo $this->Form->End('Mostrar');
            echo "</div>";
            ?>
        </div>
        <div class="row">
            <div class="boton">
                <?php echo $this->Html->link('Generar Nomina', array('action' => 'generar', $nomina['Nomina']['id'])); ?>
            </div> 
            <div class="boton">
                <?php echo $this->Html->link('Generar Nomina', array(), array('id' => 'opener')); ?>
            </div>            
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div> 
        </div>         
    </div>
</div>

<div id="dialog" title="Opciones Pantalla">
    <?php
    echo "<ul id=ordenable>";
    foreach ($asignaciones as $value) {
        echo "<li class='ui-state-default'>$value.<input class='delete' type='submit' value='Delete' />
        </li>";
    }
    echo "</ul>";
    ?>
</div>