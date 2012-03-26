<?php

class TitulosController extends AppController {

    var $name = 'Titulos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $filtro = array();
        if (!empty($this->data)) {
            if ($this->data['Fopcion'] == 1) {
                $filtro = array('Empleado.CEDULA LIKE' => $this->data['valor']);
            }
            if ($this->data['Fopcion'] == 2) {
                $filtro = array('Empleado.NOMBRE LIKE' => "%".$this->data['valor']."%");
            }
            if ($this->data['Fopcion'] == 3) {
                $filtro = array('Empleado.APELLIDO LIKE' =>"%".$this->data['valor']."%");
            }
        }

        $this->Titulo->Empleado->recursive = -1;
        $data = $this->paginate('Empleado', $filtro);
        $this->set('empleados', $data);
    }
    
    function edit($id=null){
        $this->Titulo->Empleado->Behaviors->attach('Containable');
        if (empty($this->data)) {           
            $this->paginate=array(
                'Titulo' => array(  
                    'recursive'=>-1,
                    'limit'=>20,                                            
                    'conditions'=>array(
                        'empleado_id' => $id,                         
                    )                                          
                )
            );
            $this->Titulo->Empleado->recursive=-1;
            $empleado=$this->Titulo->Empleado->findById($id);            
            $titulos = $this->paginate('Titulo');                        
            $this->set(compact('empleado','titulos'));
        } 
    }
    
    function delete($id) {
         $empleadoid = $this->Titulo->find('first', array(
            'conditions' => array(
                'Titulo.id' => $id),
            'fields' => array(
                'Titulo.empleado_id')
                ));
        if ($this->Titulo->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Titulo']['empleado_id']);
        }
    }
    
    function add($id=null){        
        $this->set("id",$id);
        if (!empty($this->data)) {            
            if ($this->Titulo->save($this->data['Titulo'])) {
                $this->Session->setFlash('Titulo agregado con exito','flash_success');                                
                $this->redirect('edit/' . $this->data['Titulo']['empleado_id']);
            }
        }        
    }
    
    function edit_titulo($id){
        $this->set("id",$id);        
        if (empty($this->data)) {
            $this->data = $this->Titulo->read();
        }else {
            if ($this->Titulo->save($this->data)) {
                $this->Session->setFlash('Titulo Modificado','flash_success');
                $this->redirect('edit/'.$this->data['Titulo']['empleado_id']);
            }
        }
    }
}
?>