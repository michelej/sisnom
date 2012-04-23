<?php

class Asignacion extends AppModel {

    var $name = 'Asignacion';
    var $displayField = 'DESCRIPCION';

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = 'Ajuste';

    /**
     *
     *      
     */
    var $constante = array(
        '1' => array('id' => '1', 'DESCRIPCION' => 'Prima por Reconocimiento'),
        '2' => array('id' => '2', 'DESCRIPCION' => 'Prima Hogar'),
        '3' => array('id' => '3', 'DESCRIPCION' => 'Prima por Antiguedad'),
        '4' => array('id' => '4', 'DESCRIPCION' => 'Prima por Transporte'),
        '5' => array('id' => '5', 'DESCRIPCION' => 'Prima por Hijos'),
        '6' => array('id' => '6', 'DESCRIPCION' => 'Nivelacion Profesional'),
        '7' => array('id' => '7', 'DESCRIPCION' => 'Bono Nocturno'),
        '8' => array('id' => '8', 'DESCRIPCION' => 'Recargo por Domingo y Dia Feriado'),
    );

    function beforeFind($queryData) {
        $this->verificar();
        return true;
    }

    /**
     *  Verifica si los datos en la tabla son iguales a los que estan aqui declarados
     *  la idea es trabajar todo desde aqui (el Modelo) si se quiere agregar algo se hace 
     *  desde aqui. 
     *            
     *  El (id) es importante se usa para identificar la asignacion a la hora de calcular!!!
     */
    function verificar() {
        // Los grupos aqui definidos deberian ser iguales a los que se encuentran en
        // el modelo Grupo (IMPORTANTE)
        /* $this->data = array(
          '1' => array('id' => '1', 'GRUPO' => 'Empleado', 'DESCRIPCION' => 'Prima por Reconocimiento'),
          '2' => array('id' => '2', 'GRUPO' => 'Empleado', 'DESCRIPCION' => 'Prima Hogar'),
          '3' => array('id' => '3', 'GRUPO' => 'Empleado', 'DESCRIPCION' => 'Prima por Antiguedad'),
          '4' => array('id' => '4', 'GRUPO' => 'Empleado', 'DESCRIPCION' => 'Prima por Transporte'),
          '5' => array('id' => '5', 'GRUPO' => 'Empleado', 'DESCRIPCION' => 'Prima por Hijos'),
          '6' => array('id' => '6', 'GRUPO' => 'Empleado', 'DESCRIPCION' => 'Nivelacion Profesional'),
          '7' => array('id' => '7', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Bono Nocturno'),
          '8' => array('id' => '8', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Recargo por Domingo y Dia Feriado'),
          '9' => array('id' => '9', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Reconocimiento'),
          '10' => array('id' => '10', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Antiguedad'),
          '11' => array('id' => '11', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Transporte'),
          '12' => array('id' => '12', 'GRUPO' => 'Obrero', 'DESCRIPCION' => 'Prima por Hijos'),
          ); */
        $this->data = $this->constante;

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
    function calcularAsignaciones($nomina_empleado, $grupo) {
        $data = $this->ordenDeAsignaciones($grupo);

        $sueldo_base = $nomina_empleado['SUELDO_BASE'];
        $sueldo_diario = $nomina_empleado['SUELDO_DIARIO'];
        $sueldo_basico = $nomina_empleado['SUELDO_BASICO'];
        $id_empleado = $nomina_empleado['ID_EMPLEADO'];
        $id_nomina = $nomina_empleado['ID_NOMINA'];

        $nomina = $this->Ajuste->Empleado->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id_nomina
            )
                ));
        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);

        $empleado = $this->Ajuste->Empleado->find('first', array(
            'contain' => array(
                'Familiar', 'Titulo', 'Experiencia',
                'HorasExtra' => array(
                    'conditions' => array(
                        '(FECHA BETWEEN ? AND ?)' => array($fecha_ini, $fecha_fin)
                    )
                )
            ),
            'conditions' => array(
                'id' => $id_empleado
            )
                ));

        // Realizamos el calculo para cada asignacion
        foreach ($data as $value) {
            switch ($value['id']) {
                //------------------------------------------------------------//
                //
                //                 PRIMA DE RECONOCIMIENTO
                //
                //------------------------------------------------------------//
                case "1":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
                            $valor = 12 / 2;
                        }
                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
                            $valor = 5.4 / 2;
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                 PRIMA POR HOGAR
                //
                // -----------------------------------------------------------//    
                case "2":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if ($empleado['Empleado']['EDOCIVIL'] == 'Casado' || $empleado['Empleado']['EDOCIVIL'] == 'Concubinato') {
                            $valor = 12 / 2;
                        } else {
                            $valor = 0;
                        }
                        $hijos = 0;
                        foreach ($empleado['Familiar'] as $familiar) {
                            if ($familiar['PARENTESCO'] == 'Hijo(a)') {
                                $hijos++;
                            }
                        }
                        if ($hijos > 0) {
                            $valor = 12 / 2;
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                    PRIMA POR ANTIGUEDAD
                //
                //------------------------------------------------------------//                
                case "3":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        $dias = 0;
                        foreach ($empleado['Experiencia'] as $experiencia) {
                            $dias = $dias + numeroDeDias($experiencia['FECHA_INI'], $experiencia['FECHA_FIN']);
                        }
                        $añosLab = ($dias / 365);
                        $dias = numeroDeDias($empleado['Empleado']['INGRESO'], $nomina['Nomina']['FECHA_INI']);
                        $numero = $dias / 365;

                        $numero = $numero + $añosLab;

                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
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
                        }
                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
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
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                 PRIMA POR TRANSPORTE
                //
                //------------------------------------------------------------//                
                case "4":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
                            $valor = 60 / 2;
                        }
                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
                            // OJO EL CARGO DEBE LLAMARSE """"Mensajero""""
                            $diasHabiles = $nomina_empleado['DIAS_HABILES'];
                            if ($nomina_empleado['CARGO'] == 'Mensajero') {
                                $valor = 0.416 * $diasHabiles;
                            } else {
                                $valor = 0.260 * $diasHabiles;
                            }
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                 PRIMA POR HIJOS
                //
                //------------------------------------------------------------//                
                case "5":
                    // TODO: Verificar si las combinaciones estan bien o falta alguna
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        $valor = 0;

                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
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
                        }

                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
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
                        }
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                NIVELACION PROFESIONAL
                //                
                //------------------------------------------------------------// 
                case "6":
                    // OJO LA FECHA QUE ? Cuando entra en validez un titulo
                    $valor = 0;
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
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
                    $asignaciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //                    BONO NOCTURNO
                //                
                //------------------------------------------------------------//
                case "7":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        $count = 0;
                        foreach ($empleado['HorasExtra'] as $horaextra) {
                            if ($horaextra['TIPO'] == 'Nocturno') {
                                $count++;
                            }
                        }
                        $valor = $count * $sueldo_diario * 0.30;
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['DESCRIPCION']] = $valor;
                    break;
                //------------------------------------------------------------//
                //
                //             RECARGO DOMINGO Y DIA FERIADO
                //                
                //------------------------------------------------------------//
                case "8":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'],$fecha_ini,$fecha_fin)) {
                        $count = 0;
                        foreach ($empleado['HorasExtra'] as $horaextra) {
                            if ($horaextra['TIPO'] == 'Domingos y Dias Feriados') {
                                $count++;
                            }
                        }
                        $valor = $count * $sueldo_diario * 1.50;
                    } else {
                        $valor = 0;
                    }
                    $asignaciones[$value['DESCRIPCION']] = $valor;
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
    function empleadoTieneAsignacion($id_empleado, $id_asignacion,$fecha_ini,$fecha_fin) {
        $empleado = $this->Ajuste->Empleado->find("first", array(
            'conditions' => array(
                'id' => $id_empleado
            ),
            'contain' => array(
                'Ajuste' => array(
                    'conditions' => array(
                        'OR' => array(
                            'FECHA_FIN > ' => $fecha_ini,
                            'FECHA_FIN' => NULL,
                        ),
                        'AND' => array(
                            'FECHA_INI < ' => $fecha_fin,
                        )
                    ),
                    'Asignacion' => array(
                        'conditions' => array(
                            'id' => $id_asignacion
                        )
                    )
                )
            )
                ));        
        if (empty($empleado['Ajuste']['Asignacion'])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *  Aqui podemos determinar el orden que queremos que tengan las asignaciones
     *  
     * @param type $tipo
     * @return type 
     */
    function ordenDeAsignaciones($tipo) {
        if ($tipo == array('1' => 'Empleado')) {
            $orden = array('1', '2', '3', '4', '5', '6');
        }
        if ($tipo == array('2' => 'Obrero')) {
            $orden = array('7', '8', '1', '3', '4', '5');
        }
        if ($tipo == array('1' => 'Empleado', '2' => 'Obrero')) {
            $orden = array('7', '8', '1', '2', '3', '4', '5', '6');
        }
        foreach ($orden as $value) {
            $resultado[] = $this->constante[$value];
        }
        return $resultado;
    }

}

?>