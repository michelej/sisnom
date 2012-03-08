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
    <?php echo $this->Form->create('Empleado'); ?>
    <div id="tab1" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom" style="">
        <?php
        //------------------------------------fila--------------------------------------------------------	
        echo "<div class='row'>";

        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Nacionalidad');
        $options = array('0' => 'Seleccione una opcion', 'Venezolano' => 'Venezolano', 'Extranjero' => 'Extranjero');
        echo $this->Form->input('NACIONALIDAD', array('div' => false, 'label' => false, 'class' => 'small', 'type' => 'select', 'options' => $options));
        echo "</div>";

        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Cedula');
        echo $this->Form->input('CEDULA', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:20%'>";
        echo $this->Form->label('Sexo');
        $options = array('0' => 'Seleccion una opcion', 'Masculino' => 'Masculino', 'Femenino' => 'Femenino');
        echo $this->Form->input('SEXO', array('div' => false, 'label' => false, 'class' => 'small', 'type' => 'select', 'options' => $options));
        echo "</div>";

        echo "</div>";
//-----------------------------------------fila----------------------------------------------------------		
        echo "<div class='row'>";

        echo "<div style='float:left;width:50%'>";
        echo $this->Form->label('Nombres');
        echo $this->Form->input('NOMBRE', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";

        echo "</div>";
//-----------------------------------------fila-----------------------------------------------------------		
        echo "<div class='row'>";

        echo "<div style='float:left;width:50%'>";
        echo $this->Form->label('Apellidos');
        echo $this->Form->input('APELLIDO', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";

        echo "</div>";
//---------------------------------------------fila-------------------------------------------------------		
        echo "<div class='row'>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Fecha de Nacimiento');
        echo $this->Form->input('FECHANAC', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Estado Civil');
        $options = array('Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorsiado' => 'Divorsiado', 'Comcubinato' => 'Comcubinato');
        echo $this->Form->select('EDOCIVIL', array($options), null, array('empty' => "Seleccione una opción"));
        echo "</div>";

        echo "</div>";
//------------------------------------------fila------------------------------------------------------------		
        echo "<div class='row'>";
        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Ciudad de Nacimiento');
        echo $this->Form->input('CIUDAD', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Estado');
        echo $this->Form->input('ESTADO', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Municipio');
        echo $this->Form->input('MUNICIPIO', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";
        echo "</div>";

        //-------------------------------------------------------------------------------------
//---------------------------------------fila-------------------------------------------
        echo "<div class='row'>";

        echo "<div style='float:left;width:20%'>";
        echo $this->Form->label('Direccion');
        echo $this->Form->input('DIRECCION', array('div' => false, 'label' => false, 'class' => 'large'));
        echo "</div>";

        echo "</div>";

        echo "<div class='row'>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Telefono Residencial');
        echo $this->Form->input('TELEFONO', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:28%'>";
        echo $this->Form->label('Telefono Celular');
        echo $this->Form->input('CELULAR', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('email');
        echo $this->Form->input('EMAIL', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";

        echo "</div>";
        ?>

    </div>

    <div id="tab2" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
        <?php
//-----------------------------------------fila---------------------------------------
        echo "<div class='row'>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Fecha de Ingreso');
        echo $this->Form->input('INGRESO', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "</div>";
//---------------------------------------fila--------------------------------------------------		           

        echo "<div class='row'>";
        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Tipo de Pago');
        $options = array('Cheque' => 'Cheque', 'Efectivo' => 'Efectivo', 'Banco' => 'Banco');
        echo $this->Form->select('TPAGO', array($options), null, array('empty' => "Seleccione una opción"));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Banco');
        echo $this->Form->input('BANCO', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Número de Cuenta');
        echo $this->Form->input('NCUENTA', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Condición Laboral');
        $options = array('Fijo' => 'Fijo', 'Contratado' => 'Contratado', 'Temporal' => 'Temporal');
        echo $this->Form->select('Asignaciones.MODALIDAD', array($options), null, array('empty' => "Seleccione una opción"));
        echo "</div>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Departamento');
        echo $this->Form->input('Asignaciones.departamento_id', array('div' => false, 'label' => false, 'class' => 'small', 'empty' => "Seleccione una opción"));
        echo "</div>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Cargo');
        echo $this->Form->input('Asignaciones.cargo_id', array('div' => false, 'label' => false, 'class' => 'small', 'empty' => "Seleccione una opción"));
        echo "</div>";                
        ?>
    </div>   

    <div id="tab3" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">		
        <?php
//-------------------------------------------fila-------------------------------------	
        echo "<div class='row'>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Sabe Leer y Escribir');
        $options = array('Si' => 'Si', 'No' => 'No');
        echo $this->Form->select('ALFABETA', array($options), null, array('empty' => "Seleccione una opción"));
        echo "</div>";

        echo "</div>";
//----------------------------------------------fila----------------------------------------		
        echo "<div class='row'>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Donde Estudio Primaria');
        echo $this->Form->input('PRIMARIA', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";
        echo "</div>";

//---------------------------------------------fila------------------------------------------		
        echo "<div class='row'>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Donde Estudio Secundaria');
        echo $this->Form->input('SECUNDARIA', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Donde Estudio Universidad');
        echo $this->Form->input('SUPERIOR', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";
        echo "</div>";
//--------------------------------------------------------------------------------------------		
        ?>	
    </div> 	
    <div id="tab4" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
        <?php
//--------------------------------------------------fila---------------------------------
        echo "<div class='row'>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Tipo de Sangre');
        $options = array('O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-');
        echo $this->Form->select('SANGRE', array($options), null, array('empty' => "Seleccione una opción"));
        echo "</div>";

        echo "<div style='float:left;width:28%'>";
        echo $this->Form->label('Peso en kg');
        echo $this->Form->input('PESO', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:30%'>";
        echo $this->Form->label('Enfermedades');
        echo $this->Form->input('EMFERMEDADES', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";

        echo "</div>";
//-----------------------------------------fila--------------------------------------------
        echo "<div class='row'>";
        echo "<div style='float:left;width:50%'>";
        echo $this->Form->label('Operaciones');
        echo $this->Form->input('OPERACIONES', array('div' => false, 'label' => false, 'class' => 'medium'));

        echo "</div>";
        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Alergico');
        echo $this->Form->input('ALERGICO', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Estatura cms');
        echo $this->Form->input('ESTATURA', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "</div>";
//------------------------------------------fila -------------------------------------		
        echo "<div class='row'>";
        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('Complexion');
        echo $this->Form->input('COMPLEXION', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('talla camisa');
        echo $this->Form->input('TCAMISA', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('talla pantalon');
        echo $this->Form->input('TPANTALOM', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "<div style='float:left;width:25%'>";
        echo $this->Form->label('talla zapatos');
        echo $this->Form->input('TCALZADO', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "</div>";
//---------------------------------------------fila----------------------------------------		
        echo "<div class='row'>";

        echo "<div style='float:left;width:45%'>";
        echo $this->Form->label('Si tiene Discapacidad Breve Descripcion');
        echo $this->Form->input('DISCAPACIDAD', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";

        echo "</div>";
//---------------------------------------------fila----------------------------------------		
        ?>
    </div>
    <div id="tab5" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
        <?php
//--------------------------------------fila--------------------------------------------------
        echo "<div class='row'>";
        echo "<div style='float:left;width:80%'>";
        echo $this->Form->label('Contacto de Emergencia');
        echo $this->Form->input('NOMEMERGENCIA', array('div' => false, 'label' => false, 'class' => 'medium'));
        echo "</div>";

        echo "</div>";

        echo "<div class='row'>";

        echo "<div style='float:left;width:60%'>";
        echo $this->Form->label('Telefono de Emergencia');
        echo $this->Form->input('TELEMERGECIA', array('div' => false, 'label' => false, 'class' => 'small'));
        echo "</div>";

        echo "</div>";
        ?>
    </div>
</div>    