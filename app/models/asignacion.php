<?php

class Asignacion extends AppModel {

    var $name = 'Asignacion';
    var $displayField = 'DESCRIPCION';

    /**
     *  Relaciones
     */
    var $hasAndBelongsToMany = 'Ajuste';

    /**
     *  Asignaciones que el sistema actualmente maneja
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

    /**
     * Tabulador de Primas!!
     *  Mas complicado q'l coño :|
     */
    var $tabulador_primas = array(
        '1' => array(
            'NOMBRE' => 'Prima por Reconocimiento',
            'Empleado' => '12',
            'Obrero' => '5.4'
        ),
        '2' => array(
            'NOMBRE' => 'Prima Hogar',
            'Empleado' => '12',
            'Obrero' => '12'
        ),
        '3' => array(
            'NOMBRE' => 'Prima por Antiguedad',
            'Empleado' => array(
                'De 1 año un dia a 2 años' => '12.3',
                'De 2 años un dia a 4 años' => '24.6',
                'De 4 años un dia a 6 años' => '36.9',
                'De 6 años un dia a 8 años' => '49.20',
                'De 8 años un dia a 10 años' => '61.50',
                'De 10 años un dia a 12 años' => '73.80',
                'De 12 años un dia a 14 años' => '86.10',
                'De 14 años un dia a 16 años' => '98.40',
                'De 16 años un dia a 18 años' => '110.70',
                'De 18 años un dia a 20 años' => '123.00',
                'De 20 años un dia a 22 años' => '135.30',
                'De 22 años un dia a 24 años' => '147.60',
                'De 24 años un dia a 26 años' => '159.90',
                'De 26 años un dia a 28 años' => '172.20',
                'De 28 años un dia a 30 años' => '184.50',
                'Mas de 30' => '196.80'),
            'Obrero' => array(
                'De 1 año un dia a 4 años' => '15',
                'De 4 año un dia a 7 años' => '19.5',
                'De 7 año un dia a 11 años' => '21',
                'De 11 año un dia a 15 años' => '25.5',
                'Mas de 15' => '45')),
        '4' => array(
            'NOMBRE' => 'Prima por Transporte',
            'Empleado' => '60',
            'Obrero' => array(
                'mensajero' => '9.15',
                'otros' => '5.72')
        ),
        '5' => array(
            'NOMBRE'=>'Prima por Hijos',
            'Empleado' => array(
                'Hijo menor a 18 años' => '12',
                'Hijo mayor a 18 TSU' => '15',
                'Hijo mayor a 18 pre-grado' => '18',
                'Hijo con invalidez' => '15'),
            'Obrero' => array(
                'Hijo menor a 18 años' => '1.8',
                'Hijo mayor a 18 TSU' => '2.5',
                'Hijo mayor a 18 pre-grado' => '3.5',
                'Hijo con invalidez' => '15')
        ),
        '6' => array(
            'NOMBRE' => 'Nivelacion Profesional',
            'Empleado' => array(
                'TSU' => '100',
                'Universitario' => '200',
                'Post-grado' => '100',
                'Maestria' => '200',
                'Doctorado' => '300'),
        ),
        '7' => array(
            'NOMBRE' => 'Bono Nocturno',
            'Obrero' => '30'
        ),
        '8' => array(
            'NOMBRE' => 'Recargo por Domingo y Dia Feriado',
            'Obrero' => '150'
        )
    );

    /**
     *
     * @param type $queryData
     * @return boolean 
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
     *  El (id) es importante se usa para identificar la asignacion a la hora de calcular!!!
     */
    function verificar() {
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
     * @param type $nomina_empleado El array con los datos del empleado (ver nomina para mas informacion)
     * @param type $grupo El grupo al que pertenece el empleado
     * @return array 
     */
    function calcularAsignaciones($nomina_empleado,$primas) {
        $grupo = $nomina_empleado['GRUPO'];        
        if ($nomina_empleado['MODALIDAD'] == 'Contratado') {
            $grupo = 'Contratados';
        }

        $data = $this->ordenDeAsignaciones($grupo);

        $sueldo_base = $nomina_empleado['SUELDO_BASE'];
        $sueldo_diario = $nomina_empleado['SUELDO_DIARIO'];
        $sueldo_basico = $nomina_empleado['SUELDO_BASICO'];
        $id_empleado = $nomina_empleado['ID_EMPLEADO'];
        $id_nomina = $nomina_empleado['ID_NOMINA'];

        $fecha_ini = $nomina_empleado['FECHA_INI'];
        $fecha_fin = $nomina_empleado['FECHA_FIN'];

        $empleado['Empleado'] = $nomina_empleado['Empleado'];

        // Realizamos el calculo para cada asignacion
        // Se hace de esta manera para que no importa el orden en el que un empleado tenga
        // sus ajustes guardados siempre van a ser los obtenidos por la funcion ordemAsignacion
        // para asi mantener un orden
        foreach ($data as $value) {
            switch ($value['id']) {
                //------------------------------------------------------------//
                //
                //                 PRIMA DE RECONOCIMIENTO
                //
                //------------------------------------------------------------//
                case "1":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
                            //$valor = 12 / 2;
                            $valor=$primas['1']['Empleado']/2;
                        }
                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
                            //$valor = 5.4 / 2;
                            $valor=$primas['1']['Obrero']/2;
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        // TODO: Ojo el cambio del estado civil es continuo no tiene variable de tiempo. Deberia Tenerlo?                        
                        if ($empleado['Empleado']['EDOCIVIL'] == 'Casado' || $empleado['Empleado']['EDOCIVIL'] == 'Concubinato') {
                            //$valor = 12 / 2;
                            $valor=$primas['2']['Empleado']/2;
                        } else {
                            $valor = 0;
                        }
                        $hijos = 0;
                        foreach ($empleado['Empleado']['Familiar'] as $familiar) {
                            if ($familiar['PARENTESCO'] == 'Hijo(a)') {
                                $hijos++;
                            }
                        }
                        if ($hijos > 0) {                            
                            //$valor = 12 / 2;
                            $valor=$primas['2']['Empleado']/2;
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        $dias_exp = 0;
                        foreach ($empleado['Empleado']['Experiencia'] as $experiencia) {
                            $dias_exp = $dias_exp + numeroDeDias($experiencia['FECHA_INI'], $experiencia['FECHA_FIN']);
                        }
                        $dias = numeroDeDias($empleado['Empleado']['INGRESO'], $fecha_ini);
                        $dias = $dias + $dias_exp;
                        $años = $dias / 365;
                        $numero = round($años * 100) / 100;
                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
                            if ($numero < 1)
                                $valor = 0;
                            if ($numero > 1 && $numero <= 2)                                
                                $valor=$primas['3']['Empleado']['De 1 año un dia a 2 años']/2;
                            if ($numero > 2 && $numero <= 4)
                                $valor=$primas['3']['Empleado']['De 2 años un dia a 4 años']/2;
                            if ($numero > 4 && $numero <= 6)
                                $valor=$primas['3']['Empleado']['De 4 años un dia a 6 años']/2;
                            if ($numero > 6 && $numero <= 8)
                                $valor=$primas['3']['Empleado']['De 6 años un dia a 8 años']/2;
                            if ($numero > 8 && $numero <= 10)
                                $valor=$primas['3']['Empleado']['De 8 años un dia a 10 años']/2;
                            if ($numero > 10 && $numero <= 12)
                                $valor=$primas['3']['Empleado']['De 10 años un dia a 12 años']/2;
                            if ($numero > 12 && $numero <= 14)
                                $valor=$primas['3']['Empleado']['De 12 años un dia a 14 años']/2;
                            if ($numero > 14 && $numero <= 16)
                                $valor=$primas['3']['Empleado']['De 14 años un dia a 16 años']/2;
                            if ($numero > 16 && $numero <= 18)
                                $valor=$primas['3']['Empleado']['De 16 años un dia a 18 años']/2;
                            if ($numero > 18 && $numero <= 20)
                                $valor=$primas['3']['Empleado']['De 18 años un dia a 20 años']/2;
                            if ($numero > 20 && $numero <= 22)
                                $valor=$primas['3']['Empleado']['De 20 años un dia a 22 años']/2;
                            if ($numero > 22 && $numero <= 24)
                                $valor=$primas['3']['Empleado']['De 22 años un dia a 24 años']/2;
                            if ($numero > 24 && $numero <= 26)
                                $valor=$primas['3']['Empleado']['De 24 años un dia a 26 años']/2;
                            if ($numero > 26 && $numero <= 28)
                                $valor=$primas['3']['Empleado']['De 26 años un dia a 28 años']/2;
                            if ($numero > 28 && $numero <= 30)
                                $valor=$primas['3']['Empleado']['De 28 año un dia a 30 años']/2;
                            if ($numero > 30)
                                $valor=$primas['3']['Empleado']['Mas de 30']/2;
                        }
                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
                            if ($numero < 1)
                                $valor = 0;
                            if ($numero > 1 && $numero < 4)
                                $valor=$primas['3']['Obrero']['De 1 año un dia a 4 años']/2;
                            if ($numero >= 4 && $numero < 7)
                                $valor=$primas['3']['Obrero']['De 4 años un dia a 7 años']/2;
                            if ($numero >= 7 && $numero < 11)
                                $valor=$primas['3']['Obrero']['De 7 años un dia a 11 años']/2;
                            if ($numero > 11 && $numero < 15)
                                $valor=$primas['3']['Obrero']['De 11 años un dia a 15 años']/2;
                            if ($numero > 15)
                                $valor=$primas['3']['Obrero']['Mas de 15']/2;
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
                            //$valor = 60 / 2;
                            $valor=$primas['4']['Empleado']/2;
                        }
                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
                            // OJO EL CARGO DEBE LLAMARSE """"Mensajero""""                            
                            $diasHabiles = $nomina_empleado['DIAS_HABILES'];
                            if (strtolower($nomina_empleado['CARGO']) == 'mensajero') {
                                //$valor = 0.416 * $diasHabiles;
                                $valor=$primas['4']['Obrero']['mensajero']* $diasHabiles;
                            } else {
                                //$valor = 0.260 * $diasHabiles;
                                $valor=$primas['4']['Obrero']['otros']* $diasHabiles;
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        $valor = 0;
                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
                            foreach ($empleado['Empleado']['Familiar'] as $familiar) {
                                $edad = $this->Ajuste->Empleado->Edad($familiar['FECHA']);

                                // Comparamos con la fecha efectiva no la de nacimiento!! OJO
                                if (compara_fechas(formatoFechaAfterFind($fecha_ini), $familiar['FECHA_EFEC']) > 0 ||
                                        check_in_range($fecha_ini, $fecha_fin, formatoFechaBeforeSave($familiar['FECHA_EFEC']))) {
                                    if ($edad < 18 && $familiar['PARENTESCO'] == 'Hijo(a)') {
                                        //$valor+=12 / 2;
                                        $valor+=$primas['5']['Empleado']['Hijo menor a 18 años']/2;
                                    }
                                    if ($familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['DISCAPACIDAD'] == 'Si') {
                                        //$valor+=15 / 2;
                                        $valor+=$primas['5']['Empleado']['Hijo con invalidez']/2;
                                    }
                                    if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'T.S.U') {
                                        //$valor+=15 / 2;
                                        $valor+=$primas['5']['Empleado']['Hijo mayor a 18 TSU']/2;
                                    }
                                    if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'Pregrado') {
                                        //$valor+=18 / 2;
                                        $valor+=$primas['5']['Empleado']['Hijo mayor a 18 pre-grado']/2;
                                    }
                                } else {
                                    $valor = 0;
                                }
                            }
                        }

                        if ($nomina_empleado['GRUPO'] == 'Obrero') {
                            foreach ($empleado['Empleado']['Familiar'] as $familiar) {
                                $edad = $this->Ajuste->Empleado->Edad($familiar['FECHA']);
                                // Comparamos con la fecha efectiva no la de nacimiento!! OJO
                                if (compara_fechas(formatoFechaAfterFind($fecha_ini), $familiar['FECHA_EFEC']) > 0 ||
                                        check_in_range($fecha_ini, $fecha_fin, formatoFechaBeforeSave($familiar['FECHA_EFEC']))) {
                                    if ($edad < 18 && $familiar['PARENTESCO'] == 'Hijo(a)') {
                                        //$valor+=1.8 / 2;
                                        $valor+=$primas['5']['Obrero']['Hijo menor a 18 años']/2;
                                    }
                                    if ($familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['DISCAPACIDAD'] == 'Si') {
                                        //$valor+=15 / 2;
                                        $valor+=$primas['5']['Obrero']['Hijo con invalidez']/2;
                                    }
                                    if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'T.S.U') {
                                        //$valor+=2.5 / 2;
                                        $valor+=$primas['5']['Obrero']['Hijo mayor a 18 TSU']/2;
                                    }
                                    if ($edad >= 18 && $familiar['PARENTESCO'] == 'Hijo(a)' && $familiar['INSTRUCCION'] == 'Pregrado') {
                                        //$valor+=3.5 / 2;
                                        $valor+=$primas['5']['Obrero']['Hijo mayor a 18 pre-grado']/2;
                                    }
                                } else {
                                    $valor = 0;
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
                    $valor = 0;
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        foreach ($empleado['Empleado']['Titulo'] as $titulo) {
                            // La prima se empieaza a pagar a partir de la Quincena en la que se declara                            
                            if (compara_fechas(formatoFechaAfterFind($fecha_ini), $titulo['FECHA']) > 0 ||
                                    check_in_range($fecha_ini, $fecha_fin, formatoFechaBeforeSave($titulo['FECHA']))) {
                                if ($titulo['TITULO'] == 'T.S.U') {
                                    //$valor += 100 / 2;
                                    $valor+=$primas['6']['Empleado']['TSU']/2;
                                }
                                if ($titulo['TITULO'] == 'Profesional Universitario') {
                                    //$valor += 200 / 2;
                                    $valor+=$primas['6']['Empleado']['Universitario']/2;
                                }
                                if ($titulo['TITULO'] == 'Post-Grado') {
                                    //$valor += 100 / 2;
                                    $valor+=$primas['6']['Empleado']['Post-grado']/2;
                                }
                                if ($titulo['TITULO'] == 'Maestria') {
                                    //$valor += 200 / 2;
                                    $valor+=$primas['6']['Empleado']['Maestria']/2;
                                }
                                if ($titulo['TITULO'] == 'Doctorado') {
                                    //$valor += 300 / 2;
                                    $valor+=$primas['6']['Empleado']['Doctorado']/2;
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
                //                    BONO NOCTURNO
                //                
                //------------------------------------------------------------//
                case "7":
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        $count = 0;
                        foreach ($empleado['Empleado']['HorasExtra'] as $horaextra) {
                            if ($horaextra['TIPO'] == 'Nocturno') {
                                $count++;
                            }
                        }
                        //$valor = $count * $sueldo_diario * 0.30;
                        $valor = $count * $sueldo_diario * ($primas['7']['Obrero']/100);
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        $count = 0;
                        foreach ($empleado['Empleado']['HorasExtra'] as $horaextra) {
                            if ($horaextra['TIPO'] == 'Domingos y Dias Feriados') {
                                $count++;
                            }
                        }
                        //$valor = $count * $sueldo_diario * 1.50;
                        $valor = $count * $sueldo_diario * ($primas['8']['Obrero']/100);
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
     * @param type $id_empleado Id del Empleado
     * @param type $id_asignacion Id de la Asignacion
     * @param type $fecha_ini Fecha de Inicio de la Nomina
     * @param type $fecha_fin Fecha de Fin de la Nomina
     * @return boolean Si la tiene o No
     */
    function empleadoTieneAsignacion($id_empleado, $id_asignacion, $fecha_ini, $fecha_fin) {
        $empleado = $this->Ajuste->find("first", array(
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $fecha_ini,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'FECHA_INI < ' => $fecha_fin,
                    'empleado_id' => $id_empleado
                )
            ),
            'contain' => array(
                'Asignacion' => array(
                    'conditions' => array(
                        'id' => $id_asignacion
                    )
                )
            )
                ));

        if (empty($empleado['Asignacion'])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Orden en el que se van a manejar las Deducciones en ajustes y nomina
     * @param type $tipo
     * @return type El orden de la Asignaciones
     */
    function ordenDeAsignaciones($tipo) {
        if ($tipo == 'Empleado') {
            $orden = array('1', '2', '3', '4', '5', '6');
        }
        if ($tipo == 'Obrero') {
            $orden = array('7', '8', '1', '3', '4', '5');
        }
        if ($tipo == 'Contratados') {
            $orden = array('7', '8');
        }
        foreach ($orden as $value) {
            $resultado[] = $this->constante[$value];
        }
        return $resultado;
    }

}

?>