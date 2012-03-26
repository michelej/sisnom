<?php

class Asignacion extends AppModel {

    var $name = 'Asignacion';
    var $displayField = 'DESCRIPCION';    
    
    /**
     *  Relaciones
     */    
    
    var $hasAndBelongsToMany = 'Empleado';
    
    /**
     *
     *      
     */    
    function beforeFind($queryData) {
        $this->verificar();
        return true;
    }

    /**
     *  Verifica si los datos en la tabla son iguales a los que estan aqui declarados
     *  la idea es trabajar todo desde aqui (el Modelo) si se quiere agregar algo se hace 
     *  desde aqui. 
     *            
     *  El (id) es importante se usa para saber que tipo se va a usar
     */
    function verificar() {
        $this->data = array(
            '1' => array('id' => '1', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijo'),            
            '2' => array('id' => '2', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Transporte'),
            '3' => array('id' => '3', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Antiguedad'),
            '4' => array('id' => '4', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Reconocimiento'),
            '5' => array('id' => '5', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Nivelacion Profesional'),                        
            '6' => array('id' => '6', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Hogar'),
            '7' => array('id' => '7', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo'),            
            '8' => array('id' => '8', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte'),            
            '9' => array('id' => '9', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Antiguedad'),
            '10' => array('id' => '10', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Reconocimiento'),
            '11' => array('id' => '11', 'GRUPO' => 'Todos', 'DESCRIPCION' => 'Bono Nocturno'),
        );

        // Para que esto funcione debemos de convertir lo que traigamos del query
        // en algo parecido a lo que tenemos arriba
        // no podemos usar find aqui porque se crea un loop infinito ya que esta funcion
        // es invocada desde el beforeFind
        $data = $this->query("SELECT * FROM asignaciones as Asignacion");
        $result = Set::combine($data, '{n}.Asignacion.id', '{n}.Asignacion');
        // buscamos las diferencias
        $diff = array_diff_key($result, $this->data);
        // si no encuentro nada lo creamos con los valores default
        if (empty($data)) {
            $this->saveAll($this->data);
        } else {
            // Si son diferentes los regrabamos            
            if ($result != $this->data) {
                $this->saveAll($this->data);                
                if (!empty($diff)) {
                    // Borramos aquellos que hayan sido agregados en la BD y no esten declaradas aqui
                    foreach ($diff as $value) {                        
                        $this->delete($id = $value['id']);
                    }
                }
            }
        }
    }
}
?>