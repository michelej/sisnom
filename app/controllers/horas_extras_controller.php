<?php

class HorasExtrasController extends AppController {

    var $name = 'HorasExtras';
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
            if ($this->data['mostrar'] == 1) {
                $hoy = date('d-m-Y');
                $ids = $this->HorasExtra->Empleado->Contrato->find('all', array(
                    'conditions' => array(
                        'OR' => array(
                            'Contrato.FECHA_FIN' => null,
                            'Contrato.FECHA_FIN >' => $hoy
                        ),
                        'AND' => array(
                            'Cargo.NOMBRE' => 'VIGILANTE'
                        )
                    )
                        ));
                $id_empleados = Set::extract('/Empleado/id', $ids);
            }
        }
        if (isset($id_empleados)) {
            $this->paginate = array(
                'limit' => 20,
                'conditions'=>array(
                  'Empleado.id'=>$id_empleados  
                ),
                'contain' => array(
                    'Grupo',
                    'Contrato' => array(
                        'Cargo', 'Departamento',
                        'order' => array(
                            'Contrato.FECHA_INI' => 'desc'),
                    )
                    ));
        } else {
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
        }


        $data = $this->paginate('Empleado', $filtro);
        $this->set('empleados', $data);
    }

    function edit($id = null) {
        if (empty($this->data)) {
            $this->paginate = array(
                'HorasExtra' => array(
                    'recursive' => -1,
                    'limit' => 20,
                    'conditions' => array(
                        'empleado_id' => $id,
                    )
                )
            );
            $empleado = $this->HorasExtra->Empleado->find('first', array(
                'conditions' => array(
                    'Empleado.id' => $id
                ),
                'contain' => array(
                    'Grupo'
                )
                    ));
            $horasextras = $this->paginate('HorasExtra');
            $this->set(compact('empleado', 'horasextras'));
        }
    }

    function add() {
        $this->set("empleadoId", $this->params['named']['empleadoId']);
        if (!empty($this->data)) {
            if ($this->HorasExtra->save($this->data['HorasExtra'])) {
                $this->Session->setFlash('Hora Extra agregada con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['HorasExtra']['empleado_id']);
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

    function delete($id) {
        $empleadoid = $this->HorasExtra->find('first', array(
            'conditions' => array(
                'HorasExtra.id' => $id),
            'fields' => array(
                'HorasExtra.empleado_id')
                ));
        if ($this->HorasExtra->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['HorasExtra']['empleado_id']);
        }
    }

    function edit_horaextra($id) {
        $this->set("id", $id);
        if (empty($this->data)) {
            $this->data = $this->HorasExtra->read();
        } else {
            if ($this->HorasExtra->save($this->data)) {
                $this->Session->setFlash('Hora Extra Modificada', 'flash_success');
                $this->redirect('edit/' . $this->data['HorasExtra']['empleado_id']);
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

}

?>