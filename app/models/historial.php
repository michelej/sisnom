<?php

class Historial extends AppModel {

    var $name = 'Historial';
    var $displayField = 'SUELDO_BASE';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Cargo';

    // TODO : Faltan los errores
    /**
     *
     * @return boolean 
     */
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
        // Si existe algun historial se hacen varios chequeos 
        if (!empty($historiales)) {
            foreach ($historiales as $historial) {
                $fecha_i = $historial['Historial']['FECHA_INI'];
                $fecha_f = $historial['Historial']['FECHA_FIN'];

                if ($fecha_f == NULL) {
                    $fecha_f = $hoy;
                    // si es un nuevo rango actual , osea un rango con fecha_fin = null
                    if ($actual) {
                        if (!check_in_range($fecha_i, $fecha_f, $fecha_ini)) {
                            return false;
                        } else {
                            $fecha = formatoFechaBeforeSave($fecha_ini);
                            // buscamos la fecha inicial y le restamos 1 day para formar la nueva fecha final
                            // del historial anterior
                            $fecha_new = date("Y-m-d", strtotime($fecha . "-1 days"));
                            $id = $historial['Historial']['id'];
                            $this->query("update historiales set FECHA_FIN='" . $fecha_new . "' where id='" . $id . "'");
                        }
                    } else {
                        $fecha = formatoFechaBeforeSave($fecha_ini);
                        // buscamos la fecha inicial y le restamos 1 day para formar la nueva fecha final
                        // del historial anterior
                        $fecha_new = date("Y-m-d", strtotime($fecha . "-1 days"));
                        $id = $historial['Historial']['id'];
                        $this->query("update historiales set FECHA_FIN='" . $fecha_new . "' where id='" . $id . "'");
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
        
        //Tratamos las fechas
        if (!empty($this->data['Historial']['FECHA_INI'])) {
            $this->data['Historial']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Historial']['FECHA_INI']);
        }
        if (!empty($this->data['Historial']['FECHA_FIN'])) {
            $this->data['Historial']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Historial']['FECHA_FIN']);
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
        }
        return $results;
    }

}

?>
