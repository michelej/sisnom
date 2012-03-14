<?php

class AppModel extends Model {

    protected $sYourPropery = 'property';

    /**
     * Es usado por el modelo historial y el de contrato
     * 
     * @return boolean 
     */
    function validacionFechas($fecha_ini, $fecha_fin, $fechas,$tabla) {
        // Ojo las fechas que terminan en NULL se consideran como PRESENTE solo existe una ,
        // ademas no se permite crear rangos futuros a la fecha obtenida con date()
        //  FECHA_INI  - FECHA_FIN 
        // Buscamos todos los Historiales de este cargo

        $hoy = date("d-m-Y");
        // Si la nueva fecha final es null quiere decir que estamos tratando con rango de sueldos actual
        if ($fecha_fin == null) {
            $fecha_fin = $hoy;  // declaramos la fecha final como la de hoy
            $actual = TRUE;    // estamos trabajando con un nuevo rango actual            
        } else {
            $actual = FALSE;  // es un rango de fechas normal
        }

        // Verificar que fecha final sea mayor a fecha inicial , valides del rango
        if ($fecha_ini > $fecha_fin) {
            return false;
        }
        // No se permiten fechas futuras

        if (compara_fechas($fecha_ini, $hoy) > 0) {
            return false;
        }
        // Si existe algun historial se hacen varios chequeos 

        if (!empty($fechas)) {
            foreach ($fechas as $data) {
                $fecha_i = $data['FECHA_INI'];
                $fecha_f = $data['FECHA_FIN'];

                //si la fecha del historial es null estamos tratando con un rango actual                
                // idealmente solo existe uno y es el ultimo
                if ($fecha_f == NULL) {
                    $fecha_f = $hoy;
                    // si quiero crear un nuevo rango actual y ya tengo uno en historial
                    if ($actual) {
                        // la nueva fecha actual debe estar dentro del rango de la fecha actual que existe
                        // en el historial de lo contrario no nos sirve
                        if (check_in_range($fecha_i, $fecha_f, $fecha_ini)) {
                            $this->updateFecha($tabla,$data['id'],$fecha_ini);                            
                            return true; // listo OJO idealmente el ultimo rango es el que tiene NULL en su fecha final
                        } else {
                            return false;
                        }
                        // si no estoy creando un rango actual , osea un rango normal
                    } else {
                        //  la fecha final no puede ser mayor al dia de hoy  para que
                        //  no se puedan definir rangos hacia el futuro
                        if(compara_fechas($fecha_fin, $hoy) > 0){
                            return false;
                        }
                        
                        if (compara_fechas($fecha_ini, $fecha_i) > 0) {
                            $this->updateFecha($tabla,$data['id'],$fecha_ini);                           
                            return true; // listo OJO idealmente el ultimo rango es el que tiene NULL en su fecha final
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
    }
    /**
     *
     * @param type $tablename la tabla con el grupo de fechas
     * @param type $id el id de la fecha a updatear
     * @param type $fecha_ini la fecha 
     */
    function updateFecha($tabla, $id, $fecha_ini) {
        $fecha = formatoFechaBeforeSave($fecha_ini);
        // buscamos la fecha inicial y le restamos 1 day para formar la nueva fecha final
        // del historial anterior
        $fecha_new = date("Y-m-d", strtotime($fecha . "-1 days"));        
        $this->query("update ".$tabla." set FECHA_FIN='" . $fecha_new . "' where id='" . $id . "'");
    }

}
?>