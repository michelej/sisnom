<?php

class AppController extends Controller {

    public $components = array(
        'Authsome.Authsome' => array(
            'model' => 'User'
        )
    );

}

?>