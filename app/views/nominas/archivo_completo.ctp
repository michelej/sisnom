<?php 
echo $this->element('resumen_excel');
$nomina_sheet = $excel->sheet->getSheetByName('Resumen');
$sheet = clone $nomina_sheet;
   

echo $this->element('nomina_excel');
$excel->sheet->addExternalSheet($sheet);


$excel->_output('Nomina');
?>