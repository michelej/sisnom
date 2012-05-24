<?php

class NominasController extends AppController {

    var $name = 'Nominas';
    var $helpers = array('Excel', 'Javascript', 'Ajax');
    var $components = array('RequestHandler');

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
        // TODO: Verificar si existen cambios depues de creada la nomina ??????        
        $nomina = $this->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));

        $this->set('nomina', $nomina);
    }

    /**
     *  Genera toda la informacion referente a nomina Recibo -> Detalle de Recibo
     * @param type $id 
     */
    function generar($id = null) {
        $this->autoRender = false;
        $this->Nomina->generarNomina($id);

        if ($this->Nomina->errorMessage != '') {
            $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
        } else {
            $this->Session->setFlash('Nomina generada con exito', 'flash_success');
        }
        $this->redirect('edit/' . $id);
    }

    /**
     *
     * @param type $tipo
     * @param type $id 
     */
    function mostrar($id = null, $tipo = null, $grupo = null) {
        $this->autoRender = false;

        $empleados = $this->Nomina->mostrarNomina($id, $grupo);

        if (empty($empleados)) {
            $this->render('error', 'nomina');
            if ($this->Nomina->errorMessage == '') {
                $this->Session->setFlash('Actualmente no existen datos relacionados a esta nomina, Genere la Nomina primero', 'flash_error');
            } else {
                $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
            }
            return;
        }
        
        if ($tipo == 'pantalla_nomina') {
            $this->set('empleados',$empleados);
            $this->render('pantalla_nomina', 'nomina');
        }
        if ($tipo == 'pantalla_resumen') {
            $resumen=$this->Nomina->calcularResumen($empleados);            
            $this->set('resumen',$resumen);
            $this->render('pantalla_resumen', 'nomina');
        }
        if ($tipo == 'archivo_nomina') {
            $this->set(compact('empleados'));
            $this->render('generar_archivo', 'nominaExcel');
        }
    }

}

?>
