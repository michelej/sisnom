<?php

class Experiencia extends AppModel {

    var $name = 'Experiencia';
    var $displayField = 'ORGANISMO';
    var $errorMessage = '';
    var $actAs = 'Contaniable';

    /**
     *  Relaciones
     */
    var $belongsTo = 'Empleado';

    /**
     *  Validaciones
     */
    var $validate = array(
        'FECHA_INI' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha Inicial incorrecta',
        ),
        'FECHA_FIN' => array(
            'rule' => array('date', 'dmy'),
            'message' => 'Fecha final incorrecta',
        ),
        'ORGANISMO' => array(
            'rule' => 'notEmpty',
            'message' => 'Ingrese el organismo'
        ),
        'CARGO' => array(
            'rule' => 'notEmpty',
            'message' => 'Ingrese el cargo desempeñado'
        )
    );

    // TODO: Falta validar la fecha final 
    /**
     *
     * @return boolean 
     */
    function beforeSave() {
        $fecha_ini = $this->data['Experiencia']['FECHA_INI'];
        $fecha_fin = $this->data['Experiencia']['FECHA_FIN'];

        if (compara_fechas($fecha_ini, $fecha_fin) > 0) {
            $this->errorMessage = "La fecha inicial no puede ser mayor a la final";
            return false;
        }
        
        $fecha_ingreso=$this->Empleado->find('first',array(
            'recursive'=>-1,
            'conditions'=>array(
                'Empleado.id'=>$this->data['Experiencia']['empleado_id']
            ),
            'fields'=>array(
                'Empleado.INGRESO'
            )            
        ));
        
        if (compara_fechas($fecha_fin, $fecha_ingreso['Empleado']['INGRESO']) > 0) {
            $this->errorMessage = "Debe ingresar fechas previas al ingreso del empleado. Ingreso el ".  fechaElegible($fecha_ingreso['Empleado']['INGRESO']);
            return false;
        }
        

        //Tratamos las fechas
        if (!empty($this->data['Experiencia']['FECHA_INI'])) {
            $this->data['Experiencia']['FECHA_INI'] = formatoFechaBeforeSave($this->data['Experiencia']['FECHA_INI']);
        }
        if (!empty($this->data['Experiencia']['FECHA_FIN'])) {
            $this->data['Experiencia']['FECHA_FIN'] = formatoFechaBeforeSave($this->data['Experiencia']['FECHA_FIN']);
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
            if (isset($val['Experiencia']['FECHA_INI'])) {
                $results[$key]['Experiencia']['FECHA_INI'] = formatoFechaAfterFind($val['Experiencia']['FECHA_INI']);
            }
            if (isset($val['Experiencia']['FECHA_FIN'])) {
                $results[$key]['Experiencia']['FECHA_FIN'] = formatoFechaAfterFind($val['Experiencia']['FECHA_FIN']);
            }
        }
        return $results;
    }

}

?>