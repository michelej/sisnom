<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');    
    
    function index() {
        $filtro=array();
        if(!empty($this->data)){            
            if($this->data['Fopcion']==1){
               $filtro=array('Empleado.CEDULA LIKE'=>$this->data['valor']); 
            }
            if($this->data['Fopcion']==2){
               $filtro=array('Empleado.NOMBRE LIKE'=>"%".$this->data['valor']."%"); 
            }
            if($this->data['Fopcion']==3){
               $filtro=array('Empleado.APELLIDO LIKE'=>"%".$this->data['valor']."%"); 
            }
        }        
        $this->Empleado->recursive = -1;        
        $data=$this->paginate('Empleado',$filtro);                
        $this->set('empleados',$data);
    }

    function add() {
        if (!empty($this->data)) {             
            if ($this->Empleado->save($this->data['Empleado'])) {
                $this->Session->setFlash('Empleado agregado con exito','flash_success');
                $this->redirect(array('action' => 'index'));                
            }
        }
    }

    function delete($id) {
        if ($this->Empleado->delete($id, true)) {
            $this->Session->setFlash('Empleado eliminado','flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }

    function view($id) {
        if (!$id) {
            $this->Session->setFlash('Empleado Invalido', 'flash_error');
            $this->redirect(array('action' => 'index'));
        }        
        $empleado=$this->Empleado->findById($id);                        
        $this->set('empleado',$empleado);
    }

    function edit($id) {
        $this->Empleado->id = $id;        
        if (empty($this->data)) {                                                
            $this->data = $this->Empleado->read();
        } else {            
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado Modificado','flash_success');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
}
?>