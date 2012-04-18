<?php

class TribunalesController extends AppController {

    var $name = 'Tribunales';
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
                'Tribunal' => array(
                    'conditions' => array(
                        'empleado_id' => $id),
                    'limit' => 20,
                    'order' => array(
                        'Tribunal.FECHA' => 'desc')
                )
            );
            $tribunales = $this->paginate('Tribunal');
            $empleado = $this->Tribunal->Empleado->find('first',array(
                'conditions'=>array(
                    'Empleado.id'=>$id
                ),
                'contain'=>array(
                    'Grupo'
                )
            ));
            
            $this->set(compact('tribunales', 'empleado'));
        }
    }
    
     function delete($id) {
        $empleadoid = $this->Tribunal->find('first', array('conditions' => array('Tribunal.id' => $id), 'fields' => array('Tribunal.empleado_id')));
        if ($this->Tribunal->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Tribunal']['empleado_id']);
        }
    }
    
    function add($id = null) {
        $this->set("id", $id);
        if (!empty($this->data)) {
            if ($this->Tribunal->save($this->data['Tribunal'])) {
                $this->Session->setFlash('Deduccion agregada con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Tribunal']['empleado_id']);
            }
            if (!empty($this->Tribunal->errorMessage)) {
                $this->Session->setFlash($this->Tribunal->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }        
    }

}

?>