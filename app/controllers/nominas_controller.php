<?php

class NominasController extends AppController {

    var $name = 'Nominas';

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
                $id=$this->Nomina->getLastInsertId();
                $this->Nomina->generarNomina($id);
                $this->redirect('index');
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
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
        // quitar esto de aqui        
        $nomina = $this->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));

        $this->set('nomina', $nomina);
    }

    function calcular() {
        $this->autoRender = false;
        if (!empty($this->data)) {
            $id = $this->data['nomina_id'];
            $nomina = $this->Nomina->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'id' => $id)
                    ));
            // OJO QUIZAS SEA MALA IDEA!
            // Para mantener las nominas con los cambios que se hagan
            $this->Nomina->generarNomina($id);
            $empleados = $this->Nomina->calcularNomina($id, $this->data['GRUPO'], $this->data['MODALIDAD']);
            
            if(empty($empleados)){
                $this->render('error', 'nomina');
                if($this->Nomina->errorMessage==''){
                    $this->Session->setFlash('Actualmente no existen datos suficientes para generar esta nomina', 'flash_error');
                }else{
                    $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
                }
                
            }
            
            $this->set(compact('empleados', 'nomina'));
            $this->render('pantalla', 'nomina');

            if (empty($this->data['GRUPO']) || empty($this->data['MODALIDAD'])) {
                $this->render('error', 'nomina');
                $this->Session->setFlash('Debe seleccionar el tipo de Personal, y la Modalidad de la nomina', 'flash_error');
            }
        }
    }

}

?>
