<?php 

class CestaticketsController extends AppController{
    
    var $name = 'Cestatickets';
    
    function index(){
        $filtro = array();
        if (!empty($this->data)) {
            if (!empty($this->data['AÑO']) && empty($this->data['Fopcion'])) {
                $filtro = array('Cestaticket.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
            if (!empty($this->data['Fopcion']) && empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Cestaticket.FECHA_INI)' => $this->data['Fopcion']);
            }
            if (!empty($this->data['Fopcion']) && !empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Cestaticket.FECHA_INI)' => $this->data['Fopcion'], 'Cestaticket.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
        }
        $this->paginate = array(
            'recursive' => -1,
            'limit' => 20,
            'order' => array(
                'FECHA_INI' => 'desc'
            ),
        );

        $data = $this->paginate('Cestaticket', $filtro);
        $this->set('cestatickets', $data);
    }
    
    function add(){
        if (!empty($this->data)) {
            if ($this->Cestaticket->save($this->data['Cestaticket'])) {
                $this->Session->setFlash('Cestaticket creada con exito', 'flash_success');
                $id = $this->Cestaticket->getLastInsertId();
                $this->Cestaticket->generarCestaticket($id);
                $this->redirect('index');
            }
            if (!empty($this->Cestaticket->errorMessage)) {
                $this->Session->setFlash($this->Cestaticket->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
    }
    
    function edit($id = null) {
        // TODO: Verificar si existen cambios depues de creada la nomina ??????        
        $cestaticket = $this->Cestaticket->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));

        $this->set('cestaticket', $cestaticket);
    }
    
    function delete($id) {
        if ($this->Cestaticket->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('index');
        }
    }
    
    function generar($id = null) {
        $this->autoRender = false;
        $this->Cestaticket->generarCestaticket($id);

        if ($this->Cestaticket->errorMessage != '') {
            $this->Session->setFlash($this->Cestaticket->errorMessage, 'flash_error');
        } else {
            $this->Session->setFlash('Nomina generada con exito', 'flash_success');
        }
        $this->redirect('edit/' . $id);
    }

    
    function calcular(){
         $this->autoRender = false;
        if (!empty($this->data)) {
            $id = $this->data['cestaticket_id'];
            $cestaticket = $this->Cestaticket->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'id' => $id)
                    ));
            // OJO QUIZAS SEA MALA IDEA!
            // Para mantener las nominas con los cambios que se hagan
            $this->Cestaticket->generarCestaticket($id);


            if (empty($this->data['TIPO']) || empty($this->data['VISUALIZAR'])) {
                $this->Session->setFlash('Debe seleccionar el tipo de nomina y un el modo de visualizar', 'flash_error');
                $this->render('error', 'nomina');
                return ;
            } else {
                if ($this->data['TIPO'] == '1') {
                    $grupo = '1';  // Empleado
                    $modalidad = 'Fijo';
                }
                if ($this->data['TIPO'] == '2') {
                    $grupo = '2';  // Obrero
                    $modalidad = 'Fijo';
                }
                if ($this->data['TIPO'] == '3') {
                    $grupo = array(1, 2);  // Empleado y Obrero
                    $modalidad = 'Contratado';
                }                
                
                $empleados = $this->Cestaticket->calcularCestaticket($id, $grupo, $modalidad);                
                debug($empleados);
                /*if (empty($empleados)) {
                    $this->render('error', 'nomina');
                    if ($this->Nomina->errorMessage == '') {
                        $this->Session->setFlash('Actualmente no existen datos suficientes para generar esta nomina', 'flash_error');
                    } else {
                        $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
                    }
                    return ;                    
                }*/
            }
            /*            
            $this->set(compact('empleados','extra'));
            if ($this->data['VISUALIZAR'] == 'Pantalla') {
                $this->render('pantalla', 'nomina');
            }
            if ($this->data['VISUALIZAR'] == 'Archivo') {
                $this->render('generar_archivo', 'nominaExcel');
            }             
             */
        }
    }
}
?>