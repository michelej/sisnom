<?php

class Familiar extends AppModel {

    var $name = 'Familiar';
    var $displayField = 'NOMBRE';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Empleado';
    /**
     *   Validaciones   
     */
    var $validate = array( 
        'NOMBRE' => array(
            'rule' => 'notEmpty',
            'message' => 'Ingrese el Nombre'
        ),
        'FECHA' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'FECHA_EFEC' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'DISCAPACIDAD' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una Opcion'
        ),
        'INSTRUCCION' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una Opcion'
        ),
        'PARENTESCO' => array(
            'rule' => 'notEmpty',
            'message' => 'Seleccione una Opcion'
        ),
        
    );
    /**
     *
     * @return boolean 
     */
    function beforeSave() {
        if (!empty($this->data['Familiar']['FECHA'])) {
            $this->data['Familiar']['FECHA'] = formatoFechaBeforeSave($this->data['Familiar']['FECHA']);
        }
        if (!empty($this->data['Familiar']['FECHA_EFEC'])) {
            $this->data['Familiar']['FECHA_EFEC'] = formatoFechaBeforeSave($this->data['Familiar']['FECHA_EFEC']);
        }
        return true;
    }
    /**
     *
     * @param type $results
     * @return type 
     */
    function afterFind($results) {        
        foreach ($results as $key => $val) {
            if (!isset($val['Familiar'])) {
                if (isset($val['FECHA'])) {
                    $results[$key]['FECHA'] = formatoFechaAfterFind($val['FECHA']);
                    $results[$key]['EDAD_FAMILIAR'] = $this->Edad($results[$key]['FECHA']);
                }
                if (isset($val['FECHA_EFEC'])) {
                    $results[$key]['FECHA_EFEC'] = formatoFechaAfterFind($val['FECHA_EFEC']);
                }
            }
            if (isset($val['Familiar']['FECHA'])) {
                $results[$key]['Familiar']['FECHA'] = formatoFechaAfterFind($val['Familiar']['FECHA']);
                $results[$key]['Familiar']['EDAD_FAMILIAR'] = $this->Edad($results[$key]['Familiar']['FECHA']);
            }
            if (isset($val['Familiar']['FECHA_EFEC'])) {
                $results[$key]['Familiar']['FECHA_EFEC'] = formatoFechaAfterFind($val['Familiar']['FECHA_EFEC']);
            }
        }
        return $results;
    }
    
    function Edad($fechanac) {        
        list($dia, $mes, $ano) = explode("-", $fechanac);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }

}
?>