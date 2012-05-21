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
    function calcularAsignaciones($nomina_empleado) {        
        $grupo=$nomina_empleado['GRUPO'];
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        // TODO: Ojo el cambio del estado civil es continuo no tiene variable de tiempo. Deberia Tenerlo?                        
                        if ($empleado['Empleado']['EDOCIVIL'] == 'Casado' || $empleado['Empleado']['EDOCIVIL'] == 'Concubinato') {
                            $valor = 12 / 2;
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        $dias_exp = 0;
                        foreach ($empleado['Empleado']['Experiencia'] as $experiencia) {
                            $dias_exp = $dias_exp + numeroDeDias($experiencia['FECHA_INI'], $experiencia['FECHA_FIN']);
                        }                                                
                        $dias = numeroDeDias($empleado['Empleado']['INGRESO'], $fecha_ini);
                        $dias=$dias+$dias_exp;
                        $años = $dias / 365;                        
                        $numero=round($años * 100) / 100;                         
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        $valor = 0;                        
                        if ($nomina_empleado['GRUPO'] == 'Empleado') {
                            foreach ($empleado['Empleado']['Familiar'] as $familiar) {
                                $edad = $this->Ajuste->Empleado->Edad($familiar['FECHA']);
                                // Comparamos con la fecha efectiva no la de nacimiento!! OJO
                                if (compara_fechas(formatoFechaAfterFind($fecha_ini), $familiar['FECHA_EFEC']) > 0 ||
                                        check_in_range($fecha_ini, $fecha_fin, formatoFechaBeforeSave($familiar['FECHA_EFEC']))) {
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
                                }else{
                                    $valor=0;
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
                                    $valor += 100 / 2;
                                }
                                if ($titulo['TITULO'] == 'Profesional Universitario') {
                                    $valor += 200 / 2;
                                }
                                if ($titulo['TITULO'] == 'Post-Grado') {
                                    $valor += 100 / 2;
                                }
                                if ($titulo['TITULO'] == 'Maestria') {
                                    $valor += 200 / 2;
                                }
                                if ($titulo['TITULO'] == 'Doctorado') {
                                    $valor += 300 / 2;
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
                    if ($this->empleadoTieneAsignacion($id_empleado, $value['id'], $fecha_ini, $fecha_fin)) {
                        $count = 0;
                        foreach ($empleado['Empleado']['HorasExtra'] as $horaextra) {
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
     *  Aqui podemos determinar el orden que queremos que tengan las asignaciones
     *  
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