<div>
    Bienvenido al Sistema
</div> 

<br />
<br />

<div style="float: left; padding-left: 2.5%;padding-right: 2.5%;width: 45%;height: 500px">    
    <div class="titulo_blue_lt"></div>
    <div class="titulo_blue_md" style="width: 90%">Resumen del Sistema</div>
    <div class="titulo_blue_rt"></div>        
    <br />
    
</div>        

<div style="float: right; padding-left: 2.5%;padding-right: 2.5%;width: 45%">    
    <div class="titulo_blue_lt"></div>
    <div class="titulo_blue_md" style="width: 90%">Acciones Rapidas</div>
    <div class="titulo_blue_rt"></div>        
    <br />
    <ul>
        <li><?php echo $this->Html->link("Personal", array('controller' => 'empleados', 'action' => 'index'), array('escape' => false)); ?></li>                                 
        <li><?php echo $this->Html->link("Nominas", array('controller' => 'nominas', 'action' => 'index'), array('escape' => false)); ?></li>                                 
        <li><?php echo $this->Html->link("Cestatickets", array('controller' => 'cestatickets', 'action' => 'index'), array('escape' => false)); ?></li>                                 
        <li><?php echo $this->Html->link("Parametros", array('controller' => 'empleados', 'action' => 'listado'), array('escape' => false)); ?></li>                                 
    </ul>
    <br />
</div>

<div style="float: right; padding-left: 2.5%;padding-right: 2.5%;width: 45%">
    <div class="titulo_blue_lt"></div>
    <div class="titulo_blue_md" style="width: 90%">Recordatorios</div>
    <div class="titulo_blue_rt"></div>
</div>
