<?php

class AsignacionesController extends AppController {

    var $name = 'Asignaciones';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $this->paginate=array(
            'limit'=>25,
        );
        $data=$this->paginate();
        $this->set('asignaciones',$data);
    }

}

?>