<div class="top">
</div>
<div class="box">  
    <div class="title">
        <h2>Inicio de Sesión</h2>
    </div>
    <div class="content forms">
        <div class="message blue">
            <? echo $this->Session->flash('auth', array('class' => null)); ?>
            <? echo $html->Image("icon-close.gif"); ?>
        </div>
        <?php echo $this->Form->create('User', array('url'=>array('controller'=>'users','action' => 'login'))); ?>
        <div class="row">
            <div class="half-left">                
                <?php echo $this->Form->input('username', array('label' => 'Usuario', 'div' => false)); ?>
            </div>
            <div class="half">                
                <?php echo $this->Form->input('password', array('label' => 'Contraseña')); ?>
            </div>
        </div>
        <div class="row">    
            <?php            
            echo $this->Form->submit('Login');
            ?>
        </div>
    </div>
</div>
