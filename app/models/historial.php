<?php

class Historial extends AppModel {

    var $name = 'Historial';
    var $displayField = 'SUELDO_BASE';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Cargo';

    // TODO : Faltan los errores
    function beforeSave() {
        $this->recursive = -1;
        $historiales = $this->findAllByCargoId($this->data['Historial']['cargo_id']);

        $fecha_ini = $this->data['Historial']['FECHA_INI'];
        $fecha_fin = $this->data['Historial']['FECHA_FIN'];

        $hoy = date("d-m-Y");
        // Si fecha final es null quiere decir que estamos tratando con rango de sueldos actual
        if ($fecha_fin == null) {
            $fecha_fin = $hoy;
            $actual = TRUE;
            $this->data['Historial']['FECHA_FIN'] = NULL;
        } else {
            $actual = FALSE;
        }

        // Verificar que fecha final sea mayor a fecha inicial
        if ($fecha_ini > $fecha_fin) {
            return false;
        }
        // No se permiten fechas futuras
        if ($fecha_ini > $hoy) {
            return false;
        }


        // Verificar si alguna de las fecha se encuentra en el rango de alguna ya existente
        if (!empty($historiales)) {
            foreach ($historiales as $historial) {
                $fecha_i = $historial['Historial']['FECHA_INI'];
                $fecha_f = $historial['Historial']['FECHA_FIN'];

                if ($fecha_f == NULL) {
                    $fecha_f = $hoy;

                    if ($actual) {                        
                        if (!check_in_range($fecha_i, $fecha_f, $fecha_ini)) {
                            return false;
                        }else{
                           // Eliminar el historial y ponerle en la fecha final la fecha inicial de este -1 
                        }
                    }
                } else {
                    if (check_in_range($fecha_i, $fecha_f, $fecha_ini)) {
                        return false;
                    }
                    if (check_in_range($fecha_i, $fecha_f, $fecha_fin)) {
                        return false;
                    }
                }
            }
        }

        if (!empty($this->data['Historial']['FECHA_INI'])) {
            $this->data['Historial']['FECHA_INI'] = $this->formatoFechaBeforeSave($this->data['Historial']['FECHA_INI']);
        }
        if (!empty($this->data['Historial']['FECHA_FIN'])) {
            $this->data['Historial']['FECHA_FIN'] = $this->formatoFechaBeforeSave($this->data['Historial']['FECHA_FIN']);
        }

        return true;
    }

    function afterFind($results) {
        foreach ($results as $key => $val) {
            if (isset($val['Historial']['FECHA_INI'])) {
                $results[$key]['Historial']['FECHA_INI'] = $this->formatoFechaAfterFind($val['Historial']['FECHA_INI']);
            }
            if (isset($val['Historial']['FECHA_FIN'])) {
                $results[$key]['Historial']['FECHA_FIN'] = $this->formatoFechaAfterFind($val['Historial']['FECHA_FIN']);
            }
        }
        return $results;
    }

    function formatoFechaAfterFind($cadenaFecha) {
        return date('d-m-Y', strtotime($cadenaFecha));
    }

    function formatoFechaBeforeSave($cadenaFecha) {
        return date('Y-m-d', strtotime($cadenaFecha)); // Direction is from
    }

}

?>
