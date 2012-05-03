<?php

$tamTexto=10;
$estiloTexto='Arial';

$excel->_anchoColumna('A',5);
$excel->_campo('A15',"Nro");
$excel->_texto('A15',$tamTexto,$estiloTexto);

$nombre='nomina';
$excel->_output($nombre);
?> 
