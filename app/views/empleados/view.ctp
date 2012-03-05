<div class="box big ">
    <div class="title"><h2>Datos Personales</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Nombres '); ?>
            <?php echo $empleado['Empleado']['NOMBRE']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Apellidos '); ?>
            <?php echo $empleado['Empleado']['APELLIDO']; ?>
            <?php echo "</div>"; ?>

        </div>
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Cedula '); ?>
            <?php echo $empleado['Empleado']['CEDULA']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Nacionalidad '); ?>
            <?php echo $empleado['Empleado']['NACIONALIDAD']; ?>    
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Sexo '); ?>
            <?php echo $empleado['Empleado']['SEXO']; ?>  
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Edad '); ?>
            <?php echo $edad; ?>
            <?php echo "</div>"; ?>
        </div>
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Estado Civil'); ?>
            <?php echo $empleado['Empleado']['EDOCIVIL']; ?>             
            
<?php echo "</div>"; ?>
        </div>
    </div>
</div>
<div class="box small ">
    <div class="title"><h2>Foto</h2>
<?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
        </div>
    </div>
</div>

<div class="box">
    <div class="title"><h2>Datos de Contacto</h2>
<?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Direccion'); ?>
            <?php echo $empleado['Empleado']['DIRECCION']; ?>
<?php echo "</div>"; ?>

        </div>
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Telefono Residencial '); ?>
            <?php echo $empleado['Empleado']['TELEFONO']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Telefono Celular '); ?>
            <?php echo $empleado['Empleado']['CELULAR']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Correo Electronico '); ?>
            <?php echo $empleado['Empleado']['EMAIL']; ?>
<?php echo "</div>"; ?>

        </div>
    </div>
</div>

<div class="box">
    <div class="title"><h2>Datos de Laborales</h2>
<?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Cargo '); ?>
            <?php //echo $empleado['Cargo']['DESCRIPCION']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Fecha de Ingreso '); ?>
            <?php echo $empleado['Empleado']['INGRESO']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Banco '); ?>
            <?php echo $empleado['Empleado']['BANCO']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Numero de Cuenta Bancaria '); ?>
            <?php echo $empleado['Empleado']['NCUENTA']; ?>
<?php echo "</div>"; ?>
        </div>   
    </div>
</div>