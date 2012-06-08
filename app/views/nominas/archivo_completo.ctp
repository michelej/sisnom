<?php 
echo $this->element('nomina_excel');
$nomina_sheet = $excel->sheet->getSheetByName('Nomina');
$excel->sheet->getActiveSheet()->setTitle('Resumen-1');
$sheet = clone $nomina_sheet;   

echo $this->element('nomina_excel');
$nomina_sheet2 = $excel->sheet->getSheetByName('Nomina');
$excel->sheet->getActiveSheet()->setTitle('Resumen-2');
$sheet2 = clone $nomina_sheet2;   

echo $this->element('nomina_excel');
$excel->_addExternalSheet($sheet);
$excel->_addExternalSheet($sheet2);

$excel->_output('Nomina');

?>