<?php

class FeriadosController extends AppController {

    var $name = 'Feriados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $this->paginate=array(            
            'limit'=>20,
            'order'=>array(
                'Feriado.FECHA'=>'desc'
            )
        );
        
        $data=$this->paginate();        
        $this->set('feriados', $data);
    }
    
    function add() {
        if (!empty($this->data)) {            
            if ($this->Feriado->save($this->data)) {
                $this->Session->setFlash('Feriado agregado con exito','flash_success');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function delete($id) {
        if ($this->Feriado->delete($id)) {
            $this->Session->setFlash('Feriado eliminado','flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }

    function edit($id) {
        $this->Feriado->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Feriado->read();
        } else {
            if ($this->Feriado->save($this->data)) {
                $this->Session->setFlash('Feriado Modificado','flash_success');
                $this->redirect(array('action' => 'index'));
            }
        }
    }   
}

?>
