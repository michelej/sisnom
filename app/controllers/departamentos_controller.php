<?php

class DepartamentosController extends AppController {

    var $name = 'Departamentos';

    /**
     * 
     */
    function index() {
        $this->paginate = array(
            'limit' => 20,
            'order' => array(
                'Departamento.id' => 'asc'
            ),
            'contain' => array(
                'Programa'
            )
        );
        $data = $this->paginate();
        $this->set('departamentos', $data);
    }

    /**
     * 
     */
    function add() {
        if (!empty($this->data)) {
            if ($this->Departamento->save($this->data)) {
                $this->Session->setFlash('Departamento agregado con exito', 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

    function delete($id) {
        if ($this->Departamento->delete($id)) {
            $this->Session->setFlash('Departamento eliminado', 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     *
     * @param type $id 
     */
    function edit($id) {
        $this->Departamento->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Departamento->read();
        } else {
            if ($this->Departamento->save($this->data)) {
                $this->Session->setFlash('Departamento Modificado', 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

    function asignar($id) {
        $this->Departamento->id = $id;
        if (!empty($this->data)) {
            if ($this->Departamento->save($this->data)) {
                $this->Session->setFlash('Departamento Modificado', 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
        $departamento = $this->Departamento->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id
            )
                ));
        $data = $this->Departamento->Programa->find('all', array(
            'recursive' => -1)
        );
        if (empty($data)) {
            $programas = array();
        } else {
            foreach ($data as $value) {
                $programas[$value['Programa']['id']] = "Programa " . $value['Programa']['CODIGO'] . " / " . $value['Programa']['TIPO'] . " " . $value['Programa']['NUMERO'] . " - " . $value['Programa']['NOMBRE'];
            }
        }

        $this->set(compact("programas", "id", "departamento"));
    }

}

?>