<?php

//           /view/elements/nomina_excel
$excel->_cargarTemplate("Template2.xls");
echo $this->element('cestaticket_excel');
$excel->_output('Cestaticket');
?>