<?php

class Deduccion extends AppModel {

    var $name = 'Deduccion';
    var $displayField = 'DESCRIPCION';

    
    
    function beforeFind(){
        $this->verificarDeducciones();
        return true;
    }

    
    function verificarDeducciones() {
        $this->data = array(
            'Deduccion' => array(
                '0' => array('CODIGO' => 'S.S.O', 'DESCRIPCION' => 'Seguro Social Obligatorio', 'PORCENTAJE' => '4'),
                '1' => array('CODIGO' => 'R.P.E', 'DESCRIPCION' => 'Régimen Prestacional de Empleo ', 'PORCENTAJE' => '0.5'),
                '2' => array('CODIGO' => 'FAOV', 'DESCRIPCION' => 'Fondo de Ahorro Obligatirio de Vivienda', 'PORCENTAJE' => '1'),
                '3' => array('CODIGO' => 'F.P', 'DESCRIPCION' => 'Fondo de Pensiones', 'PORCENTAJE' => '3'),
                '4' => array('CODIGO' => 'C.A', 'DESCRIPCION' => 'Caja de Ahorros', 'PORCENTAJE' => '10'),
                '5' => array('CODIGO' => 'T', 'DESCRIPCION' => 'Tribunales', 'PORCENTAJE' => '0'),
                '6' => array('CODIGO' => 'DC', 'DESCRIPCION' => 'Deducciones Comerciales', 'PORCENTAJE' => '0'),
                '7' => array('CODIGO' => 'PC', 'DESCRIPCION' => 'Prestamo Caja de Ahorros', 'PORCENTAJE' => '0'),
                '8' => array('CODIGO' => 'ISLR', 'DESCRIPCION' => 'Declaracion impuesto sobre la renta', 'PORCENTAJE' => '0'),                
            ),
        );

        $data = $this->find('all');       
        if (empty($data)) {
            $this->saveAll($this->data['Deduccion']);            
        } else {            
            // Si son diferentes alguien se metio con la tabla!! 
            if ($data!=$this->data) { 
              // truncamos la tabla para poder usar los id como identificadores OJO
              $this->query('TRUNCATE deducciones'); 
              $this->saveAll($this->data['Deduccion']);  
            }
        }
    }
}
?>
