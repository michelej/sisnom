<?php if (!empty($this->validationErrors)) { ?>
    <div class="box">  
        <div class="flash_error">        
            <?php echo $this->Html->image('test-fail-icon.png', array('alt' => 'flash_error')) ?>   
            <?php echo "Existen errores en la forma corrigalos antes de continuar" ?>
        </div>
    </div>
<?php } ?>
<div class="box">
    <div class="title"><h2><?php __('Datos Personales'); ?></h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
        <ul  class="tabnav ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
            <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
                <a href="#tab1">Datos Personales</a>
            </li>

            <li class="ui-state-default ui-corner-top">
                <a href="#tab2">Laboral</a>
            </li>
            <li class="ui-state-default ui-corner-top">
                <a href="#tab3">Curriculum</a>
            </li>
            <li class="ui-state-default ui-corner-top">
                <a href="#tab4">Seguridad Industrial</a>
            </li>
            <li class="ui-state-default ui-corner-top">
                <a href="#tab5">SOS</a>
            </li>
        </ul>
        <?php echo $this->Form->create('Empleado');         
        echo $this->Form->input('id', array('type' => 'hidden'));
        ?>
        <div id="tab1" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom" style="">
            <?php
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";            
            $options = array('0' => 'Seleccione una opcion', 'Venezolano' => 'Venezolano', 'Extranjero' => 'Extranjero');
            echo $this->Form->input('NACIONALIDAD', array('div' => false, 'label' => 'Nacionalidad', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";

            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('CEDULA', array('div' => false, 'label' => 'Cedula', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:20%'>";            
            $options = array('0' => 'Seleccion una opcion', 'Masculino' => 'Masculino', 'Femenino' => 'Femenino');
            echo $this->Form->input('SEXO', array('div' => false, 'label' => 'Sexo', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:50%'>";            
            echo $this->Form->input('NOMBRE', array('div' => false, 'label' => 'Nombres', 'class' => 'medium'));
            echo "</div>";
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:50%'>";            
            echo $this->Form->input('APELLIDO', array('div' => false, 'label' => 'Apellidos', 'class' => 'medium'));
            echo "</div>";
            echo "</div>";
            //END ROW
            //INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('FECHANAC', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Nacimiento', 'class' => 'datepicker dp-applied')) . "</br>";
            echo "</div>";

            echo "<div style='float:left;width:25%'>";            
            $options = array('0'=>'Seleccione una opcion','Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado', 'Comcubinato' => 'Comcubinato');            
            echo $this->Form->input('EDOCIVIL', array('div' => false, 'label' => 'Estado Civil', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('CIUDAD', array('div' => false, 'label' => 'Ciudad de Nacimiento', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('ESTADO', array('div' => false, 'label' => 'Estado', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:40%'>";            
            echo $this->Form->input('MUNICIPIO', array('div' => false, 'label' => 'Municipio', 'class' => 'small'));
            echo "</div>";
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:20%'>";
            echo $this->Form->label('Direccion');
            echo $this->Form->input('DIRECCION', array('div' => false, 'label' => false, 'class' => 'large'));
            echo "</div>";
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('TELEFONO', array('div' => false, 'label' => 'Telefono Residencial', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('CELULAR', array('div' => false, 'label' => 'Telefono Celular', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('EMAIL', array('div' => false, 'label' => 'email', 'class' => 'small'));
            echo "</div>";
            echo "</div>";
            // END ROW
            ?>
        </div> 

        <div id="tab2" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
            <?php
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:25%'>";            
            echo $this->Form->input('INGRESO', array('type' => 'text', 'div' => false, 'label' => 'Fecha de Ingreso', 'class' => 'datepicker dp-applied')) . "</br>";
            echo "</div>";
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";            
            echo "<div style='float:left;width:50%'>";            
            echo $this->Form->input('BANCO', array('div' => false, 'label' => 'Banco', 'class' => 'medium'));
            echo "</div>";
            
            echo "<div style='float:left;width:20%'>";            
            $options = array('0'=>'Seleccione una opcion','Cheque' => 'Cheque', 'Efectivo' => 'Efectivo', 'Banco' => 'Banco');            
            echo $this->Form->input('TPAGO', array('div' => false, 'label' => 'Tipo de Pago', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "</div>";            
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:20%'>";            
            echo $this->Form->input('NCUENTA', array('div' => false, 'label' => 'Numero de Cuenta', 'class' => 'medium'));
            echo "</div>";            
            echo "</div>"; 
            // END ROW            
            ?>
        </div>   

        <div id="tab3" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">		
            <?php
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:25%'>";            
            $options = array('0'=>'Seleccione una opcion','Si' => 'Si', 'No' => 'No');            
            echo $this->Form->input('ALFABETA', array('div' => false, 'label' => 'Sabe leer y escribir', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "</div>";
            // FIN ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('PRIMARIA', array('div' => false, 'label' => 'Donde Estudio Primaria', 'class' => 'medium'));
            echo "</div>";
            echo "</div>";
            // FIN ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('SECUNDARIA', array('div' => false, 'label' => 'Donde Estudio Secundaria', 'class' => 'medium'));
            echo "</div>";
            echo "</div>";
            // FIN ROW
            // END ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('SUPERIOR', array('div' => false, 'label' => 'Universidad a la que asistio', 'class' => 'medium'));
            echo "</div>";
            echo "</div>";
            // END ROW
            ?>	
        </div> 	
        <div id="tab4" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
            <?php
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";           
            $options = array('0'=>'Seleccione una opcion','O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-');            
            echo $this->Form->input('SANGRE', array('div' => false, 'label' => 'Tipo de Sangre', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";

            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('PESO', array('div' => false, 'label' => 'Peso en Kg', 'class' => 'small'));
            echo "</div>";
            
            echo "<div style='float:left;width:25%'>";            
            echo $this->Form->input('ESTATURA', array('div' => false, 'label' => 'Estatura en cms', 'class' => 'small'));
            echo "</div>";            
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:60%'>";            
            echo $this->Form->input('EMFERMEDADES', array('div' => false, 'label' => 'Enfermedades', 'class' => 'medium'));
            echo "</div>";
            
            echo "<div style='float:left;width:30%'>";            
            echo $this->Form->input('ALERGICO', array('div' => false, 'label' => 'Alergico', 'class' => 'small'));
            echo "</div>"; 
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:50%'>";            
            echo $this->Form->input('OPERACIONES', array('div' => false, 'label' => 'Operaciones', 'class' => 'medium'));
            echo "</div>";                       
            echo "</div>";
            // FIN ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:25%'>";            
            echo $this->Form->input('COMPLEXION', array('div' => false, 'label' => 'Complexion', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:25%'>";            
            echo $this->Form->input('TCAMISA', array('div' => false, 'label' => 'Talla de Camisa', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:25%'>";            
            echo $this->Form->input('TPANTALOM', array('div' => false, 'label' => 'Talla de Pantalon', 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:25%'>";            
            echo $this->Form->input('TCALZADO', array('div' => false, 'label' => 'Talla de Zapatos', 'class' => 'small'));
            echo "</div>";
            echo "</div>";
            // END ROW
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:45%'>";            
            echo $this->Form->input('DISCAPACIDAD', array('div' => false, 'label' => 'Si tiene Discapacidad Breve Descripcion', 'class' => 'medium'));
            echo "</div>";
            echo "</div>";
            // END ROW
            ?>
        </div>
        <div id="tab5" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
            <?php
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:80%'>";            
            echo $this->Form->input('NOMEMERGENCIA', array('div' => false, 'label' => 'Contacto de Emergencia', 'class' => 'medium'));
            echo "</div>";
            echo "</div>";
            // INI ROW
            echo "<div class='row'>";
            echo "<div style='float:left;width:60%'>";            
            echo $this->Form->input('TELEMERGECIA', array('div' => false, 'label' => 'Telefono del contacto', 'class' => 'small'));
            echo "</div>";
            echo "</div>";
            // END ROW
            ?>
        </div>
    </div>    
</div>


<div class="box">
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row">
            <?php echo $this->Form->end(__('Guardar Cambios', true)); ?>
            <?
            ?>
        </div>
    </div>
</div>