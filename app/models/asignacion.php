<?php

class Asignacion extends AppModel {

    var $name = 'Asignacion';
    var $displayField = 'DESCRIPCION';

    
    
    function beforeFind(){
        $this->verificarAsignaciones();
        return true;
    }

    
    function verificarAsignaciones() {
        $this->data = array(
            'Asignacion' => array(
                '0' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijo menor a 18 años', 'VALOR' => '12'),
                '1' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijo mayor a 18 años estudiando T.S.U', 'VALOR' => '15'),
                '2' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijo mayor 18 Estudiando Pre-grado', 'VALOR' => '18'),
                '3' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijos Invalidez', 'VALOR' => '15'),
                '4' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Transporte', 'VALOR' => '60'),
                '5' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Antiguedad', 'VALOR' => '12.3'),
                '6' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización T.S.U', 'VALOR' => '100'),
                '7' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Universitario', 'VALOR' => '200'),
                '8' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Post-Grado', 'VALOR' => '100'),
                '9' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Maestria', 'VALOR' => '200'),
                '10' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Doctorado', 'VALOR' => '300'),
                '11' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Reconocimiento', 'VALOR' => '12'),
                '12' => array('GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Hogar', 'VALOR' => '12'),
                '13' => array('GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo menor a 18 años', 'VALOR' => '1.8'),
                '14' => array('GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo mayor a 18 años estudiando T.S.U', 'VALOR' => '2.5'),
                '15' => array('GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo mayor a 18 años estudiando Pre-Grado', 'VALOR' => '3.5'),
                '16' => array('GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo Invalidez', 'VALOR' => '5'),
                '17' => array('GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte (Diarios)', 'VALOR' => '0.26'),
                '18' => array('GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte Mensajeros(Diarios)', 'VALOR' => '4.16'),
                '19' => array('GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Antiguedad', 'VALOR' => '0.5'),
                '20' => array('GRUPO' => 'Todos', 'DESCRIPCION' => 'Bono Nocturno', 'VALOR' => '0.3'),
            ),
        );

        $data = $this->find('all');       
        if (empty($data)) {
            $this->saveAll($this->data['Asignacion']);            
        } else {            
            // Si son diferentes alguien se metio con la tabla!! 
            if ($data!=$this->data) { 
              // truncamos la tabla para poder usar los id como identificadores OJO
              $this->query('TRUNCATE asignaciones'); 
              $this->saveAll($this->data['Asignacion']);  
            }
        }
    }
}
?>
