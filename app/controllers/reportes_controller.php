<?php

class ReportesController extends AppController {

    var $name = 'Reportes';
    var $helpers = array('Excel');
    var $uses = array('Empleado', 'Contrato', 'Recibo');

    function listados() {
        if (!empty($this->data)) {
            if ($this->data['TIPO'] == '1') {
                $grupo = "Empleado";
                $modalidad = "Fijo";
            }
            if ($this->data['TIPO'] == '2') {
                $grupo = "Obrero";
                $modalidad = "Fijo";
            }
            if ($this->data['TIPO'] == '3') {
                $grupo = array("Empleado", "Obrero");                
                $modalidad = "Contratado";
            }

            if ($this->data['MODO'] == "1") {
                if(is_array($grupo)){
                    $grupo="Todos";
                }
                $this->redirect('pantalla_listado/' . $grupo . "/" . $modalidad);
                return;
            }
            if ($this->data['MODO'] == "2") {
                
                $ids = $this->Empleado->Grupo->find('all', array(
                    'conditions' => array(
                        'NOMBRE' => $grupo
                    ),
                    'contain' => array(
                        'Empleado' => array(
                            'fields' => array(
                                'id'
                            )
                        )
                    )
                        ));
                $id_empleados = Set::extract('/Empleado/id', $ids);

                $hoy = date("d-m-Y");
                $ids = $this->Contrato->find('all', array(
                    'conditions' => array(
                        'OR' => array(
                            'FECHA_FIN > ' => $hoy,
                            'FECHA_FIN' => NULL,
                        ),
                        'AND' => array(
                            'MODALIDAD' => $modalidad,
                            'empleado_id' => $id_empleados,
                        )
                    ),
                    'contain' => array(
                        'Empleado' => array(
                            'fields' => array(
                                'id')
                        )
                    )
                        ));

                $id_empleados = Set::extract('/Empleado/id', $ids);

                $this->paginate = array(
                    'Empleado' => array(
                        'limit' => 20,
                        'conditions' => array(
                            'Empleado.id' => $id_empleados,
                        ),
                        'contain' => array(
                            'Contrato' => array(
                                'order' => array('Contrato.FECHA_INI' => 'asc'),
                                'Cargo', 'Departamento'
                            )
                        )
                    )
                );
                
                $data = $this->Empleado->find('all', array(
                    'conditions' => array(
                        'Empleado.id' => $id_empleados,
                    ),
                    'contain' => array(
                        'Contrato' => array(
                            'order' => array('Contrato.FECHA_INI' => 'asc'),
                            'Cargo', 'Departamento'
                        )
                    )
                        ));
                $this->set('empleados', $data);
                $this->render('archivo_listado', 'nominaExcel');
                return;
            }
        }
    }

    function pantalla_listado($grupo = null, $modalidad = null) {
        if ($grupo == "Todos") {
            $grupo = array("Empleado", "Obrero");
        }

        $ids = $this->Empleado->Grupo->find('all', array(
            'conditions' => array(
                'NOMBRE' => $grupo
            ),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id'
                    )
                )
            )
                ));
        $id_empleados = Set::extract('/Empleado/id', $ids);

        $hoy = date("d-m-Y");
        $ids = $this->Contrato->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'FECHA_FIN > ' => $hoy,
                    'FECHA_FIN' => NULL,
                ),
                'AND' => array(
                    'MODALIDAD' => $modalidad,
                    'empleado_id' => $id_empleados,
                )
            ),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id')
                )
            )
                ));

        $id_empleados = Set::extract('/Empleado/id', $ids);

        $this->paginate = array(
            'Empleado' => array(
                'limit' => 20,
                'conditions' => array(
                    'Empleado.id' => $id_empleados,
                ),
                'contain' => array(
                    'Contrato' => array(
                        'order' => array('Contrato.FECHA_INI' => 'asc'),
                        'Cargo', 'Departamento'
                    )
                )
            )
        );
        $data = $this->paginate('Empleado');
        $this->set('empleados', $data);
    }

}

?>