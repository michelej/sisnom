<?php 

class HorasExtrasController extends AppController {
    
    var $name = 'HorasExtras';
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
        
        $this->HorasExtra->Empleado->recursive = -1;         
        $data=$this->paginate('Empleado',$filtro);                
        $this->set('empleados',$data);
    }
    
    function edit($id=null){        
        if (empty($this->data)) {           
            $this->paginate=array(
                'Ausencia' => array(  
                    'recursive'=>-1,
                    'limit'=>20,                                            
                    'conditions'=>array(
                        'empleado_id' => $id,                         
                    )                                          
                )
            );
            $this->HorasExtra->Empleado->recursive=-1;
            $empleado=$this->HorasExtra->Empleado->findById($id);            
            $horasextras = $this->paginate('HorasExtra');                        
            $this->set(compact('empleado','horasextras'));
        } 
    }
    
    function add($id=null){        
        $this->set("id",$id);
        if (!empty($this->data)) {            
            if ($this->HorasExtra->save($this->data['HorasExtra'])) {
                $this->Session->setFlash('Hora Extra agregada con exito','flash_success');                                
                $this->redirect('edit/' . $this->data['HorasExtra']['empleado_id']);
            }
        }        
    }
    
    function delete($id) {
         $empleadoid = $this->HorasExtra->find('first', array(
            'conditions' => array(
                'HorasExtra.id' => $id),
            'fields' => array(
                'HorasExtra.empleado_id')
                ));
        if ($this->HorasExtra->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['HorasExtra']['empleado_id']);
        }
    }
    
    function edit_horaextra($id){
        $this->set("id",$id);        
        if (empty($this->data)) {
            $this->data = $this->HorasExtra->read();
        }else {
            if ($this->HorasExtra->save($this->data)) {
                $this->Session->setFlash('Hora Extra Modificada','flash_success');
                $this->redirect('edit/'.$this->data['HorasExtra']['empleado_id']);
            }
        }
    }
    
}
?>