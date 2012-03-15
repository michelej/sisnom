<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Empleado', 'Contrato');
    
    function index() {
        $filtro=array();
        if(!empty($this->data)){
            if($this->data['Empleado']['Fopcion']==1){
               $filtro=array('Empleado.CEDULA LIKE'=>$this->data['Empleado']['valor']); 
            }
            if($this->data['Empleado']['Fopcion']==2){
               $filtro=array('Empleado.NOMBRE LIKE'=>$this->data['Empleado']['valor']); 
            }
            if($this->data['Empleado']['Fopcion']==3){
               $filtro=array('Empleado.APELLIDO LIKE'=>$this->data['Empleado']['valor']); 
            }
        }
        
        $this->Empleado->recursive = -1;        
        $data=$this->paginate('Empleado',$filtro);                
        $this->set('empleados',$data);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Empleado->save($this->data['Empleado'])) {
                $this->Session->setFlash('Empleado agregado');
                $this->redirect(array('action' => 'index'));                
            }
        }
    }

    function delete($id) {
        if ($this->Empleado->delete($id, true)) {
            $this->Session->setFlash('Empleado ' . $id . ' eliminado');
            $this->redirect(array('action' => 'index'));
        }
    }

    function view($id) {
        if (!$id) {
            $this->Session->setFlash(__('Empleado Invalido', true));
            $this->redirect(array('action' => 'index'));
        }        
        $empleado=$this->Empleado->findById($id);                
        $edad = $this->Empleado->Edad($empleado['Empleado']['FECHANAC']);
        $this->set(compact('empleado', 'edad'));
    }

    function edit($id) {
        $this->Empleado->id = $id;
        
        if (empty($this->data)) {                                    
            $this->data = $this->Empleado->Contrato->find('first',array('conditions'=>array('Contrato.FECHA_FIN'=>null)));            
        } else {
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}