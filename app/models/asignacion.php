<?php

class Asignacion extends AppModel {

    var $name = 'Asignacion';
    var $displayField = 'DESCRIPCION';

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = 'Empleado';

    /**
     *
     *      
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
            '1' => array('id' => '1', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Reconocimiento'),
            '2' => array('id' => '2', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima Hogar'),
            '3' => array('id' => '3', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Antiguedad'),
            '4' => array('id' => '4', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Transporte'),
            '5' => array('id' => '5', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Prima por Hijos'),
            '6' => array('id' => '6', 'GRUPO' => 'Administrativo', 'DESCRIPCION' => 'Nivelacion Profesional'),
            '7' => array('id' => '7', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Reconocimiento'),
            '8' => array('id' => '8', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Antiguedad'),
            '9' => array('id' => '9', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte'),
            '10' => array('id' => '10', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijos'),
        );

        // Para que esto funcione debemos de convertir lo que traigamos del query
        // en algo parecido a lo que tenemos arriba
        // no podemos usar find aqui porque se crea un loop infinito ya que esta funcion
        // es invocada desde el beforeFind
        $data = $this->query("SELECT * FROM asignaciones as Asignacion");
        $result = Set::combine($data, '{n}.Asignacion.id', '{n}.Asignacion');
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

    /**
     * Calcular las Asignaciones de un Empleado para una Nomina especifica
     * @param type 
     */
    function calcularAsignaciones($id_nomina, $grupo, $id_empleado) {
        // Buscamos todas las asignaciones de este grupo
        $data = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'GRUPO' => $grupo
            )
                ));
        $empleado = $this->Empleado->find('first', array(
            'contain' => array(
                'Familiar', 'Titulo'
            ),
            'conditions' => array(
                'id' => $id_empleado
            )
                ));
        $nomina = $this->Empleado->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id_nomina
            )
                ));
        
        // Realizamos el calculo para cada asignacion que pertenece a este grupo
        foreach ($data as $value) {
            switch ($value['Asignacion']['id']) {
                //------- Administrativo - Prima Reconocimiento  ------//
                //-----------------------------------------------------//
                case "1":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        $valor = 12 / 2;
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //-------  Administrativo - Prima Hogar  -----//
                //--------------------------------------------//    
                case "2":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        if ($empleado['Empleado']['EDOCIVIL'] == 'Casado' || $empleado['Empleado']['EDOCIVIL'] == 'Concubinato') {
                            $valor = 12 / 2;
                        } else {
                            $valor = 0;
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //-------- Administrativo - Prima por Antiguedad -------------//
                //------------------------------------------------------------//
                case "3":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        // Inicio o Fin de la Quincena??
                        // TODO: Falta la antiguedad en los otros organismos
                        $dias = numeroDeDias($empleado['Empleado']['INGRESO'], $nomina['Nomina']['FECHA_INI']);
                        $numero = $dias / 365;
                        if ($numero < 1)
                            $valor = 0;
                        if ($numero > 1 && $numero <= 2)
                            $valor = 12.30 / 2;
                        if ($numero > 2 && $numero <= 4)
                            $valor = 24.60 / 2;
                        if ($numero > 4 && $numero <= 6)
                            $valor = 36.90 / 2;
                        if ($numero > 6 && $numero <= 8)
                            $valor = 49.20 / 2;
                        if ($numero > 8 && $numero <= 10)
                            $valor = 61.50 / 2;
                        if ($numero > 10 && $numero <= 12)
                            $valor = 73.80 / 2;
                        if ($numero > 12 && $numero <= 14)
                            $valor = 86.10 / 2;
                        if ($numero > 14 && $numero <= 16)
                            $valor = 98.40 / 2;
                        if ($numero > 16 && $numero <= 18)
                            $valor = 110.70 / 2;
                        if ($numero > 18 && $numero <= 20)
                            $valor = 123 / 2;
                        if ($numero > 20 && $numero <= 22)
                            $valor = 135.30 / 2;
                        if ($numero > 22 && $numero <= 24)
                            $valor = 147.60 / 2;
                        if ($numero > 24 && $numero <= 26)
                            $valor = 159.90 / 2;
                        if ($numero > 26 && $numero <= 28)
                            $valor = 172.20 / 2;
                        if ($numero > 28 && $numero <= 30)
                            $valor = 184.50 / 2;
                        if ($numero > 30)
                            $valor = 196.80 / 2;
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //------- Administrativo - Prima por Transporte  --------//
                //-------------------------------------------------------//
                case "4":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        $valor = 60 / 2;
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //-------Administrativo - Prima por Hijos -------------//
                //-----------------------------------------------------//    
                case "5":
                    // Verificar si faltan Combinaciones
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        $valor = 0;
                        foreach ($empleado['Familiar'] as $familiar) {
                            $edad = $this->Empleado->Edad($familiar['FECHA']);
                            if ($edad < 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['DISCAPACIDAD'] == 'Si') {
                                $valor+=15 / 2;
                            }
                            if ($edad < 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['DISCAPACIDAD'] == 'No') {
                                $valor+=12 / 2;
                            }
                            if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'T.S.U') {
                                $valor+=15 / 2;
                            }
                            if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'Pregrado') {
                                $valor+=18 / 2;
                            }
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //--------- Administrativo - Nivelacion Profesional --------//
                //----------------------------------------------------------//
                case "6":
                    // OJO LA FECHA QUE ? Cuando entra en validez un titulo
                    $valor = 0;
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        foreach ($empleado['Titulo'] as $titulo) {
                            if ($titulo['TITULO'] == 'T.S.U') {
                                $valor = +100 / 2;
                            }
                            if ($titulo['TITULO'] == 'Profesional Universitario') {
                                $valor = +200 / 2;
                            }
                            if ($titulo['TITULO'] == 'Post-Grado') {
                                $valor = +100 / 2;
                            }
                            if ($titulo['TITULO'] == 'Maestria') {
                                $valor = +200 / 2;
                            }
                            if ($titulo['TITULO'] == 'Doctorado') {
                                $valor = +300 / 2;
                            }
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //--------- Obrero - Prima Reconocimiento  --------//
                //-------------------------------------------------//
                case "7":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        $valor = 5.4 / 2;
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //--------- -Obrero - Prima por Antiguedad  --------//
                //-------------------------------------------------//
                case "8":
                    // Como se incluyen los años en otros organismos
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        $dias = numeroDeDias($empleado['Empleado']['INGRESO'], $nomina['Nomina']['FECHA_INI']);
                        $numero = $dias / 365;
                        if ($numero < 1)
                            $valor = 0;
                        if ($numero > 1 && $numero < 4)
                            $valor = 0.50 * 15;
                        if ($numero >= 4 && $numero < 7)
                            $valor = 0.65 * 15;
                        if ($numero >= 7 && $numero < 11)
                            $valor = 0.700 * 15;
                        if ($numero > 11 && $numero < 15)
                            $valor = 0.850 * 15;
                        if ($numero > 15)
                            $valor = 1.5 * 15;
                    }else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //--------- Obrero - Prima por Transporte  -------//
                //------------------------------------------------//    
                case "9":
                    // Falta Calcular los Dias Habiles OJO
                    $diasHabiles = 15;
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        $valor = 0.260 * $diasHabiles;
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                //-------- Obrero - Prima por Hijos  ----------------//    
                //---------------------------------------------------//    
                case "10":
                    // Verificar si faltan Combinaciones
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['Asignacion']['id'])) {
                        $valor = 0;
                        foreach ($empleado['Familiar'] as $familiar) {
                            $edad = $this->Empleado->Edad($familiar['FECHA']);
                            if ($edad < 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['DISCAPACIDAD'] == 'Si') {
                                $valor+=15 / 2;
                            }
                            if ($edad < 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['DISCAPACIDAD'] == 'No') {
                                $valor+=1.8 / 2;
                            }
                            if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'T.S.U') {
                                $valor+=2.5 / 2;
                            }
                            if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'Pregrado') {
                                $valor+=3.5 / 2;
                            }
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['Asignacion']['DESCRIPCION']] =$valor;
                    break;
                default:
                    $asignaciones[] = array();
                    break;
            }
        }
        return $asignaciones;
    }

    /**
     * Verificamos si un Empleado posee una Asignacion
     * @param type $empleado
     * @param type $asignacion 
     */
    function empleadoTieneAsignacion($id_empleado, $id_asignacion) {
        $empleado = $this->Empleado->find("first", array(
            'conditions' => array(
                'id' => $id_empleado
            ),
            'contain' => array(
                'Asignacion' => array(
                    'conditions' => array(
                        'id' => $id_asignacion
                    )
                )
            )
                ));
        if (empty($empleado)) {
            return false;
        } else {
            return true;
        }
    }

}

?>