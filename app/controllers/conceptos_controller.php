<?php

class ConceptosController extends AppController {

    var $name = 'Conceptos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Empleado', 'Asignacion');

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
                $filtro = array('Empleado.APELLIDO LIKE' => "%".$this->data['valor']."%");
            }
        }                
        $this->Empleado->Behaviors->attach('Containable');
        $this->paginate = array(
            'limit'=>20,            
            'contain' => array(
                'Grupo',
                'Contrato' => array(
                    'Cargo','Departamento',
                    'conditions' => array(
                        'FECHA_FIN' => NULL),
                    )                
            ));
        
        $data=$this->paginate('Empleado',$filtro);
        $this->set('empleados', $data);
    }

    function edit($id = null) {
        if (!empty($this->data)) {
            foreach ($this->data['Asignacion'] as $key => $asignacion) {
                if ($asignacion == 1) {                    
                    $this->Empleado->habtmAdd('Asignacion', $id, $key);
                } 
                if($asignacion == 0){                    
                    $this->Empleado->habtmDelete('Asignacion', $id, $key);  
                }
            }
            foreach ($this->data['Deduccion'] as $key => $deduccion) {
                if ($deduccion == 1) {
                    $this->Empleado->habtmAdd('Deduccion', $id, $key);
                } else {
                    $this->Empleado->habtmDelete('Deduccion', $id, $key);  
                }
            }
            $this->Session->setFlash('Se ha modificado con exito','flash_success');
            $this->redirect('index'); 
        }
        $this->Empleado->Behaviors->attach('Containable');
        $this->paginate = array(
            'Empleado' => array(
                'type' => 'first',
                'conditions' => array('Empleado.id' => $id),
                'contain' => array('Asignacion', 'Deduccion','Grupo'))
        );

        $empleado = $this->paginate('Empleado');
        $asignaciones = $this->Empleado->Asignacion->find('all', array('recursive' => -1));
        $deducciones = $this->Empleado->Deduccion->find('all', array('recursive' => -1));
        $this->set(compact('empleado', 'asignaciones', 'deducciones'));
    }

}
?>