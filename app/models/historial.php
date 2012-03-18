<?php

class Historial extends AppModel {

    var $name = 'Historial';
    var $displayField = 'SUELDO_BASE';
    var $errorMessage='';
    
    /**
     *  Relaciones
     */
    var $belongsTo = 'Cargo';
     /**
     *  Validaciones
     */
   /* var $validate = array(
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha incorrecta',
        ),
        'SUELDO_BASE' => array(        
            'rule' => array('decimal', 2),
            'message' => 'Sueldo base invalido',
        )
     );*/
    
    
    /**
     *
     * @return boolean 
     */
    function beforeSave() { 
        $fecha_ini=$this->data['Historial']['FECHA_INI'];
        $fecha_fin=$this->data['Historial']['FECHA_FIN'];        
        if($fecha_fin==NULL){
            $this->data['Historial']['FECHA_FIN']=NULL;
        }
        
        $this->recursive = -1;
        // buscamos los historiales de sueldo de este cargo
        $historiales = $this->findAllByCargoId($this->data['Historial']['cargo_id']);        
        $result = Set::combine($historiales, '{n}.Historial.id', '{n}.Historial');
                
        if (!$this->validacionFechas($fecha_ini,$fecha_fin,$result,"historiales")) {                        
            return false;
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

    /*function validacionFechas() {
        // Ojo las fechas que terminan en NULL se consideran como PRESENTE solo existe una ,
        // ademas no se permite crear rangos futuros a la fecha obtenida con date()
        // 
        
        // Buscamos todos los Historiales de este cargo
        $this->recursive = -1;
        $historiales = $this->findAllByCargoId($this->data['Historial']['cargo_id']);

        $fecha_ini = $this->data['Historial']['FECHA_INI'];
        $fecha_fin = $this->data['Historial']['FECHA_FIN'];

        $hoy = date("d-m-Y");
        // Si la nueva fecha final es null quiere decir que estamos tratando con rango de sueldos actual
        if ($fecha_fin == null) {
            $fecha_fin = $hoy;  // declaramos la fecha final como la de hoy
            $actual = TRUE;    // estamos trabajando con un nuevo rango actual
            $this->data['Historial']['FECHA_FIN'] = NULL;  // null para la base de datos
        } else {
            $actual = FALSE;  // es un rango de fechas normal
        }

        // Verificar que fecha final sea mayor a fecha inicial , valides del rango
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

                //si la fecha del historial es null estamos tratando con un rango actual                
                // idealmente solo existe uno y es el ultimo
                if ($fecha_f == NULL) {
                    $fecha_f = $hoy;
                    // si quiero crear un nuevo rango actual y ya tengo uno en historial
                    if ($actual) {
                        // la nueva fecha actual debe estar dentro del rango de la fecha actual que existe
                        // en el historial de lo contrario no nos sirve
                        if (check_in_range($fecha_i, $fecha_f, $fecha_ini)) {
                            $fecha = formatoFechaBeforeSave($fecha_ini);
                            // buscamos la fecha inicial y le restamos 1 day para formar la nueva fecha final
                            // del historial anterior
                            $fecha_new = date("Y-m-d", strtotime($fecha . "-1 days"));
                            $id = $historial['Historial']['id'];
                            $this->query("update historiales set FECHA_FIN='" . $fecha_new . "' where id='" . $id . "'");
                            return true; // listo OJO idealmente el ultimo rango es el que tiene NULL en su fecha final
                        } else {
                            return false;
                        }
                     // si no estoy creando un rango actual , osea un rango normal
                    } else {
                        if ($fecha_ini > $fecha_i) {
                            $fecha = formatoFechaBeforeSave($fecha_ini);
                            // buscamos la fecha inicial y le restamos 1 day para formar la nueva fecha final
                            // del historial anterior
                            $fecha_new = date("Y-m-d", strtotime($fecha . "-1 days"));
                            $id = $historial['Historial']['id'];
                            $this->query("update historiales set FECHA_FIN='" . $fecha_new . "' where id='" . $id . "'");
                            return true;
                        }
                    }
                } else {
                    // simplemente no se pueden solapar los rangos
                    if (check_in_range($fecha_i, $fecha_f, $fecha_ini) || check_in_range($fecha_i, $fecha_f, $fecha_fin)) {
                        return false;
                    }
                }

                // el nuevo rango de fechas no puede contener a ninguno de los rangos que ya existen
                if (check_in_range($fecha_ini, $fecha_fin, $fecha_i) || check_in_range($fecha_ini, $fecha_fin, $fecha_f)) {
                    return false;
                }
            }
        }
        // si pasamos todos las verificaciones damos la luz verde
        return true;
    }*/
    
}

?>
