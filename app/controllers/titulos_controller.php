<?php

class TitulosController extends AppController {

    var $name = 'Titulos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        
    }
    
    function edit($id=null){        
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
            $empleado = $this->Titulo->Empleado->find('first',array(
                'conditions'=>array(
                    'Empleado.id'=>$id
                ),
                'contain'=>array(
                    'Grupo'
                )
            ));            
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
    
    function add(){        
        $this->set("empleadoId",$this->params['named']['empleadoId']);
        if (!empty($this->data)) {            
            if ($this->Titulo->save($this->data['Titulo'])) {
                $this->Session->setFlash('Titulo agregado con exito','flash_success');                                
                $this->redirect('edit/' . $this->data['Titulo']['empleado_id']);
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
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
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
    }
}
?>