<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">    
    <div class="title"><h2>Fecha de Inicio</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">                
        <?php
        echo $this->Form->create('Historial',array('url' => array('controller' => 'historiales', 'action' => 'add_group',implode(',',$grupo))));        
        echo $this->Form->input('FECHA_RET', array('value' => '', 'type' => 'hidden'));
        
        echo "<div class='row'>";                
        echo "<div style='float:left;width:30%;'>";
        $options = array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril','5' => 'Mayo','6' => 'Junio','7' => 'Julio'
                ,'8' => 'Agosto','9' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');                
        echo $this->Form->input('HISTORIAL_MES_INICIO', array('div' => false, 'label' => 'Mes', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione el Opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:30%;'>";        
        echo $this->Form->input('HISTORIAL_AÑO_INICIO', array('div' => false, 'label' => 'Año', 'class' => 'small'));
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
        echo $this->Form->input('SUELDO_BASE', array('div' => false, 'label' => 'Sueldo Base', 'class' => 'small'));
        echo "</div>";
        echo "</div>";
        ?>
    </div>    
</div>

<div class="box">    
    <div class="title"><h2>Fecha de Finalizacion</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php        
        echo "<div class='row'>";        
        echo "<div style='float:left;width:30%;'>";
        $options = array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril','5' => 'Mayo','6' => 'Junio','7' => 'Julio'
                ,'8' => 'Agosto','9' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');
        
        echo $this->Form->input('HISTORIAL_MES_FIN', array('div' => false, 'label' => 'Mes', 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione el Opcion'));
        echo "</div>";
        
        echo "<div style='float:left;width:30%;'>";        
        echo $this->Form->input('HISTORIAL_AÑO_FIN', array('div' => false, 'label' => 'Año', 'class' => 'small'));
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
                <?php echo $this->Html->link('Regresar', array('controller'=>'cargos','action' => 'grupo')); ?>
            </div>
        </div>
    </div>
</div>