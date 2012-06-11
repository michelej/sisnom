<?php

//           /view/elements/resumen_excel
$excel->_cargarTemplate("Template1.xls");
$excel->_removeSheet(0);
echo $this->element('resumen_excel');
$excel->_output('Nomina');
?>