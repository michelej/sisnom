<?php 

class FamiliaresController extends AppController {
    
    var $name = 'Familiares';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');    
    
    function index(){
        
    }
    
    function edit($id=null){        
        if (empty($this->data)) {           
            $this->paginate=array(
                'Familiar' => array(  
                    'recursive'=>-1,
                    'limit'=>20,                                            
                    'conditions'=>array(
                        'empleado_id' => $id,                         
                    )                                          
                )
            );
            
            $empleado = $this->Familiar->Empleado->find('first',array(
                'conditions'=>array(
                    'Empleado.id'=>$id
                ),
                'contain'=>array(
                    'Grupo'
                )
            ));                        
            $familiares = $this->paginate('Familiar');                        
            $this->set(compact('empleado','familiares'));
        } 
    }
    
    function add(){        
        $this->set("empleadoId",$this->params['named']['empleadoId']);        
        if (!empty($this->data)) {
            // HACK para que esto no sea considerado un Update sino un Nuevo Record
            unset($this->Familiar->id);
            if ($this->Familiar->save($this->data['Familiar'])) {
                $this->Session->setFlash('Familiar agregado con exito','flash_success');                                
                $this->redirect('edit/' . $this->data['Familiar']['empleado_id']);
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }        
    }
    
     function delete($id) {
         $empleadoid = $this->Familiar->find('first', array(
            'conditions' => array(
                'Familiar.id' => $id),
            'fields' => array(
                'Familiar.empleado_id')
                ));
        if ($this->Familiar->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Familiar']['empleado_id']);
        }
    }
    
    function edit_familiar($id){
        $this->set("id",$id);        
        if (empty($this->data)) {
            $this->data = $this->Familiar->read();
        }else {
            if ($this->Familiar->save($this->data)) {
                $this->Session->setFlash('Familiar Modificado','flash_success');
                $this->redirect('edit/'.$this->data['Familiar']['empleado_id']);
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
    }   
}
?>