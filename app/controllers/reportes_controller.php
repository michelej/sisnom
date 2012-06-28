<?php

class ReportesController extends AppController {

    var $name = 'Reportes';
    var $helpers = array('Excel');
    var $uses = array('Empleado', 'Contrato', 'Recibo','Cargo','Departamento','Asignacion','Deduccion');
 
    function generar_reportes() {  
        $cargos=$this->Cargo->find('list');
        $departamentos=$this->Departamento->find('list');
        $asignaciones=$this->Asignacion->find('list');
        $deducciones=$this->Deduccion->find('list');
        if (!empty($this->data)) {                        
            $data=$this->Empleado->busqueda($this->data);                        
            $this->set('empleados', $data);            
            $this->render('archivo_reporte','nominaExcel');
        }
        $this->set(compact('cargos','departamentos','asignaciones','deducciones'));
    }
    
    function listado_persona(){
        $filtro = array();
        if (!empty($this->data)) {
            if ($this->data['Fopcion'] == 1) {
                $filtro = array('Empleado.CEDULA LIKE' => $this->data['valor']);
            }
            if ($this->data['Fopcion'] == 2) {
                $filtro = array('Empleado.NOMBRE LIKE' => "%" . $this->data['valor'] . "%");
            }
            if ($this->data['Fopcion'] == 3) {
                $filtro = array('Empleado.APELLIDO LIKE' => "%" . $this->data['valor'] . "%");
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

        $data = $this->paginate('Empleado', $filtro);
        $this->set('empleados', $data);
    }
    
    function reporte_persona($id=null){
        $informacion=$this->Empleado->find('first',array(
            'conditions'=>array(
                'id'=>$id
            )
        ));
    }

}

?>