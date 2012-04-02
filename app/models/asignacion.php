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
            '1' => array('id' => '1', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Reconocimiento'),
            '2' => array('id' => '2', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Hogar'),
            '3' => array('id' => '3', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Antiguedad'),
            '4' => array('id' => '4', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Transporte'),
            '5' => array('id' => '5', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijos'),
            '6' => array('id' => '6', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Nivelacion Profesional'),
            '7' => array('id' => '7', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Reconocimiento'),
            '8' => array('id' => '8', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Antiguedad'),
            '9' => array('id' => '9', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte'),
            '10' => array('id' => '10', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijos'),
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

    /**
     * Calcular las Asignaciones de un Empleado para una Nomina especifica
     * @param type 
     */
    function calcularAsignaciones($id_nomina, $grupo, $id_empleado) {
        // Buscamos todas las asignaciones de este grupo
        $data = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'GRUPO' => $grupo
            )
                ));        

        // Revisamos a ver si el empleado tiene cada una de las asignaciones
        foreach ($data as $value) {
            if($this->empleadoTieneAsignacion($id_empleado,$value['Asignacion']['id'])){
                echo "BIEN-".$value['Asignacion']['id'];
            }else{
                echo "MAL-".$value['Asignacion']['id'];
            }
                
        }


        
        foreach ($empleado['Asignacion'] as $asignacion) {
            switch ($asignacion['id']) {
                case "1":
                    $asignaciones[] = array('id' => 1, 'VALOR' => 111);
                    break;
                case "2":
                    $asignaciones[] = array('id' => 2, 'VALOR' => 222);
                    break;
                case "3":
                    $asignaciones[] = array('id' => 3, 'VALOR' => 333);
                    break;
                case "4":
                    $asignaciones[] = array('id' => 4, 'VALOR' => 444);
                    break;
                case "5":
                    $asignaciones[] = array('id' => 5, 'VALOR' => 555);
                    break;
                case "6":
                    $asignaciones[] = array('id' => 6, 'VALOR' => 666);
                    break;
                case "7":
                    $asignaciones[] = array('id' => 7, 'VALOR' => 777);
                    break;
                case "8":
                    $asignaciones[] = array('id' => 8, 'VALOR' => 888);
                    break;
                case "9":
                    $asignaciones[] = array('id' => 9, 'VALOR' => 999);
                    break;
                case "10":
                    $asignaciones[] = array('id' => 10, 'VALOR' => 101010);
                    break;

                default:
                    $asignaciones[] = array();
                    break;
            }
        }
        return $asignaciones;
    }

    /**
     * Verificamos si un Empleado posee una Asignacion
     * @param type $empleado
     * @param type $asignacion 
     */
    function empleadoTieneAsignacion($id_empleado, $id_asignacion) {
        $empleado = $this->Empleado->find("first", array(
            'conditions' => array(
                'id' => $id_empleado
            ),
            'contain' => array(
                'Asignacion' => array(
                    'conditions' => array(
                        'id' => $id_asignacion
                    )
                )
            )
                ));
        if(empty($empleado)){
            return false;
        }else{
            return true;
        }
    }
    /**
     * Realiza el calculo de una asignacion especifica para un empleado
     * @param type $id_empleado
     * @param type $id_asignacion 
     */
    
    function realizarCalculo($id_empleado,$id_asignacion){
        
    }

}

?>