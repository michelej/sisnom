<?php

class AppModel extends Model {

    protected $sYourPropery = 'property';
    var $errorMessage='';

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
        
        // No se permiten fechas futuras
        if (compara_fechas($fecha_ini, $hoy) > 0) {
            //$this->errorMessage='No se permiten fechas futuras, la fecha inicial no puede ser mayor al dia de hoy';
            //return false;
        }
        // Verificar que fecha final sea mayor a fecha inicial , valides del rango        
        if(compara_fechas($fecha_ini, $fecha_fin)>0){
            $this->errorMessage='Ingrese un rango de fechas valido, la fecha final debe ser mayor a la fecha inicial';
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
                            $this->errorMessage='La fecha inicial debe estar dentro del rango  '.$fecha_i." y ".$fecha_f."  (hoy)";
                            return false;
                        }
                        // si no estoy creando un rango actual , osea un rango normal
                    } else {
                        //  la fecha final no puede ser mayor al dia de hoy  para que
                        //  no se puedan definir rangos hacia el futuro
                        if(compara_fechas($fecha_fin, $hoy) > 0){
                            //$this->errorMessage='No se permiten rangos hacia una fecha futura, la fecha final no puede ser mayor al dia de hoy';
                            //return false;
                        }
                        
                        if (compara_fechas($fecha_ini, $fecha_i) > 0) {
                            $this->updateFecha($tabla,$data['id'],$fecha_ini);                           
                            return true; // listo OJO idealmente el ultimo rango es el que tiene NULL en su fecha final
                        }
                    }
                } else {
                    // simplemente no se pueden solapar los rangos
                    if (check_in_range($fecha_i, $fecha_f, $fecha_ini) || check_in_range($fecha_i, $fecha_f, $fecha_fin)) {
                        $this->errorMessage='El rango de fechas no puede solapar a otro rango ya existente';
                        return false;
                    }
                }

                // el nuevo rango de fechas no puede contener a ninguno de los rangos que ya existen
                if (check_in_range($fecha_ini, $fecha_fin, $fecha_i) || check_in_range($fecha_ini, $fecha_fin, $fecha_f)) {
                    $this->errorMessage='El rango de fechas no puede solapar a otro rango ya existente';
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