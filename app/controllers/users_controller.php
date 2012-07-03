<?php

class UsersController extends AppController {

    var $name = 'Users';

    public function login() {
        $this->layout = 'login';
        if (empty($this->data)) {
            return;
        }
        $user = Authsome::login($this->data['User']);

        if (!$user) {
            $this->Session->setFlash('Usuario Desconocido o Password Incorrecto');
            return;
        }
        $redirect = $this->Session->read('loginRedirect');
        $this->Session->delete('loginRedirect');

        //$this->redirect($redirect);                
        $this->redirect('/Pages/display');
    }

    public function logout() {
        $this->Authsome->logout();
        $this->redirect('/');
    }

    function index() {
        $usuarios = $this->User->find('all', array(
            'conditions' => array(
                'NOT' => array(
                    'USERNAME' => 'admin'
                )
            )
                ));
        $this->set(compact('usuarios'));
    }

    function add() {
        if (!empty($this->data)) {
            if (!empty($this->data['User']['PASSWORD'])) {
                $this->data['User']['PASSWORD'] = md5($this->data['User']['PASSWORD']);
            }
            if ($this->User->save($this->data['User'])) {
                //$this->Session->setFlash('Usu agregado con exito', 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            unset($this->data['User']['PASSWORD']);
            //$this->Session->setFlash('Existen errores corrigalos antes de continuar', 'flash_error');
        }
        //$grupos = $this->Empleado->Grupo->find('list');
        //$this->set('grupos', $grupos);
    }

    function delete($id) {         
        if(Authsome::get('GRUPO')!='Administrador'){
            $this->Session->setFlash('Solo el Administrador puede eliminar cuentas de usuario', 'flash_error');
            $this->redirect(array('action' => 'index'));
            return ;
        }else{                        
            if ($this->User->delete($id, true)) {
                $this->Session->setFlash('Usuario eliminado', 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
        }
        
        
    }

    function cambiar_password() {
        if (!empty($this->data)) {
            $pass = Authsome::get('PASSWORD');
            if ($pass == md5($this->data['User']['OLD_PASSWORD'])) {
                $this->User->id = Authsome::get('id');
                $this->User->saveField('PASSWORD', md5($this->data['User']['PASSWORD']));
                $this->redirect('/Pages/display');
            } else {
                $this->Session->setFlash('Password Incorrecto', 'flash_error');
                $this->redirect('cambiar_password');
            }
        }
    }

}

?>