<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

    Inflector::rules('singular', array(
    'rules' => array('/(.*)res$/i' => '\1r', '/(.*)nes$/i' => '\1n', '/(.*)des$/i' => '\1d', '/(.*)ses$/i' => '\1s',
        '/(.*)les$/i' => '\1l'),
    'irregular' => array(),
    'uninflected' => array()
    )
    );

    Inflector::rules('plural', array(
    'rules' => array('/(.*)r$/i' => '\1res', '/(.*)n$/i' => '\1nes', '/(.*)d$/i' => '\1des', '/(.*)s$/i' => '\1ses',
        '/(.*)l$/i' => '\1les'),
    'irregular' => array(),
    'uninflected' => array()
    )
    );
    
    Configure::write('FECHA_INICIO', '2006-01-01'); // Fecha de inicio    
    
    
    /*
     * Funciones Globales     * 
     * 
     */
    
    
    /**
     * Funcion para convertir fechas a un formato elegible en español 
     * @param type $date La fecha en formato d-m-Y (Ojo)
     * @return string La fecha en formato d-M-Y en español ejm: 1-Ene-2001
     */
    function fechaElegible($date) {
        if ($date == '' || empty($date))
            return '';
        $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct",
            "Nov", "Dic"); //Spanish
        /* $meses = array("Jan" , "Feb" , "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", 
          "Nov", "Dec"); */ //English

        list($dia, $mes, $anio) = preg_split('/-/', $date);
        $month = $meses[((int) $mes) - 1];
        $fechaLegible = $dia . "-".$month."-".$anio; //Spanish 
        /* $fechaLegible = $month.' '.$dia.", ".$anio; */ //English 
        return $fechaLegible;
    }
    
    /**
     * Verifica que una fecha esté dentro del rango de fechas establecidas
     * @param $start_date fecha de inicio
     * @param $end_date fecha final
     * @param $evaluame fecha a comparar
     * @return true si esta en el rango, false si no lo está
     */
    function check_in_range($start_date, $end_date, $evaluame) {
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($evaluame);
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }