<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">    
    <div class="title"><h2>Fecha de Inicio</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">                
        <?php
        echo $this->Form->create('Variable',array('url' => array('controller' => 'variables', 'action' => 'add_sueldo_minimo')));
        echo $this->Form->input('NOMBRE', array('value' => 'Sueldo Minimo', 'type' => 'hidden'));        
                        
        echo "<div class='row'>";                
        echo "<div style='float:left;width:30%;'>";
        $options = array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril','5' => 'Mayo','6' => 'Junio','7' => 'Julio'
                ,'8' => 'Agosto','9' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');                
        echo $this->Form->input('VARIABLE_MES_INICIO', array('div' => false, 'label' => 'Mes', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione el Opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:30%;'>";        
        echo $this->Form->input('VARIABLE_AÑO_INICIO', array('div' => false, 'label' => 'Año', 'class' => 'small'));
        echo "</div>";                
        echo "</div>";                
        
        echo "<div class='row'>";                
        echo "<div style='float:left;width:40%'>";
        $options = array('Primera' => 'Primera', 'Segunda' => 'Segunda');
        echo $this->Form->input('QUINCENA_INICIO', array('div' => false, 'label' => 'Quincena', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una opcion'));
        echo "</div>";
        echo "</div>";                          

        echo "<div class='row'>";        
        echo "<div style='float:left;width:20%'>";        
        echo $this->Form->input('VALOR', array('div' => false, 'label' => 'Sueldo Minimo', 'class' => 'small'));
        echo "</div>";
        echo "</div>";
        ?>
    </div>    
</div>

<div class="box">    
    <div class="title"><h2>Fecha de Finalizacion</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form" style="display: none;">
        <?php        
        echo "<div class='row'>";        
        echo "<div style='float:left;width:30%;'>";
        $options = array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril','5' => 'Mayo','6' => 'Junio','7' => 'Julio'
                ,'8' => 'Agosto','9' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');
        
        echo $this->Form->input('VARIABLE_MES_FIN', array('div' => false, 'label' => 'Mes', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione el Opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:30%;'>";        
        echo $this->Form->input('VARIABLE_AÑO_FIN', array('div' => false, 'label' => 'Año', 'class' => 'small'));
        echo "</div>";
        echo "</div>";
        
        echo "<div class='row'>";        
        echo "<div style='float:left;width:40%'>";
        $options = array('Primera' => 'Primera', 'Segunda' => 'Segunda');
        echo $this->Form->input('QUINCENA_FIN', array('div' => false, 'label' => 'Quincena', 'class' => 'small', 'type' => 'select', 'options' => $options, 'empty' => 'Seleccione una opcion'));
        echo "</div>";        
        echo "</div>";
        ?>
    </div>                
 </div>

<div class="box">
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row">
            <?php echo $this->Form->end('Agregar'); ?>
        </div>
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'sueldo_minimo')); ?>
            </div>
        </div>
    </div>
</div>