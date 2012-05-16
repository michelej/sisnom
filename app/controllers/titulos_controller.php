<?php

class TitulosController extends AppController {

    var $name = 'Titulos';    
    /**
     * No Implementado 
     */
    function index() {
        
    }
    /**
     * Muestra el listado de los titulos academicos que posee el empleado id
     * @param type $id Id del empleado
     */    
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
    /**
     * Eliminar el titulo
     * @param type $id Id del titulo
     */    
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
    /**
     *  Agregar un titulo al empleado (empleadoId)
     */    
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
    /**
     * Modificar el titulo id
     * @param type $id Id del titulo
     */    
    function edit_titulo($id){
        $this->set("id",$id);        
        if (empty($this->data)) {
            $this->data = $this->Titulo->read();
        }else {
            if ($this->Titulo->save($this->data)) {
                $this->Session->setFlash('Titulo modificado','flash_success');
                $this->redirect('edit/'.$this->data['Titulo']['empleado_id']);
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
    }
}
?>