<?php

class Empleado extends AppModel {

    var $name = 'Empleado';

    function beforeSave() {
        if (!empty($this->data['Empleado']['FECHANAC'])) {
            $this->data['Empleado']['FECHANAC'] = $this->formatoFechaBeforeSave($this->data['Empleado']['FECHANAC']);            
        }
        if (!empty($this->data['Empleado']['INGRESO'])) {
            $this->data['Empleado']['INGRESO'] = $this->formatoFechaBeforeSave($this->data['Empleado']['INGRESO']);            
        }        
        return true;
    }

    function formatoFechaBeforeSave($cadenaFecha) {
        return date('Y-m-d', strtotime($cadenaFecha)); // Direction is from
    }

}
