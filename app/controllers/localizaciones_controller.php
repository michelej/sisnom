<?php

class LocalizacionesController extends AppController {

    var $name = 'Localizaciones';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
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
            'Empleado' => array(
                'limit' => 20,
                'contain' => array(
                    'Grupo',
                    'Localizacion' => array(
                        'Departamento'
                    ),
                    'Contrato' => array(
                        'Cargo', 'Departamento',
                        'order' => array(
                            'Contrato.FECHA_INI' => 'desc'),
                    )
                )
            )
        );

        $data = $this->paginate('Empleado', $filtro);
        $this->set('empleados', $data);
    }

    function edit($id = null) {
        $empleado = $this->Localizacion->Empleado->find('first', array(
            'conditions' => array(
                'Empleado.id' => $id),
            'contain' => array(
                'Localizacion' => array(
                    'Departamento')
            )
                )
        );

        if (!empty($this->data)) {

            if (empty($this->data['Localizacion']['departamento_id'])) {
                $id_loc = $empleado['Empleado']['localizacion_id'];
                //debug($this->data);                
                $this->Localizacion->Empleado->id = $empleado['Empleado']['id'];
                $this->Localizacion->Empleado->saveField('localizacion_id', null);
                $this->Localizacion->delete($id_loc, false);
                $this->Session->setFlash('Localizacion fisica modificada con exito', 'flash_success');
                $this->redirect(array('action' => 'index'));
                return;
            } else {
                if ($this->Localizacion->save($this->data['Localizacion'])) {
                    $empleado['Empleado']['localizacion_id'] = $this->Localizacion->id;
                    if ($this->Localizacion->Empleado->save($empleado['Empleado'])) {
                        $this->Session->setFlash('Localizacion fisica modificada con exito', 'flash_success');
                        $this->redirect(array('action' => 'index'));
                    }
                }
            }


            //$this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
        $departamentos = $this->Localizacion->Departamento->find('list');
        $this->set(compact('departamentos', 'empleado'));
    }

}