<?php

class DeduccionesController extends AppController {

    var $name = 'Deducciones';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {       
        $this->paginate=array(
            'limit'=>25,
        );
        $data=$this->paginate();
        $this->set('deducciones',$data);
    }

}
?>