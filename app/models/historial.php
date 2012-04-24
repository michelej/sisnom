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
        if (isset($this->data['Historial']['HISTORIAL_MES_INICIO']) && isset($this->data['Historial']['HISTORIAL_AÑO_INICIO'])) {
            if (empty($this->data['Historial']['HISTORIAL_MES_INICIO']) || empty($this->data['Historial']['HISTORIAL_AÑO_INICIO'])) {
                $this->errorMessage = 'Seleccione un Mes e ingrese un valor en Año';
                return false;
            }
            if (is_numeric($this->data['Historial']['HISTORIAL_AÑO_INICIO'])) {
                if ($this->data['Historial']['HISTORIAL_AÑO_INICIO'] < 1900 || $this->data['Historial']['HISTORIAL_AÑO_INICIO'] > 2200) {
                    $this->errorMessage = "El año inicial es Invalido";
                    return false;
                }
            } else {
                $this->errorMessage = "El año inicial tiene que ser un numero";
                return false;
            }

            if (empty($this->data['Historial']['QUINCENA_INICIO'])) {
                $this->errorMessage = "Seleccione una Quincena";
                return false;
            }

            // Determinamos las fechas en base a la quincena
            //            
            if ($this->data['Historial']['QUINCENA_INICIO'] == 'Primera') {
                $this->data['Historial']['FECHA_INI'] = $this->data['Historial']['HISTORIAL_AÑO_INICIO'] . '-' . $this->data['Historial']['HISTORIAL_MES_INICIO'] . '-1';
            }
            if ($this->data['Historial']['QUINCENA_INICIO'] == 'Segunda') {
                $this->data['Historial']['FECHA_INI'] = $this->data['Historial']['HISTORIAL_AÑO_INICIO'] . '-' . $this->data['Historial']['HISTORIAL_MES_INICIO'] . '-16';
            }
            
            // Si se ingreso una fecha final
            //
            if (!empty($this->data['Historial']['HISTORIAL_MES_FIN']) && !empty($this->data['Historial']['HISTORIAL_AÑO_FIN'])
                    && !empty($this->data['Historial']['QUINCENA_FIN'])) {

                if (is_numeric($this->data['Historial']['HISTORIAL_AÑO_FIN'])) {
                    if ($this->data['Historial']['HISTORIAL_AÑO_FIN'] < 1900 || $this->data['Historial']['HISTORIAL_AÑO_FIN'] > 2200) {
                        $this->errorMessage = "El año final es Invalido";
                        return false;
                    }
                } else {
                    $this->errorMessage = "El año final tiene que ser un numero";
                    return false;
                }

                if ($this->data['Historial']['QUINCENA_FIN'] == 'Primera') {
                    $this->data['Historial']['FECHA_FIN'] = $this->data['Historial']['HISTORIAL_AÑO_FIN'] . '-' . $this->data['Historial']['HISTORIAL_MES_FIN'] . '-15';
                }
                if ($this->data['Historial']['QUINCENA_FIN'] == 'Segunda') {
                    $dia = strftime("%d", mktime(0, 0, 0, $this->data['Historial']['HISTORIAL_MES_FIN'] + 1, 0, $this->data['Historial']['HISTORIAL_AÑO_FIN']));
                    $this->data['Historial']['FECHA_FIN'] = $this->data['Historial']['HISTORIAL_AÑO_FIN'] . '-' . $this->data['Historial']['HISTORIAL_MES_FIN'] . '-' . $dia;
                }
            }else{
                $this->data['Historial']['FECHA_FIN']=null;
                $fecha_fin=null;
            }
        }        
        
        $fecha_ini = formatoFechaAfterFind($this->data['Historial']['FECHA_INI']);
        
        if ($this->data['Historial']['FECHA_FIN']!=null) {
            $fecha_fin = formatoFechaAfterFind($this->data['Historial']['FECHA_FIN']);
        }

        if (!empty($this->data['Historial']['FECHA_RET'])) {
            $fecha_ret = formatoFechaAfterFind($this->data['Historial']['FECHA_RET']);
        } else {
            $fecha_ret = null;
            $this->data['Historial']['FECHA_RET'] = NULL;
        }        
        

        $this->recursive = -1;
        // buscamos los historiales de sueldo de este cargo
        $historiales = $this->findAllByCargoId($this->data['Historial']['cargo_id']);
        $result = Set::combine($historiales, '{n}.Historial.id', '{n}.Historial');

        if (!$this->validacionFechas($fecha_ini, $fecha_fin, $result, "historiales")) {
            return false;
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