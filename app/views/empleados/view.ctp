<div class="box big ">
<div class="title"><h2>Datos Personales</h2>
<?php echo $this->Html->image("title-hide.gif",array('class'=>'toggle')); ?>
</div>
<div class="content forms">
<div class="row">
       <?php echo "<div style='float:left;width:25%'>";?>
       <?php echo $this->Form->label('Primer Nombre '); ?>
       <?php echo $empleado['Empleado']['EMP_PNOMBRE']; ?>
       <?php echo "</div>"; ?>
       <?php echo "<div style='float:left;width:25%'>";?>
       <?php echo $this->Form->label('Segundo Nombre '); ?>
       <?php echo $empleado['Empleado']['EMP_SNOMBRE']; ?>
       <?php echo "</div>"; ?>
       <?php echo "<div style='float:left;width:25%'>";?>
       <?php echo $this->Form->label('Primer Apellido '); ?>
       <?php echo $empleado['Empleado']['EMP_PAPELLIDO']; ?>
       <?php echo "</div>"; ?>
       <?php echo "<div style='float:left;width:25%'>";?>
       <?php echo $this->Form->label('Segundo Apellido '); ?>
       <?php echo $empleado['Empleado']['EMP_SAPELLIDO']; ?>
       <?php echo "</div>"; ?>
</div>
<div class="row">
	  <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Cedula '); ?>
      <?php echo $empleado['Empleado']['EMP_CEDULA']; ?>
      <?php echo "</div>"; ?>
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Nacionalidad '); ?>
      <?php if($empleado['Empleado']['EMP_NACIONALIDAD']==0)
	  				echo "Venezolana";
						else
					echo "Extranjera"; 
					?>
      <?php echo "</div>"; ?>
       <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Sexo '); ?>
      <?php if ($empleado['Empleado']['EMP_SEXO']==0 )
	  				echo "Masculino";
						else
					echo "Femenino"; ?>
      <?php echo "</div>"; ?>
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Edad '); ?>
      <?php echo $edad; ?>
      <?php echo "</div>"; ?>
</div>
<div class="row">
	  <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Estado Civil'); ?>
      <?php 
	        $opcionEdoCivil=array('0'=>'Soltero(a)','1'=>'Casado(a)','2'=>'Viudo(a)','3'=>'Divorciado(a)','4'=>'Concubinato');  
	        echo $opcionEdoCivil[$empleado['Empleado']['EMP_EDOCIVIL']]; ?>
      <?php echo "</div>"; ?>
</div>
</div>
</div>
<div class="box small ">
<div class="title"><h2>Foto</h2>
<?php echo $this->Html->image("title-hide.gif",array('class'=>'toggle')); ?>
</div>
<div class="content forms">
<div class="row">
</div>
</div>
</div>

<div class="box">
<div class="title"><h2>Datos de Contacto</h2>
<?php echo $this->Html->image("title-hide.gif",array('class'=>'toggle')); ?>
</div>
<div class="content forms">
<div class="row">
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Direccion'); ?>
      <?php echo $empleado['Empleado']['EMP_DIRECCION']; ?>
      <?php echo "</div>"; ?>

</div>
<div class="row">
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Telefono Residencial '); ?>
      <?php echo $empleado['Empleado']['EMP_TELEFONO']; ?>
      <?php echo "</div>"; ?>
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Telefono Celular '); ?>
      <?php echo $empleado['Empleado']['EMP_CELULAR']; ?>
      <?php echo "</div>"; ?>
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Correo Electronico '); ?>
      <?php echo $empleado['Empleado']['EMP_EMAIL']; ?>
      <?php echo "</div>"; ?>

</div>
</div>
</div>

<div class="box">
<div class="title"><h2>Datos de Laborales</h2>
<?php echo $this->Html->image("title-hide.gif",array('class'=>'toggle')); ?>
</div>
<div class="content forms">
<div class="row">
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Cargo '); ?>
      <?php echo $empleado['Cargo']['CAR_DESCRIPCION'];?>
      <?php echo "</div>"; ?>
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Fecha de Ingreso '); ?>
      <?php echo $empleado['Empleado']['EMP_DESDE']; ?>
      <?php echo "</div>"; ?>
      <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Banco '); ?>
      <?php //echo $empleado['Empleado']['EMP_EMAIL']; ?>
      <?php echo "</div>"; ?>
       <?php echo "<div style='float:left;width:25%'>";?>
      <?php echo $this->Form->label('Numero de Cuenta Bancaria '); ?>
      <?php //echo $empleado['Empleado']['EMP_EMAIL']; ?>
      <?php echo "</div>"; ?>
</div>   
</div>
</div>
<div class="box">
<div class="title"><h2>Asignaciones</h2>
<?php echo $this->Html->image("title-hide.gif",array('class'=>'toggle')); ?>
</div>
<div class="content pages">
<div class="row">

	<table cellpadding = "0" cellspacing = "0">
     <thead>
	<tr class="even"> 
        <th>#</th>
		<th><?php __('Descripción'); ?></th>
        <th><?php __('Prima'); ?></th>
         
        
		<th class="actions"><?php __('Acciones');?></td>
	</tr>
     </thead>
	<?php
		$i = 0;
	foreach ($empleado['Asignacion'] as $asignaciones):
			$class = ' class="even"';
		if ($i++ % 2 == 0) {
			$class = ' class="odd"';
		}
		?>
		<tr<?php echo $class;?>>
			<td ><?php echo $i; ?></td>
            <td><?php echo $asignaciones['ASI_DESCRIPCION'];?></td>
            <td ><?php echo number_format($asignaciones['ASI_MONTO'],2,',','.');?></td>
            
            <td  class="actions">
			<?php
echo $this->Html->image("file_delete.png", array("alt" => "Eliminar",'title'=>'Eliminar','width' => '18', 'heigth' => '18','url' => array('controller' => 'asignaciones','action' => 'delete',  $asignaciones['id'])));
            ?> 
		</tr>
	<?php endforeach; ?>
	</table>

</div>   
</div>
</div>

<div class="box">
<div class="title"><h2>Deducciones</h2>
<?php echo $this->Html->image("title-hide.gif",array('class'=>'toggle')); ?>
</div>
<div class="content pages">
<div class="row">

	<table cellpadding = "0" cellspacing = "0">
     <thead>
	<tr class="even"> 
        <th>#</th>
		<th><?php __('Descripción'); ?></th>
        <th><?php __('Porcentaje'); ?></th>
         
        
		<th class="actions"><?php __('Acciones');?></td>
	</tr>
     </thead>
	<?php
		$i = 0;
	foreach ($empleado['Deduccion'] as $deducciones):
			$class = ' class="even"';
		if ($i++ % 2 == 0) {
			$class = ' class="odd"';
		}
		?>
		<tr<?php echo $class;?>>
			<td ><?php echo $i; ?></td>
            <td ><?php echo $deducciones['DED_DESCRIPCION'];?></td>
            <td ><?php echo number_format($deducciones['DED_MONTO'],2,',','.');?></td>
            
            <td  class="actions">
			<?php
echo $this->Html->image("file_delete.png", array("alt" => "Eliminar",'title'=>'Eliminar','width' => '18', 'heigth' => '18','url' => array('action' => 'eliminarAsignacion',  $deducciones['id'],$this->params['pass']['0'])));
            ?> 
		</tr>
	<?php endforeach; ?>
	</table>

</div>   
</div>
</div>