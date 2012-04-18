<?php

class ComercialesController extends AppController {

    var $name = 'Comerciales';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    
    function index(){
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
                    'conditions' => array(
                        'FECHA_FIN' => NULL),                    
                )
                ));
        
        $data=$this->paginate('Empleado',$filtro);                
        $this->set('empleados',$data);
    }
    
    function edit($id = null) {
        if (empty($this->data)) {
            $this->paginate = array(
                'Comercial' => array(
                    'conditions' => array(
                        'empleado_id' => $id),
                    'limit' => 20,
                    'order' => array(
                        'Comercial.FECHA' => 'desc')
                )
            );
            $comerciales = $this->paginate('Comercial');
            $empleado = $this->Comercial->Empleado->find('first',array(
                'conditions'=>array(
                    'Empleado.id'=>$id
                ),
                'contain'=>array(
                    'Grupo'
                )
            ));
            
            $this->set(compact('comerciales', 'empleado'));
        } 
    }
    
     function delete($id) {
        $empleadoid = $this->Comercial->find('first', array('conditions' => array('Comercial.id' => $id), 'fields' => array('Comercial.empleado_id')));
        if ($this->Comercial->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Comercial']['empleado_id']);
        }
    }
    
    function add($id = null) {
        $this->set("id", $id);
        if (!empty($this->data)) {
            if ($this->Comercial->save($this->data['Comercial'])) {
                $this->Session->setFlash('Credito agregado con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Comercial']['empleado_id']);
            }
            if (!empty($this->Comercial->errorMessage)) {
                $this->Session->setFlash($this->Comercial->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }        
    }

}

?>