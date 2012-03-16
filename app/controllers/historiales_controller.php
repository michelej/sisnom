<?php

class HistorialesController extends AppController {

    var $name = 'Historiales';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Historial', 'Cargo');
    var $paginate = array(
        'Historial' => array(
            'limit' => 20,
            'order' => array(
                'Historial.FECHA_INI' => 'asc')
        )
    );

    function index() {        
        $this->Cargo->Behaviors->attach('Containable');
        
        $this->paginate = array(
            'contain' =>array(
                'Historial'=>array(
                    'conditions'=>array(
                        'FECHA_FIN'=>NULL))
                ));
        
        $data = $this->paginate('Cargo');        
        $this->set('cargos', $data);
    }

    function delete($id) {
        $cargoid = $this->Historial->find('first', array(
            'conditions' => array(
                'Historial.id' => $id), 
            'fields' => array(
                'Historial.cargo_id')
            ));
        if ($this->Historial->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito','flash_success');
            $this->redirect('edit/' . $cargoid['Historial']['cargo_id']);
        }
    }

    function edit($id = null) {
        if (empty($this->data)) {
            $this->Historial->recursive = -1;
            $this->Cargo->recursive = -1;            
            
            $historiales = $this->paginate('Historial', array(
                'cargo_id' => $id,
                    ));

            $cargo = $this->Cargo->findById($id);
            $this->set(compact('historiales', 'cargo'));
        } else {
            if ($this->Historial->save($this->data)) {
                $this->Session->setFlash('Se ha agregado con exito','flash_success');
                $this->redirect('edit/' . $this->data['Historial']['cargo_id']);
            }            
            // errorMessage desde el modelo
            $this->Session->setFlash($this->Historial->errorMessage,'flash_error');  
            $this->redirect('edit/' . $this->data['Historial']['cargo_id']);
        }
    }

}

?>
