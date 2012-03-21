<?php

class Historial extends AppModel {

    var $name = 'Historial';
    var $displayField = 'SUELDO_BASE';
    var $errorMessage = '';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Cargo';

    /**
     *  Validaciones
     */
    var $validate = array(
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Inicial incorrecta',
        ),
        'SUELDO_BASE' => array(
            'rule' => array('decimal'),
            'message' => 'Sueldo Base invalido ( ejm: 1500.00)',
        ),
    );

    // TODO: Falta validar la fecha final 
    /**
     *
     * @return boolean 
     */
    function beforeSave() {
        $fecha_ini = $this->data['Historial']['FECHA_INI'];
        $fecha_fin = $this->data['Historial']['FECHA_FIN'];
        $fecha_ret = $this->data['Historial']['FECHA_RET'];
                
        if ($fecha_fin == NULL) {
            $this->data['Historial']['FECHA_FIN'] = NULL;            
        }

        $this->recursive = -1;
        // buscamos los historiales de sueldo de este cargo
        $historiales = $this->findAllByCargoId($this->data['Historial']['cargo_id']);
        $result = Set::combine($historiales, '{n}.Historial.id', '{n}.Historial');

        if (!$this->validacionFechas($fecha_ini, $fecha_fin, $result, "historiales")) {
            return false;
        }
        
        if ($fecha_ret == null) {
            $this->data['Historial']['FECHA_RET'] = NULL;
        } else {
            if (compara_fechas($fecha_ini, $fecha_ret) < 0) {
                $this->errorMessage = "La fecha retroactiva debe ser menor a la fecha inicial";
                return false;
            }                        
        }


        //Tratamos las fechas
        if (!empty($this->data['Historial']['FECHA_INI'])) {
            $this->data['Historial']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Historial']['FECHA_INI']);
        }
        if (!empty($this->data['Historial']['FECHA_FIN'])) {
            $this->data['Historial']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Historial']['FECHA_FIN']);
        }
        if (!empty($this->data['Historial']['FECHA_RET'])) {
            $this->data['Historial']['FECHA_RET'] = formatoFechaBeforeSave($this->data['Historial']['FECHA_RET']);
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
            if (isset($val['Historial']['FECHA_INI'])) {
                $results[$key]['Historial']['FECHA_INI'] = formatoFechaAfterFind($val['Historial']['FECHA_INI']);
            }
            if (isset($val['Historial']['FECHA_FIN'])) {
                $results[$key]['Historial']['FECHA_FIN'] = formatoFechaAfterFind($val['Historial']['FECHA_FIN']);
            }
            if (isset($val['Historial']['FECHA_RET'])) {
                $results[$key]['Historial']['FECHA_RET'] = formatoFechaAfterFind($val['Historial']['FECHA_RET']);
            }
        }
        return $results;
    }

}

?>
