<?php

class PrestamosController extends AppController {

    var $name = 'Prestamos';
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
                    'order' => array(
                        'Contrato.FECHA_INI' => 'desc'),                    
                )
                ));
        
        $data=$this->paginate('Empleado',$filtro);                
        $this->set('empleados',$data);
    }
    
    function edit($id = null) {
        if (empty($this->data)) {
            $this->paginate = array(
                'Prestamo' => array(
                    'conditions' => array(
                        'empleado_id' => $id),
                    'limit' => 20,
                    'order' => array(
                        'Prestamo.FECHA' => 'desc')
                )
            );
            $prestamos = $this->paginate('Prestamo');
            $empleado = $this->Prestamo->Empleado->find('first',array(
                'conditions'=>array(
                    'Empleado.id'=>$id
                ),
                'contain'=>array(
                    'Grupo'
                )
            ));
            
            $this->set(compact('prestamos', 'empleado'));
        }
    }
    
     function delete($id) {
        $empleadoid = $this->Prestamo->find('first', array('conditions' => array('Prestamo.id' => $id), 'fields' => array('Prestamo.empleado_id')));
        if ($this->Prestamo->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Prestamo']['empleado_id']);
        }
    }
    
    function add() {
        $this->set("empleadoId",$this->params['named']['empleadoId']);
        if (!empty($this->data)) {
            if ($this->Prestamo->save($this->data['Prestamo'])) {
                $this->Session->setFlash('Prestamo agregado con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Prestamo']['empleado_id']);
            }
            if (!empty($this->Prestamo->errorMessage)) {
                $this->Session->setFlash($this->Prestamo->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }        
    }

}

?>