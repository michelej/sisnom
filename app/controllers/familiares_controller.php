<?php 

class FamiliaresController extends AppController {
    
    var $name = 'Familiares';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');    
    
    function index(){
        $filtro=array();
        if(!empty($this->data)){            
            if($this->data['Fopcion']==1){
               $filtro=array('Empleado.CEDULA LIKE'=>$this->data['valor']); 
            }
            if($this->data['Fopcion']==2){
               $filtro=array('Empleado.NOMBRE LIKE'=>$this->data['valor']); 
            }
            if($this->data['Fopcion']==3){
               $filtro=array('Empleado.APELLIDO LIKE'=>$this->data['valor']); 
            }
        }  
        
        $this->Familiar->Empleado->recursive = -1;         
        $data=$this->paginate('Empleado',$filtro);                
        $this->set('empleados',$data);
    }
    
    function edit($id=null){
        $this->Familiar->Empleado->Behaviors->attach('Containable');
        if (empty($this->data)) {
            /*$this->paginate=array(
                'Empleado' => array(
                    'type'=>'first',
                    'conditions'=>array(
                        'id' => $id),
                    'contain'=>array(
                        'Familiar'=>array(
                            'limit'=>1,
                        )
                    ),                                          
                )
            );*/
            $this->paginate=array(
                'Familiar' => array(  
                    'recursive'=>-1,
                    'limit'=>20,                                            
                    'conditions'=>array(
                        'empleado_id' => $id,                         
                    )                                          
                )
            );
            $this->Familiar->Empleado->recursive=-1;
            $empleado=$this->Familiar->Empleado->findById($id);            
            $familiares = $this->paginate('Familiar');                        
            $this->set(compact('empleado','familiares'));
        } 
    }
    
    function add($id=null){        
        $this->set("id",$id);
        if (!empty($this->data)) {            
            if ($this->Familiar->save($this->data['Familiar'])) {
                $this->Session->setFlash('Familiar agregado con exito','flash_success');                                
                $this->redirect('edit/' . $this->data['Familiar']['empleado_id']);
            }
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
    
    function editfami($id){
        $this->set("id",$id);        
        if (empty($this->data)) {
            $this->data = $this->Familiar->read();
        }else {
            if ($this->Familiar->save($this->data)) {
                $this->Session->setFlash('Familiar Modificado','flash_success');
                $this->redirect('edit/'.$this->data['Familiar']['empleado_id']);
            }
        }
    }
    

}