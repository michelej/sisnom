<?php 

class EventualidadesController extends AppController{
    
    var $name='Eventualidades';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax','Javascript');
    var $uses = array('Eventualidad','Empleado');
    
    function index(){
        $this->paginate = array(
            'limit' => 20,);
        
        $data=$this->paginate('Eventualidad');                
        $this->set('eventualidades',$data);
    }
    
    function add() {        
        if (!empty($this->data)) {             
            if ($this->Eventualidad->save($this->data['Eventualidad'])) {
                $this->Session->setFlash('Eventualidad agregada con exito','flash_success');
                $this->redirect(array('action' => 'index'));                
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }        
    }
    
    function delete($id) {
        if ($this->Eventualidad->delete($id, true)) {
            $this->Session->setFlash('Eventualidad eliminada','flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }
    
    function listado($id=null){
        $eventualidad=$this->Eventualidad->find('first',array(
            'recursive'=>0,
            'conditions'=>array(
                'id'=>$id
            )
        ));
        
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
            'Empleado'=>array(
            'limit' => 20,
            'contain' => array(
                'Grupo',
                'Contrato' => array(                    
                    'Cargo', 'Departamento',
                    'order' => array(
                        'Contrato.FECHA_INI' => 'desc'),
                )
                )));
        
        $empleados=$this->paginate('Empleado',$filtro);                        
        $this->set(compact('empleados','eventualidad'));
    }
    
    function editar($eventualidad_id,$empleado_id){
        $empleado=$this->Empleado->find('first',array(
            'recursive'=>0,
            'conditions'=>array(
                'Empleado.id'=>$empleado_id
            )
        ));
        $event=$this->Eventualidad->find('first',array(
            'recursive'=>0,
            'conditions'=>array(
                'id'=>$eventualidad_id
            )
        ));
        
        $this->paginate=array(
            'DetalleEventualidad'=>array(
                'limit'=>20,
                'conditions'=>array(
                    'empleado_id'=>$empleado_id,
                    'eventualidad_id'=>$eventualidad_id,
                )                
            )
        );
        $eventualidades=$this->paginate('DetalleEventualidad');        
        $this->set(compact('empleado','eventualidades','eventualidad_id','event'));
    }
    
    function asignar($eventualidad_id,$empleado_id){
        if (!empty($this->data)) {             
            if ($this->Eventualidad->DetalleEventualidad->save($this->data['DetalleEventualidad'])) {
                $this->Session->setFlash('Eventualidad agregada con exito','flash_success');
                $this->redirect(array('action' => 'editar',$eventualidad_id,$empleado_id));                
            }
            if (!empty($this->Eventualidad->DetalleEventualidad->errorMessage)) {
                $this->Session->setFlash($this->Eventualidad->DetalleEventualidad->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }            
        }          
        $this->set(compact('eventualidad_id','empleado_id'));
    }
    
    function quitar($id) {
        $detalle=$this->Eventualidad->DetalleEventualidad->find("first",array(
            'recursive'=>0,
            'conditions'=>array(
                'DetalleEventualidad.id'=>$id
            )
        ));
        if ($this->Eventualidad->DetalleEventualidad->delete($id, true)) {
            $this->Session->setFlash('Eventualidad eliminada','flash_success');
            $this->redirect(array('action' => 'editar',$detalle['DetalleEventualidad']['eventualidad_id'],$detalle['DetalleEventualidad']['empleado_id']));
        }
    }
    
    
}
?>