<?php 

$excel->_cargarTemplate("Template1.xls");
echo $this->element('nomina_excel');
echo $this->element('resumen_excel');
echo $this->element('recibo_excel');
$excel->_activeSheet('Nomina');
$excel->_output('Nomina');

?>