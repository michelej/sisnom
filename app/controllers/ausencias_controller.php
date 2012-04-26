<?php 

class AusenciasController extends AppController {
    
    var $name = 'Ausencias';
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
            $empleado = $this->Ausencia->Empleado->find('first',array(
                'conditions'=>array(
                    'Empleado.id'=>$id
                ),
                'contain'=>array(
                    'Grupo'
                )
            ));
            $ausencias = $this->paginate('Ausencia');                        
            $this->set(compact('empleado','ausencias'));
        } 
    }
    
    function add(){                        
        $this->set("empleadoId",$this->params['named']['empleadoId']);
        if (!empty($this->data)) {                          
            if ($this->Ausencia->save($this->data['Ausencia'])) {
                $this->Session->setFlash('Ausencia agregada con exito','flash_success');                                
                $this->redirect('edit/' . $this->data['Ausencia']['empleado_id']);
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }                
    }
    
    function delete($id) {
         $empleadoid = $this->Ausencia->find('first', array(
            'conditions' => array(
                'Ausencia.id' => $id),
            'fields' => array(
                'Ausencia.empleado_id')
                ));
        if ($this->Ausencia->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Ausencia']['empleado_id']);
        }
    }
    
    function edit_ausencia($id){
        $this->set("id",$id);        
        if (empty($this->data)) {
            $this->data = $this->Ausencia->read();
        }else {
            if ($this->Ausencia->save($this->data)) {
                $this->Session->setFlash('Ausencia Modificada','flash_success');
                $this->redirect('edit/'.$this->data['Ausencia']['empleado_id']);
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }
    
}
?>