<?php

class NominasController extends AppController {

    var $name = 'Nominas';
    var $helpers = array('Excel', 'Javascript', 'Ajax');
    var $components = array('RequestHandler', 'Wizard.Wizard');

    function beforeFilter() {        
        $this->Wizard->steps = array('parte1', 'parte2');                
        $this->Wizard->cancelUrl = '/nominas/edit/' . $this->Session->read('Nomina.ID');            
    }
    
    function wizard($step = null) {
        $this->Wizard->process($step);
    }     
    
    
    
    /**
     * [Wizard Process Callbacks]
     */
    function _processParte1() {        
        return true;
    }

    function _processParte2() {        
        return true;
    }    
    
    /**
     * [Wizard Prepare Callbacks]
     */    
    function _prepareParte2(){
        $asignacion = ClassRegistry::init('Asignacion');                
        $tabulador=$asignacion->tabulador_primas;
        $this->set('tabulador',$tabulador); 
    }    

    /**
     * [Wizard Completion Callback]
     */
    function _afterComplete() {        
        $wizardData = $this->Wizard->read();                
        $opciones = array(
            'Nomina_id' => $this->Session->read('Nomina.ID'),
            'Sueldo_Minimo' => $wizardData['parte1']['SUELDO_MINIMO'],
            'Primas'=>$wizardData['parte2']['PRIMAS']
        );
        $this->Wizard->reset();
        $this->_generar($opciones);
    }

    /**
     * 
     */
    function index() {
        $filtro = array();
        if (!empty($this->data)) {
            if (!empty($this->data['AÑO']) && empty($this->data['Fopcion'])) {
                $filtro = array('Nomina.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
            if (!empty($this->data['Fopcion']) && empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Nomina.FECHA_INI)' => $this->data['Fopcion']);
            }
            if (!empty($this->data['Fopcion']) && !empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Nomina.FECHA_INI)' => $this->data['Fopcion'], 'Nomina.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
        }
        $this->paginate = array(
            'recursive' => -1,
            'limit' => 20,
            'order' => array(
                'FECHA_INI' => 'desc'
            ),
        );

        $data = $this->paginate('Nomina', $filtro);
        $this->set('nominas', $data);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Nomina->save($this->data['Nomina'])) {
                $this->Session->setFlash('Nomina creada con exito', 'flash_success');
                //$id = $this->Nomina->getLastInsertId();
                //$this->Nomina->generarNomina($id);
                $this->redirect('index');
            }
            if (!empty($this->Nomina->errorMessage)) {
                $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
    }

    function delete($id) {
        if ($this->Nomina->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('index');
        }
    }

    function edit($id = null) {
        $asignacion = ClassRegistry::init('Asignacion');
        $deduccion = ClassRegistry::init('Deduccion');
        $asignaciones = $asignacion->find('list');
        $deducciones = $deduccion->find('list');

        $nomina = $this->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));
        // GRABAMOS EN LA SESSION EL ID DE LA NOMINA PARA EL WIZARD
        if ($this->Session->check('Nomina.ID')) {
            $this->Session->delete('Nomina');
        }
        $this->Session->write('Nomina.ID', $nomina['Nomina']['id']);

        $this->set(compact('asignaciones', 'deducciones', 'nomina'));
    }    

    function _generar($opciones) {        
        $this->Nomina->generarNomina($opciones);
        if ($this->Nomina->errorMessage != '') {
            $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
        } else {
            $this->Session->setFlash('Nomina generada con exito', 'flash_success');
        }
        $this->redirect('edit/' . $opciones['Nomina_id']);
    }

    /**
     *
     * @param type $tipo
     * @param type $id 
     */
    function mostrar() {
        $this->autoRender = false;
        if (!empty($this->data)) {
            $id = $this->data['nomina_id'];
            $nomina = $this->Nomina->find('first', array(
                'recursive' => 0,
                'conditions' => array(
                    'id' => $id
                )
                    ));

            list($dia, $mes, $anio) = preg_split('/-/', $nomina['Nomina']['FECHA_INI']);
            $temp = (((int) $mes) - 1) * 2;
            if ($nomina['Nomina']['QUINCENA'] == 'Primera') {
                $temp = $temp + 1;
            } else {
                $temp = $temp + 2;
            }
            $info_extra = array("Quincena" => $temp);

            if (empty($this->data['PERSONAL']) || empty($this->data['VISUALIZAR']) || empty($this->data['TIPO'])) {
                $this->Session->setFlash('Debe seleccionar el personal , tipo y el modo de visualizar', 'flash_error');
                $this->render('error', 'nomina');
                return;
            } else {
                if ($this->data['PERSONAL'] == '1') {
                    $grupo = 'Empleado';  // Empleado                    
                    $modalidad = 'Fijo';
                }
                if ($this->data['PERSONAL'] == '2') {
                    $grupo = 'Obrero';  // Obrero                    
                    $modalidad = 'Fijo';
                }
                if ($this->data['PERSONAL'] == '3') {
                    $grupo = array('Empleado', 'Obrero');  // Empleado y Obrero                    
                    $modalidad = 'Contratado';
                }
                $empleados = $this->Nomina->mostrarNomina($id, $grupo, $modalidad);
                $resumen = $this->Nomina->calcularResumen($empleados);
            }

            if (empty($empleados)) {
                $this->render('error', 'nomina');
                if ($this->Nomina->errorMessage == '') {
                    $this->Session->setFlash('Actualmente no existen datos relacionados a esta nomina, Genere la Nomina primero', 'flash_error');
                } else {
                    $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
                }
                return;
            }

            if ($this->data['VISUALIZAR'] == 'Pantalla') {
                if ($this->data['TIPO'] == 'Nomina') {
                    $this->set('empleados', $empleados);
                    $this->render('pantalla_nomina', 'nomina');
                }
                if ($this->data['TIPO'] == 'Resumen') {
                    $this->set('resumen', $resumen);
                    $this->render('pantalla_resumen', 'nomina');
                }
                if ($this->data['TIPO'] == 'Completo') {
                    $this->render('error', 'nomina');
                    if ($this->Nomina->errorMessage == '') {
                        $this->Session->setFlash('Esta opcion no esta disponible', 'flash_error');
                    } else {
                        $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
                    }
                }
            }
            if ($this->data['VISUALIZAR'] == 'Archivo') {
                if ($this->data['TIPO'] == 'Nomina') {
                    $this->set(compact('empleados', 'nomina', 'grupo', 'modalidad', 'info_extra', 'resumen'));
                    $this->render('archivo_nomina', 'nominaExcel');
                }
                if ($this->data['TIPO'] == 'Resumen') {
                    $this->set(compact('resumen', 'grupo', 'modalidad'));
                    $this->render('archivo_resumen', 'nominaExcel');
                }
                if ($this->data['TIPO'] == 'Completo') {
                    $this->set(compact('empleados', 'nomina', 'grupo', 'modalidad', 'info_extra', 'resumen'));
                    $this->render('archivo_completo', 'nominaExcel');
                }
            }
        }
    }

}

?>
