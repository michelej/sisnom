<?php

class NominasController extends AppController {

    var $name = 'Nominas';

    function index() {
        $this->paginate=array(            
            'recursive'=>-1,
            'limit'=>20,
            'order'=>array(
                'FECHA_INI'=>'asc'
            ),
        );
        
        $data = $this->paginate('Nomina');
        $this->set('nominas', $data);
    }
    
    function add(){                
        if (!empty($this->data)) {            
            if ($this->Nomina->save($this->data['Nomina'])) {
                $this->Session->setFlash('Nomina creada con exito','flash_success');                                
                $this->redirect('index');
            }
            $this->Session->setFlash($this->Nomina->errorMessage,'flash_error');
        }                 
    }
    
    function delete($id) {        
        if ($this->Nomina->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('index');
        }
    }

}

?>
