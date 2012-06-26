<div class="box">
    <div class="title"><h2>Datos de la Nomina</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:50%'>"; ?>            
            <?php echo $nomina['Nomina']['MES'] . "&nbsp&nbsp&nbsp/&nbsp&nbsp&nbsp" . $nomina['Nomina']['AÑO'] . "&nbsp&nbsp&nbsp&nbsp&nbsp" . $nomina['Nomina']['QUINCENA'] . " Quincena"; ?>
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
    <div class="title">	<h2>Resumen</h2></div>
    <div class="content form">         
        <div class="row">
            <?php
            $fijos = 0;
            $contra = 0;
            foreach ($nomina['Recibo'] as $emp) {
                if($emp['MODALIDAD']=='Fijo') {
                    $fijos++;
                }
                if($emp['MODALIDAD']=='Contratado') {
                    $contra++;
                }
            }

            if (empty($nomina['Recibo'])) {
                echo "Esta nomina no contiene informacion, proceda a la opcion Generar Nomina.";
            } else {
                echo "Fecha de elaboración: " . date('d-M-Y h:i:s a', strtotime($nomina['Nomina']['FECHA_ELA']));
                echo "<br />";
                echo "<br />";
                echo "Contiene: " . count($nomina['Recibo']) . " Empleados";
                echo "<br />";
                echo "Fijos: ".$fijos;
                echo "<br />";
                echo "Contratados: ".$contra;
            }
            ?>
        </div>
    </div>
</div>

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">         
        <div class="row">
            <?php
            echo $this->Form->create(false, array('target' => '_blank', 'url' => array('controller' => 'nominas', 'action' => 'mostrar')));
            echo "<div style='float:left;width:35%;'>";
            $options = array('1' => 'Empleado - Fijo', '2' => 'Obrero - Fijo', '3' => 'Contratado');
            echo $this->Form->input('nomina_id', array('type' => 'hidden', 'value' => $nomina['Nomina']['id']));
            echo $this->Form->input('PERSONAL', array('div' => false, 'label' => 'Personal', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
            echo "</div>";

            echo "<div style='float:left;width:35%;'>";
            $options = array('Nomina' => 'Nomina', 'Resumen' => 'Resumen de Nomina', 'Completo' => 'Completo');
            echo $this->Form->input('TIPO', array('div' => false, 'label' => 'Tipo', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
            echo "</div>";

            echo "<div style='float:left;width:30%;'>";
            $options = array('Pantalla' => 'Pantalla', 'Archivo' => 'Archivo');
            echo $this->Form->input('VISUALIZAR', array('div' => false, 'label' => 'Visualizar', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una Opcion'));
            echo "</div>";
            ?>
        </div>
        <div class="row"></div>

        <div class="row">            
            <div class="boton">
                <?php echo $this->Form->End('Mostrar'); ?>
            </div>
            <div class="boton">
                <?php echo $this->Html->link('Generar Nomina', array('action' => 'wizard')); ?>
            </div>            
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div> 
        </div>         
    </div>
</div>