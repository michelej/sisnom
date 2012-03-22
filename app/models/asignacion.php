<?php

class Asignacion extends AppModel {

    var $name = 'Asignacion';
    var $displayField = 'DESCRIPCION';

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
            '1' => array('id' => '1', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijo menor a 18', 'VALOR' => '12'),
            '2' => array('id' => '2', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijo mayor a 18 estudiando T.S.U', 'VALOR' => '15'),
            '3' => array('id' => '3', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijo mayor 18 Estudiando Pre-grado', 'VALOR' => '18'),
            '4' => array('id' => '4', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijos Invalidez', 'VALOR' => '15'),
            '5' => array('id' => '5', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Transporte', 'VALOR' => '60'),
            '6' => array('id' => '6', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Antiguedad', 'VALOR' => '12.3'),
            '7' => array('id' => '7', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización T.S.U', 'VALOR' => '100'),
            '8' => array('id' => '8', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Universitario', 'VALOR' => '200'),
            '9' => array('id' => '9', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Post-Grado', 'VALOR' => '100'),
            '10' => array('id' => '10', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Maestria', 'VALOR' => '200'),
            '11' => array('id' => '11', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Profesionalización Doctorado', 'VALOR' => '300'),
            '12' => array('id' => '12', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Reconocimiento', 'VALOR' => '12'),
            '13' => array('id' => '13', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Hogar', 'VALOR' => '12'),
            '14' => array('id' => '14', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo menor a 18', 'VALOR' => '1.8'),
            '15' => array('id' => '15', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo mayor a 18 estudiando T.S.U', 'VALOR' => '2.5'),
            '16' => array('id' => '16', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo mayor a 18 estudiando Pre-Grado', 'VALOR' => '3.5'),
            '17' => array('id' => '17', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijo Invalidez', 'VALOR' => '5'),
            '18' => array('id' => '18', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte (Diarios)', 'VALOR' => '0.26'),
            '19' => array('id' => '19', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte Mensajeros(Diarios)', 'VALOR' => '4.16'),
            '20' => array('id' => '20', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Antiguedad', 'VALOR' => '0.5'),
            '21' => array('id' => '21', 'GRUPO' => 'Todos', 'DESCRIPCION' => 'Bono Nocturno', 'VALOR' => '0.3'),
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
                    foreach ($diff as $value) {
                        // Borramos aquellos que hayan sido agregados en la BD y no esten declaradas aqui
                        $this->delete($id = $value['id']);
                    }
                }
            }
        }
    }

}

?>
