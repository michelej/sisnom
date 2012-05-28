<?php

class ProgramasController extends AppController {

    var $name = 'Programas';
    
    /**
     * 
     */
    function index(){
        $this->paginate=array(
            'recursive'=>0,
            'limit'=>20,
            'order'=>array(
                'Programa.id'=>'asc'
            )
        );
        $data=$this->paginate();
        $this->set('programas', $data);        
    }
    
    /**
     * 
     */
    function add() {
        if (!empty($this->data)) {            
            if ($this->Programa->save($this->data)) {
                $this->Session->setFlash('Programa agregado con exito','flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

    function delete($id) {
        $departamentos=$this->Programa->find('first',array(
            'conditions'=>array(
                'id'=>$id
            ),
            'contain'=>array(
                'Departamento'
            )
        ));        
        if(!empty($departamentos['Departamento'])){
            foreach ($departamentos['Departamento'] as $departamento) {                
                $this->Programa->Departamento->create();
                $departamento['programa_id']=null;
                $this->Programa->Departamento->save($departamento);
            }
        }        
        
        if ($this->Programa->delete($id)) {
            $this->Session->setFlash('Programa eliminado','flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }
   /**
    *
    * @param type $id 
    */
    function edit($id) {
        $this->Programa->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Programa->read();                        
        } else {
            if ($this->Programa->save($this->data)) {
                $this->Session->setFlash('Programa Modificado','flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }
}  