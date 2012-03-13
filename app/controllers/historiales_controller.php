<?php

class HistorialesController extends AppController {

    var $name = 'Historiales';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Historial', 'Cargo');

    function index() {
        $this->Historial->Cargo->recursive = -1;
        $this->set('cargos', $this->paginate('Cargo'));
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Cargo->save($this->data)) {
                $this->Session->setFlash('Cargo agregado');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function delete($id) { 
        $cargoid=$this->Historial->find('first',array('conditions'=>array('Historial.id'=>$id),'fields'=>array('Historial.cargo_id')));        
        if ($this->Historial->delete($id)) {            
            $this->Session->setFlash(__('Historial ' . $id . ' eliminado',true));
            $this->redirect('edit/'.$cargoid['Historial']['cargo_id']);
        }
    }

    function edit($id=null) {        
        if (empty($this->data)) {
            $this->Historial->recursive = -1;
            $this->Historial->Cargo->recursive = -1;
            
            $historiales = $this->Historial->find('all',array(
                'conditions'=>array('cargo_id'=>$id),
                'order'=>'Historial.FECHA_INI'
                ));
            $cargo = $this->Historial->Cargo->findById($id);
            $this->set(compact('historiales', 'cargo'));
        } else {            
            if ($this->Historial->save($this->data)) {
                $this->Session->setFlash('Historial Guardado.');                
                $this->redirect('edit/'.$this->data['Historial']['cargo_id']);
            }
            $this->Session->setFlash('Error en las FECHAS');  // Mostrar Error
            $this->redirect('edit/'.$this->data['Historial']['cargo_id']);
        }
    }

}

?>
