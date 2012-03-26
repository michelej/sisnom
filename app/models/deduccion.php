<?php

class Deduccion extends AppModel {

    var $name = 'Deduccion';
    var $displayField = 'DESCRIPCION';
    
     /**
     *  Relaciones
     */    
    
    var $hasAndBelongsToMany = 'Empleado';
    
    /**
     *
     * @param type $queryData
     * @return boolean 
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
            '1' => array('id' => '1', 'CODIGO' => 'S.S.O', 'DESCRIPCION' => 'Seguro Social Obligatorio', 'PORCENTAJE' => '4%'),
            '2' => array('id' => '2', 'CODIGO' => 'R.P.E', 'DESCRIPCION' => 'Régimen Prestacional de Empleo ', 'PORCENTAJE' => '0.5%'),
            '3' => array('id' => '3', 'CODIGO' => 'FAOV', 'DESCRIPCION' => 'Fondo de Ahorro Obligatirio de Vivienda', 'PORCENTAJE' => '1%'),
            '4' => array('id' => '4', 'CODIGO' => 'F.P', 'DESCRIPCION' => 'Fondo de Pensiones', 'PORCENTAJE' => '3%'),
            '5' => array('id' => '5', 'CODIGO' => 'C.A', 'DESCRIPCION' => 'Caja de Ahorros', 'PORCENTAJE' => '10%'),
            '6' => array('id' => '6', 'CODIGO' => 'T', 'DESCRIPCION' => 'Tribunales', 'PORCENTAJE' => ''),
            '7' => array('id' => '7', 'CODIGO' => 'DC', 'DESCRIPCION' => 'Deducciones Comerciales', 'PORCENTAJE' => ''),
            '8' => array('id' => '8', 'CODIGO' => 'PC', 'DESCRIPCION' => 'Prestamo Caja de Ahorros', 'PORCENTAJE' => ''),
            '9' => array('id' => '9', 'CODIGO' => 'ISLR', 'DESCRIPCION' => 'Declaracion impuesto sobre la renta', 'PORCENTAJE' => ''),
        );

        // Para que esto funcione debemos de convertir lo que traigamos del query
        // en algo parecido a lo que tenemos arriba
        // no podemos usar find aqui porque se crea un loop infinito ya que esta funcion
        // es invocada desde el beforeFind
        $data = $this->query("SELECT * FROM deducciones as Deduccion");
        $result = Set::combine($data, '{n}.Deduccion.id', '{n}.Deduccion');
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