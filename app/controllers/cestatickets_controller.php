<?php

class CestaticketsController extends AppController {

    var $name = 'Cestatickets';
    var $helpers = array('Excel', 'Javascript', 'Ajax');
    var $components = array('RequestHandler');

    function index() {
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

    function add() {
        if (!empty($this->data)) {
            if ($this->Cestaticket->save($this->data['Cestaticket'])) {
                $this->Session->setFlash('Cestaticket creada con exito', 'flash_success');
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
            'conditions' => array(
                'id' => $id),
             'contain'=>array(
                 'DetalleCestaticket'
             )));

        $this->set('cestaticket', $cestaticket);
    }

    function delete($id) {
        if ($this->Cestaticket->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('index');
        }
    }
    
    function generar($id=null){
        $this->autoRender=false;
        if(!empty($this->data)){
            $this->_generar($id);
        }
        $this->render('/cestatickets/loading');
    }

    function _generar($id = null) {
        $this->autoRender = false;
        $this->Cestaticket->generarCestaticket($id);

        if ($this->Cestaticket->errorMessage != '') {
            $this->Session->setFlash($this->Cestaticket->errorMessage, 'flash_error');
        } else {
            $this->Session->setFlash('Nomina generada con exito', 'flash_success');
            $this->Cestaticket->id = $id;
            $this->Cestaticket->saveField('FECHA_ELA', date("Y-m-d H:i:s"));
        }
        $this->redirect('edit/' . $id);
    }

    function mostrar() {
        $this->autoRender = false;
        if (!empty($this->data)) {
            $id = $this->data['cestaticket_id'];
            $cestaticket = $this->Cestaticket->find('first', array(
                'recursive' => 0,
                'conditions' => array(
                    'id' => $id)
                    )
            );
            $mes = $cestaticket['Cestaticket']['MES'];
            $año = $cestaticket['Cestaticket']['AÑO'];


            if (empty($this->data['PERSONAL']) || empty($this->data['VISUALIZAR'])) {
                $this->Session->setFlash('Debe seleccionar el personal y el modo de visualizar', 'flash_error');
                $this->render('error', 'nomina');
                return;
            } else {
                if ($this->data['PERSONAL'] == '1') {
                    $grupo = 'Empleado';  // Empleado                    
                    $modalidad = 'Fijo';
                }
                if ($this->data['PERSONAL'] == '2') {
                    $grupo = 'Obrero';  // Obrero                    
                    $modalidad = 'Fijo';
                }
                if ($this->data['PERSONAL'] == '3') {
                    $grupo = array('Empleado', 'Obrero');  // Empleado y Obrero                    
                    $modalidad = 'Contratado';
                }
                $empleados = $this->Cestaticket->mostrarCestaticket($id, $grupo, $modalidad);
                $resumen = $this->Cestaticket->calcularResumen($empleados);
            }

            if (empty($empleados)) {
                $this->render('error', 'nomina');
                if ($this->Nomina->errorMessage == '') {
                    $this->Session->setFlash('Actualmente no existen datos relacionados a esta nomina, Genere la Nomina primero', 'flash_error');
                } else {
                    $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
                }
                return;
            }

            if ($this->data['VISUALIZAR'] == 'Pantalla') {
                $this->set('empleados', $empleados);
                $this->render('pantalla_cestaticket', 'nomina');
            }
            if ($this->data['VISUALIZAR'] == 'Archivo') {
                $this->set(compact('empleados', 'modalidad', 'grupo', 'mes', 'año', 'resumen'));
                $this->render('archivo_cestaticket', 'nominaExcel');
            }
        }
    }

    function dia_adicional($id = null) {
        $filtro = array();
        if (!empty($this->data)) {
            $id = $this->data['cestaticket_id'];
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

        $ids = $this->Cestaticket->DetalleCestaticket->Empleado->find('all', array(
            'recursive' => 0,
            'conditions' => $filtro,
            'fields' => array('id')
                ));
        $id_empleados = Set::extract('/Empleado/id', $ids);
        $this->paginate = array(
            'DetalleCestaticket' => array(
                'limit' => 20,
                'conditions' => array(
                    'cestaticket_id' => $id,
                    'empleado_id' => $id_empleados,
                ),
                'contain' => array(
                    'Empleado' => array(
                        'Grupo',
                        'Contrato' => array(
                            'Cargo', 'Departamento',
                            'order' => array(
                                'Contrato.FECHA_INI' => 'desc'),
                        )
                    )
                )
            )
        );

        $data = $this->paginate('DetalleCestaticket');
        if (!empty($data)) {
            $this->set('empleados', $data);
        } else {
            $this->Session->setFlash('Actualmente no existen datos relacionados a esta nomina, Genere la Nomina primero', 'flash_error');
            $this->redirect('edit/' . $id);
        }
    }

    function add_dia_adicional($id = null) {
        $data = $this->Cestaticket->DetalleCestaticket->find('first', array(
            'conditions' => array(
                'DetalleCestaticket.id' => $id
            ),
            'contain' => array(
                'Cestaticket'
            )
                ));

        $data['DetalleCestaticket']['DIAS_ADICIONALES']++;
        $data['DetalleCestaticket']['TOTAL']+=$data['Cestaticket']['VALOR_DIARIO'];
        $this->Cestaticket->DetalleCestaticket->save($data['DetalleCestaticket']);
        $this->redirect('dia_adicional/' . $data['DetalleCestaticket']['cestaticket_id']);
    }

    function remove_dia_adicional($id = null) {
        $data = $this->Cestaticket->DetalleCestaticket->find('first', array(
            'recursive' => 0,
            'conditions' => array(
                'DetalleCestaticket.id' => $id
            )
                ));
        if ($data['DetalleCestaticket']['DIAS_ADICIONALES'] - 1 >= 0) {
            $data['DetalleCestaticket']['DIAS_ADICIONALES']--;
            $data['DetalleCestaticket']['TOTAL']-=$data['Cestaticket']['VALOR_DIARIO'];
            $this->Cestaticket->DetalleCestaticket->save($data['DetalleCestaticket']);
        }

        $this->redirect('dia_adicional/' . $data['DetalleCestaticket']['cestaticket_id']);
    }        
}

?>