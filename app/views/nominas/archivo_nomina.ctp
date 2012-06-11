<?php

//           /view/elements/nomina_excel
$excel->_cargarTemplate("Template1.xls");
$excel->_removeSheet(1);
echo $this->element('nomina_excel');
$excel->_output('Nomina');
?>