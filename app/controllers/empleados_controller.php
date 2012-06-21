<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax','Javascript');    
    
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
        $this->paginate = array(
            'limit' => 20,
            'contain' => array(
                'Grupo',
                'Contrato' => array(                    
                    'Cargo', 'Departamento',
                    'order' => array(
                        'Contrato.FECHA_INI' => 'desc'),
                )
                ));
        
        $data=$this->paginate('Empleado',$filtro);                
        $this->set('empleados',$data);
    }

    function add() {        
        if (!empty($this->data)) {             
            if ($this->Empleado->save($this->data['Empleado'])) {
                $this->Session->setFlash('Empleado agregado con exito','flash_success');
                $this->redirect(array('action' => 'index'));                
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
        $grupos=$this->Empleado->Grupo->find('list');
        $this->set('grupos',$grupos);
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
        $empleado=$this->Empleado->find('first',array(
            'recursive'=>-1,
            'conditions'=>array(
                'Empleado.id'=>$id
            )
        ));                        
        $this->set('empleado',$empleado);
    }

    function edit($id) {
        $this->Empleado->id = $id;        
        if (empty($this->data)) {            
            $this->data = $this->Empleado->read();
            $grupos=$this->Empleado->Grupo->find('list');
            $this->set('grupos',$grupos);
        } else {            
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado Modificado','flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
    }
}
?>