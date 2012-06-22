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

}

?>