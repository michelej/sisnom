<?php

class ContratosController extends AppController {

    var $name = 'Contratos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    
    function index() {
        $filtro = array();
        if (!empty($this->data)) {            
            if ($this->data['Fopcion'] == 1) {
                $filtro = array('Empleado.CEDULA LIKE' => $this->data['valor']);
            }
            if ($this->data['Fopcion'] == 2) {
                $filtro = array('Empleado.NOMBRE LIKE' => $this->data['valor']);
            }
            if ($this->data['Fopcion'] == 3) {
                $filtro = array('Empleado.APELLIDO LIKE' => $this->data['valor']);
            }
        }
        $this->Contrato->Empleado->Behaviors->attach('Containable');
        $this->paginate = array(
            'limit'=>20,            
            'contain' => array(
                'Contrato' => array(
                    'Cargo','Departamento',
                    'conditions' => array(
                        'FECHA_FIN' => NULL),
                    )                
            ));
        
        $data=$this->paginate('Empleado',$filtro);
        $this->set('empleados', $data);
    }

    function delete($id) {
        $empleadoid = $this->Contrato->find('first', array('conditions' => array('Contrato.id' => $id), 'fields' => array('Contrato.empleado_id')));
        if ($this->Contrato->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito','flash_success');
            $this->redirect('edit/' . $empleadoid['Contrato']['empleado_id']);
        }
    }

    function edit($id=null) {        
        if (empty($this->data)) {
            $this->Contrato->Empleado->recursive = -1;
            $this->paginate=array(
                'Historial' => array(                    
                    'conditions'=>array(
                        'empleado_id' => $id),
                    'limit' => 20,
                    'order' => array(
                        'Contrato.FECHA_INI' => 'asc')
                )
            );
            $contratos = $this->paginate('Contrato');
            $empleado = $this->Contrato->Empleado->findById($id);
            $cargos = $this->Contrato->Cargo->find('list');
            $departamentos = $this->Contrato->Departamento->find('list');
            $this->set(compact('contratos', 'empleado', 'cargos', 'departamentos'));
        } else {                                               
            if ($this->Contrato->save($this->data)) {
                $this->Session->setFlash('Se ha agregado con exito','flash_success');
                $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
            }            
            if(!empty($this->Contrato->validationErrors)){                
                $error="";
                foreach ($this->Contrato->validationErrors as $value) {
                    $error=$error."* ".$value;
                    $error=$error."<br />";
                }
                $this->Contrato->errorMessage=$error;
            }
            $this->Session->setFlash($this->Contrato->errorMessage,'flash_error');  // Mostrar Error
            $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
        }
    }

}

?>
