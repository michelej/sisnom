<div class="box big ">
    <div class="title"><h2>Datos Personales</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row"></div>
        <div class="row">
            <div style="float: left; width: 20%;text-align: right;padding-right: 20px">
                <strong>Nombre Completo</strong>
            </div>            
            <div style="float: left; width:75%">
                <?php echo mb_convert_case(strtolower($empleado['Empleado']['APELLIDO']), MB_CASE_TITLE, "UTF-8") . ' ' . mb_convert_case(strtolower($empleado['Empleado']['NOMBRE']), MB_CASE_TITLE, "UTF-8"); ?>
            </div>
            <div style="float: left; width: 20%;text-align: right;padding-right: 20px">
                <strong>Cedula</strong>
            </div>
            <div style="float: left; width: 75%">
                <?php echo $empleado['Empleado']['CEDULA']; ?>
            </div>
            <div style="float: left; width: 20%;text-align: right;padding-right: 20px">
                <strong>Nacionalidad</strong>
            </div>
            <div style="float: left; width: 75%">
                <?php echo $empleado['Empleado']['NACIONALIDAD']; ?>
            </div>
            <div style="float: left; width: 20%;text-align: right;padding-right: 20px">
                <strong>Sexo</strong>
            </div>
            <div style="float: left; width: 75%">
                <?php echo $empleado['Empleado']['SEXO']; ?>
            </div>
            <div style="float: left; width: 20%;text-align: right;padding-right: 20px">
                <strong>Fecha de Nacimiento</strong>
            </div>
            <div style="float: left; width: 75%">
                <?php echo fechaElegible($empleado['Empleado']['FECHANAC']); ?>
            </div>
            <div style="float: left; width: 20%;text-align: right;padding-right: 20px">
                <strong>Edad</strong>
            </div>
            <div style="float: left; width: 75%">
                <?php echo $empleado['Empleado']['EDAD']; ?>
            </div>
            <div style="float: left; width: 20%;text-align: right;padding-right: 20px">
                <strong>Estado Civil</strong>
            </div>
            <div style="float: left; width: 75%">
                <?php echo $empleado['Empleado']['EDOCIVIL']; ?>
            </div>            
        </div>         
        <div class="row"></div>
    </div>
</div>
<div class="box small ">
    <div class="title"><h2>Foto</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo $this->Html->image("no-user.jpg", array('class' => 'toggle')); ?>
        </div>
    </div>
</div>

<div class="box">
    <div class="title"><h2>Datos de Contacto</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <div style="float: left; width: 20%">
                <strong>Direccion</strong>
            </div>            
            <div style="float: left; width:80%">
                <?php
                if (!empty($empleado['Empleado']['DIRECCION'])) {
                    echo $empleado['Empleado']['DIRECCION'];
                } else {
                    echo "No especificado";
                }
                ?>
            </div>
            <div style="float: left; width: 20%">
                <strong>Estado</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['ESTADO'])) {
                    echo $empleado['Empleado']['ESTADO'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Municipio</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['MUNICIPIO'])) {
                    echo $empleado['Empleado']['MUNICIPIO'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div> 
            <div style="float: left; width: 20%">
                <strong>Telefono</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['TELEFONO'])) {
                    echo $empleado['Empleado']['TELEFONO'];
                } else {
                    echo "No especificado";
                }
                ?>
            </div>
            <div style="float: left; width: 20%">
                <strong>Telefono Movil</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['CELULAR'])) {
                    echo $empleado['Empleado']['CELULAR'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Correo Electronico</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['EMAIL'])) {
                    echo $empleado['Empleado']['EMAIL'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>             
        </div>
    </div>
</div>

<div class="box">
    <div class="title"><h2>Datos de Laborales</h2>
            <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <div style="float: left; width: 20%">
                <strong>Fecha de Ingreso</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php                
                    echo fechaElegible($empleado['Empleado']['INGRESO']);                                                
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Tipo de Cuenta</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['TPAGO'])) {
                    echo $empleado['Empleado']['TPAGO'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>                                     
            <div style="float: left; width: 20%">
                <strong>Banco</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['BANCO'])) {
                    echo $empleado['Empleado']['BANCO'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div> 
            <div style="float: left; width: 20%">
                <strong>Numero de Cuenta</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['NCUENTA'])) {
                    echo $empleado['Empleado']['NCUENTA'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>                                     
        </div>   
    </div>
</div>

<div class="box">
    <div class="title"><h2>Otros Datos</h2>
            <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <div style="float: left; width: 20%">
                <strong>Primaria</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['PRIMARIA'])) {
                    echo $empleado['Empleado']['PRIMARIA'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Secundaria</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['SECUNDARIA'])) {
                    echo $empleado['Empleado']['SECUNDARIA'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>                                     
            <div style="float: left; width: 20%">
                <strong>Universidad</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['SUPERIOR'])) {
                    echo $empleado['Empleado']['SUPERIOR'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div> 
            <div style="float: left; width: 20%">
                <strong>Tipo de Sangre</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['SANGRE'])) {
                    echo $empleado['Empleado']['SANGRE'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Peso</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['PESO'])) {
                    echo $empleado['Empleado']['PESO'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Estatura</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['ESTATURA'])) {
                    echo $empleado['Empleado']['ESTATURA'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Talla Camisa</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['TCAMISA'])) {
                    echo $empleado['Empleado']['TCAMISA'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
             <div style="float: left; width: 20%">
                <strong>Talla Pantalon</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['TPANTALON'])) {
                    echo $empleado['Empleado']['TPANTALON'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
             <div style="float: left; width: 20%">
                <strong>Talla Zapatos</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['TCALZADO'])) {
                    echo $empleado['Empleado']['TCALZADO'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
             <div style="float: left; width: 20%">
                <strong>Enfermedades</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['ENFERMEDADES'])) {
                    echo $empleado['Empleado']['ENFERMEDADES'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
             <div style="float: left; width: 20%">
                <strong>Operaciones</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['OPERACIONES'])) {
                    echo $empleado['Empleado']['OPERACIONES'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Alergias</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['ALERGICO'])) {
                    echo $empleado['Empleado']['ALERGICO'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Complexion</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['COMPLEXION'])) {
                    echo $empleado['Empleado']['COMPLEXION'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Discapacidad</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['DISCAPACIDAD'])) {
                    echo $empleado['Empleado']['DISCAPACIDAD'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Nombre Contacto</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['NOMEMERGENCIA'])) {
                    echo $empleado['Empleado']['NOMEMERGENCIA'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            <div style="float: left; width: 20%">
                <strong>Telefono Contacto</strong>
            </div>
            <div style="float: left; width: 80%">                
                <?php
                if (!empty($empleado['Empleado']['TELEMERGENCIA'])) {
                    echo $empleado['Empleado']['TELEMERGENCIA'];
                } else {
                    echo "No especificado";
                }
                ?>                
            </div>
            
            
        </div>   
    </div>
</div>

<div class="box">
    <div class="title"><h2>Acciones</h2>
                <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">       
        <div class="row boton">
            <div class="boton">
<?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>

            </div>
        </div>
    </div>
</div>