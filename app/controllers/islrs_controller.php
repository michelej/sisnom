<?php

class IslrsController extends AppController {

    var $name = 'Islrs';
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
                'Islr' => array(
                    'conditions' => array(
                        'empleado_id' => $id),
                    'limit' => 20,
                    'order' => array(
                        'Islr.FECHA' => 'desc')
                )
            );
            $islrs = $this->paginate('Islr');
            $empleado = $this->Islr->Empleado->find('first',array(
                'conditions'=>array(
                    'Empleado.id'=>$id
                ),
                'contain'=>array(
                    'Grupo'
                )
            ));
            
            $this->set(compact('islrs', 'empleado'));
        }
    }
    
     function delete($id) {
        $empleadoid = $this->Islr->find('first', array('conditions' => array('Islr.id' => $id), 'fields' => array('Islr.empleado_id')));
        if ($this->Islr->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Islr']['empleado_id']);
        }
    }
    
    function add() {
        $this->set("empleadoId",$this->params['named']['empleadoId']);
        if (!empty($this->data)) {
            if ($this->Islr->save($this->data['Islr'])) {
                $this->Session->setFlash('ISLR agregada con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Islr']['empleado_id']);
            }
            if (!empty($this->Islr->errorMessage)) {
                $this->Session->setFlash($this->Islr->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }        
    }

}

?>