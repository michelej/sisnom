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
        <?php echo $this->Form->create('Empleado'); ?>
        <div id="tab1" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom" style="">
            <?php
            //------------------------------------fila--------------------------------------------------------	
            echo "<div class='row'>";
            
            echo "<div style='float:left;width:20%'>";
            echo $this->Form->label('Nacionalidad');
            $options = array('VENEZOLANA' => 'VENEZOLANA', 'EXTRANJERA' => 'EXTRANJERA');
            echo $this->Form->select('NACIONALIDAD', array($options), null, array('empty' => "Seleccione una opción"));            
            echo "</div>";
            
            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Cedula');
            echo $this->Form->input('CEDULA', array('div' => false, 'label' => false, 'class' => 'small'));
            echo "</div>";

            echo "<div style='float:left;width:40%'>";
            echo $this->Form->label('Sexo');
            $options = array('MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO');
            echo $this->Form->select('SEXO', array($options), null, array('empty' => "Seleccione una opción"));            
            echo "</div>";

           

            echo "</div>";
//-----------------------------------------fila----------------------------------------------------------		
            echo "<div class='row'>";

            echo "<div style='float:left;width:50%'>";
            echo $this->Form->label('Nombres');
            echo $this->Form->input('NOMBRE', array('div' => false, 'label' => false, 'class' => 'medium'));
            echo "</div>";
            
//-----------------------------------------fila-----------------------------------------------------------		
            echo "<div class='row'>";

            echo "<div style='float:left;width:50%'>";
            echo $this->Form->label('Apellidos');
            echo $this->Form->input('APELLIDO', array('div' => false, 'label' => false, 'class' => 'medium'));            
            echo "</div>";
//---------------------------------------------fila-------------------------------------------------------		
            echo "<div class='row'>";

            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Fecha de Nacimiento');
            echo $this->Form->input('FECHANAC', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
            echo "</div>";
            
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Estado Civil');
            $options = array('SOLTERO' => 'SOLTERO', 'CASADO' => 'CASADO', 'VIUDO' => 'VIUDO', 'DIVORSIADO' => 'DIVORSIADO', 'COMCUBINATO' => 'COMCUBINATO');
            echo $this->Form->select('EDOCIVIL', array($options), null, array('empty' => "Seleccione una opción"));            
            echo "</div>";
                        
            echo "</div>";
//------------------------------------------fila------------------------------------------------------------		
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Ciudad de Nacimiento');
            echo $this->Form->input('CIUDAD', array('div' => false, 'label' => false, 'class' => 'small'));            
            echo "</div>";
            
            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Estado');
            echo $this->Form->input('ESTADO', array('div' => false, 'label' => false, 'class' => 'small'));                        
            echo "</div>";


            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Municipio');
            echo $this->Form->input('MUNICIPIO', array('div' => false, 'label' => false, 'class' => 'small'));                        
            echo "</div>";
            echo "</div>";


            echo "<div class='row'>";            
            
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Fecha de Ingreso');
            echo $this->Form->input('INGRESO', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
            echo "</div>";
            echo "</div>";
            ?>

        </div>

        <div id="tab2" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
            <?php

//---------------------------------------fila-------------------------------------------
            echo "<div class='row'>";

            echo "<div style='float:left;width:20%'>";
            echo $this->Form->label('Direccion');
            echo $this->Form->input('DIRECCION', array('div' => false, 'label' => false, 'class' => 'large'));            
            echo "</div>";

            echo "</div>";

//---------------------------------------fila--------------------------------------------------		
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

            echo "<div class='row'>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Tipo de Pago');
            $options = array('C' => 'Cheque', 'E' => 'Efectivo', 'B' => 'Banco');
            echo $this->Form->select('EMP_TPAGO', array($options), null, array('empty' => "Seleccione una opción"));
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Banco');
            echo $this->Form->input('EMP_BANCO', array('div' => false, 'label' => false, 'class' => 'small'));
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Número de Cuenta');
            echo $this->Form->input('EMP_NCUENTA', array('div' => false, 'label' => false, 'class' => 'small'));
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Condición Laboral');
            echo $this->Form->input('condiciones_id', array('div' => false, 'label' => false, 'empty' => "Seleccione una opción"));
            echo "</div>";
            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Departamento');
            echo $this->Form->input('dependencias_id', array('div' => false, 'label' => false, 'class' => 'small', 'empty' => "Seleccione una opción"));
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Cargo');
            echo $this->Form->input('cargos_id', array('div' => false, 'label' => false, 'class' => 'small', 'empty' => "Seleccione una opción"));
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";

            echo "</div>";
            ?>
        </div>   

        <div id="tab3" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">		
            <?php
//-------------------------------------------fila-------------------------------------	
            echo "<div class='row'>";

            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Sabe Leer y Escribir');
            $options = array('0' => 'SI', '1' => 'NO');
            echo $this->Form->select('EMP_ALFABETA', array($options), null, array('empty' => "Seleccione una opción"));
            //echo $this->Form->input('EMP_ALFABETA');
            echo "</div>";

            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Tiene Educacion Primaria');
            $options = array('0' => 'SI', '1' => 'NO');
            echo $this->Form->select('EMP_EDUPRIMARIA', array($options), null, array('empty' => "Seleccione una opción"));
            //echo $this->Form->input('EMP_EDUPRIMARIA');
            echo "</div>";

            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Tiene Educacion Secundaria');
            $options = array('0' => 'SI', '1' => 'NO');
            echo $this->Form->select('EMP_EDUSECUNDARIA', array($options), null, array('empty' => "Seleccione una opción"));
            //echo $this->Form->input('EMP_EDUSECUNDARIA');
            echo "</div>";

            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Tiene Educacion Superior');
            $options = array('0' => 'SI', '1' => 'NO');
            echo $this->Form->select('EMP_EDUSUPERIOR', array($options), null, array('empty' => "Seleccione una opción"));
            //echo $this->Form->input('EMP_EDUSUPERIOR');
            echo "</div>";

            echo "</div>";
//----------------------------------------------fila----------------------------------------		
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Donde Estudio Primaria');
            echo $this->Form->input('EMP_PRIMARIA', array('div' => false, 'label' => false, 'class' => 'large'));
            //echo $this->Form->input('EMP_PRIMARIA');
            echo "</div>";
            echo "</div>";

//---------------------------------------------fila------------------------------------------		
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Donde Estudio Secundaria');
            echo $this->Form->input('EMP_SECUNDARIA', array('div' => false, 'label' => false, 'class' => 'large'));
            //echo $this->Form->input('EMP_SECUNDARIA');
            echo "</div>";
            echo "</div>";

            echo "<div class='row'>";
            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Donde Estudio Universidad');
            echo $this->Form->input('EMP_SUPERIOR', array('div' => false, 'label' => false, 'class' => 'large'));
            //echo $this->Form->input('EMP_SUPERIOR');
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
            $options = array('0' => 'O+', '1' => 'O-', '2' => 'A+', '3' => 'A-', '4' => 'B+', '5' => 'B-', '6' => 'AB+', '7' => 'AB-');
            echo $this->Form->select('EMP_SANGRE', array($options), null, array('empty' => "Seleccione una opción"));
//echo $this->Form->input('EMP_SANGRE');
            echo "</div>";

            echo "<div style='float:left;width:28%'>";
            echo $this->Form->label('Peso en kg');
            echo $this->Form->input('PESO', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_PESO');
            echo "</div>";

            echo "<div style='float:left;width:30%'>";
            echo $this->Form->label('Enfermedades');
            echo $this->Form->input('EMP_EMFERMEDADES', array('div' => false, 'label' => false, 'class' => 'medium'));
//echo $this->Form->input('EMP_EMFERMEDADES');
            echo "</div>";
            echo "</div>";
//-----------------------------------------fila--------------------------------------------
            echo "<div class='row'>";
            echo "<div style='float:left;width:50%'>";
            echo $this->Form->label('Operaciones');
            echo $this->Form->input('EMP_OPERACIONES', array('div' => false, 'label' => false, 'class' => 'medium'));
//echo $this->Form->input('EMP_OPERACIONES');
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Alergico');
            echo $this->Form->input('EMP_ALERGICO', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_ALERGICO');
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Estatura cms');
            echo $this->Form->input('EMP_ESTATURA', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_ESTATURA');
            echo "</div>";
            echo "</div>";
//------------------------------------------fila -------------------------------------		
            echo "<div class='row'>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Complexion');
            echo $this->Form->input('EMP_COMPLEXION', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_COMPLEXION');
            echo "</div>";

            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('talla camisa');
            echo $this->Form->input('EMP_TCAMISA', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_TCAMISA');
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('talla pantalon');
            echo $this->Form->input('EMP_TPANTALOM', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_TPANTALOM');
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('talla zapatos');
            echo $this->Form->input('EMP_TCALZADO', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_TCALZADO');
            echo "</div>";
            echo "</div>";
//---------------------------------------------fila----------------------------------------		
            echo "<div class='row'>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label('Tine alguna Discapacidad Fisica');
            $options = array('0' => 'SI', '1' => 'NO');
            echo $this->Form->select('EMP_DISCAPACIDAD', array($options), null, array('empty' => "Seleccione una opción"));
//echo $this->Form->input('EMP_DISCAPACIDAD');
            echo "</div>";
            echo "<div style='float:left;width:25%'>";
            echo $this->Form->label(' Descripcion Discapacidad');
            echo $this->Form->input('EMP_DESCDISCP', array('div' => false, 'label' => false, 'class' => 'medium'));
//echo $this->Form->input('EMP_DESCDISCP');
            echo "</div>";
            echo "</div>";
//---------------------------------------------fila----------------------------------------		
            ?>
        </div>
        <div id="tab6" class="tabdiv ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="">
            <?php
//--------------------------------------fila--------------------------------------------------
            echo "<div class='row'>";
            echo "<div style='float:left;width:80%'>";
            echo $this->Form->label('Comunicarse con');
            echo $this->Form->input('EMP_NOMEMERGENCIA', array('div' => false, 'label' => false, 'class' => 'medium'));
//echo $this->Form->input('EMP_NOMEMERGENCIA');
            echo "</div>";
            echo "<div style='float:left;width:18%'>";
            echo $this->Form->label('por el telefono');
            echo $this->Form->input('EMP_TELEMERGECIA', array('div' => false, 'label' => false, 'class' => 'small'));
//echo $this->Form->input('EMP_TELEMERGECIA');
            echo "</div>";
            echo "</div>";

//echo $this->Form->input('cargos_id');
//echo $this->Form->input('dependencias_id');
//echo $this->Form->input('Asignacion');
//echo $this->Form->input('Devolucion');
//echo $this->Form->input('Titulo');
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
            <?php echo $this->Form->end(__('Agregar', true)); ?>
            <?
            ?>
        </div>
    </div>
</div>