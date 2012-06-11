<?php 

$excel->_cargarTemplate("Template1.xls");
echo $this->element('nomina_excel');
echo $this->element('resumen_excel');
$excel->_output('Nomina');

?>