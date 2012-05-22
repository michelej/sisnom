<?php

class NominasController extends AppController {

    var $name = 'Nominas';
    var $helpers = array('Excel');

    function index() {
        $filtro = array();
        if (!empty($this->data)) {
            if (!empty($this->data['AÑO']) && empty($this->data['Fopcion'])) {
                $filtro = array('Nomina.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
            if (!empty($this->data['Fopcion']) && empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Nomina.FECHA_INI)' => $this->data['Fopcion']);
            }
            if (!empty($this->data['Fopcion']) && !empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Nomina.FECHA_INI)' => $this->data['Fopcion'], 'Nomina.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
        }
        $this->paginate = array(
            'recursive' => -1,
            'limit' => 20,
            'order' => array(
                'FECHA_INI' => 'desc'
            ),
        );

        $data = $this->paginate('Nomina', $filtro);
        $this->set('nominas', $data);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Nomina->save($this->data['Nomina'])) {
                $this->Session->setFlash('Nomina creada con exito', 'flash_success');
                //$id = $this->Nomina->getLastInsertId();
                //$this->Nomina->generarNomina($id);
                $this->redirect('index');
            }
            if (!empty($this->Nomina->errorMessage)) {
                $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
    }

    function delete($id) {
        if ($this->Nomina->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('index');
        }
    }

    function edit($id = null) {
        // TODO: Verificar si existen cambios depues de creada la nomina ??????        
        $nomina = $this->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));

        $this->set('nomina', $nomina);
    }

    /**
     *  Genera toda la informacion referente a nomina Recibo -> Detalle de Recibo
     * @param type $id 
     */
    function generar($id = null) {
        $this->autoRender = false;
        $this->Nomina->generarNomina($id);

        if ($this->Nomina->errorMessage != '') {
            $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
        }
        $this->redirect('edit/' . $id);
    }

    /**
     *
     * @param type $tipo
     * @param type $id 
     */
    function mostrar($tipo = null, $id = null) {
        $this->autoRender = false;
        if ($tipo == 'pantalla') {
            $empleados = $this->Nomina->mostrarNomina($id);

            if (empty($empleados)) {
                $this->render('error', 'nomina');
                if ($this->Nomina->errorMessage == '') {
                    $this->Session->setFlash('Actualmente no existen datos relacionados a esta nomina, Genere la Nomina primero', 'flash_error');
                } else {
                    $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
                }
                return;
            }
            $this->set(compact('empleados'));
            $this->render('pantalla', 'nomina');
        }
    }

    /**
     * NO se esta usando
     * @return type 
     */
    function calcular() {
        $this->autoRender = false;
        if (!empty($this->data)) {
            $id = $this->data['nomina_id'];
            $nomina = $this->Nomina->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'id' => $id)
                    ));
            // OJO QUIZAS SEA MALA IDEA!
            // Para mantener las nominas con los cambios que se hagan
            $this->Nomina->generarNomina($id);


            if (empty($this->data['TIPO']) || empty($this->data['VISUALIZAR'])) {
                $this->Session->setFlash('Debe seleccionar el tipo de nomina y un el modo de visualizar', 'flash_error');
                $this->render('error', 'nomina');
                return;
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

                ////////////////////////////////////////////////////////////////
                $time = time();
                ////////////////////////////////////////////////////////////////
                $empleados = $this->Nomina->calcularNomina($id, $grupo, $modalidad);
                ////////////////////////////////////////////////////////////////
                $time_end = time() - $time;
                $tm = "TIEMPO: " . $time_end . " seg";
                $mem_usage = memory_get_usage(true);
                if ($mem_usage < 1024)
                    $mem = $mem_usage . " bytes";
                elseif ($mem_usage < 1048576)
                    $mem = round($mem_usage / 1024, 2) . " kilobytes";
                else
                    $mem = round($mem_usage / 1048576, 2) . " megabytes";
                ////////////////////////////////////////////////////////////////

                if (empty($empleados)) {
                    $this->render('error', 'nomina');
                    if ($this->Nomina->errorMessage == '') {
                        $this->Session->setFlash('Actualmente no existen datos suficientes para generar esta nomina', 'flash_error');
                    } else {
                        $this->Session->setFlash($this->Nomina->errorMessage, 'flash_error');
                    }
                    return;
                }
            }
            $extra['Calculo Nomina']['Tiempo'] = $tm;
            $extra['Calculo Nomina']['Memoria'] = $mem;

            $this->set(compact('empleados', 'extra'));
            if ($this->data['VISUALIZAR'] == 'Pantalla') {
                $this->render('pantalla', 'nomina');
            }
            if ($this->data['VISUALIZAR'] == 'Archivo') {
                $this->render('generar_archivo', 'nominaExcel');
            }
        }
    }

}

?>
