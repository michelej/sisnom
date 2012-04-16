<div class="top">
</div>
<div class="box">  
    <div class="title">
        <h2>Inicio de Sesión</h2>
    </div>

    <div class="content forms">
        
        <?php if ($this->Session->check('Message.flash')) { ?>
            <div class="message red">
                <?php echo $this->Session->flash(); ?>            
            </div>
        <?php } ?>

        <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login'))); ?>
        <div class="row">
            <div class="half-left">                
                <?php echo $this->Form->input('USERNAME', array('label' => 'Usuario', 'div' => false)); ?>
            </div>
            <div class="half">                
                <?php echo $this->Form->input('PASSWORD', array('label' => 'Contraseña','type'=>'password')); ?>
            </div>
        </div>
        <div class="row">    
            <?php
            echo $this->Form->submit('Ingresar');
            ?>
        </div>
    </div>
</div>
