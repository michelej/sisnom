<?php 

class Grupo extends AppModel{
    
    var $name = 'Grupo';
    var $displayField = 'NOMBRE';
    var $actsAs = 'Containable';
    /**
     *  Relaciones
     */
    var $hasMany = 'Empleado';
    
    function verificar(){
        $this->data=array(
            '1'=>array('id'=>'1','NOMBRE'=>'Empleado'),
            '2'=>array('id'=>'2','NOMBRE'=>'Obrero'),            
        );
        // La misma Validacion que se hizo en Asignacion y Deduccion para verificar
        // que los valores de la tabla siempre sean los que estan aqui declarados
        $data = $this->query("SELECT * FROM grupos as Grupo");
        $result = Set::combine($data, '{n}.Grupo.id', '{n}.Grupo');
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
    
    function beforeFind($queryData) {
        $this->verificar();
        return $queryData;
    }
}
?>