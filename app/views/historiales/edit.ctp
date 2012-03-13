<div class="box">
    <div class="title"><h2>Cargo</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:50%'>"; ?>
            <?php echo $this->Form->label('Nombre'); ?>
            <?php echo $cargo['Cargo']['NOMBRE']; ?>
            <?php echo "</div>"; ?>
            <?php echo "<div style='float:left;width:50%'>"; ?>
            <?php echo $this->Form->label('Descripcion'); ?>
            <?php echo $cargo['Cargo']['DESCRIPCION']; ?>
            <?php echo "</div>"; ?>

        </div>
    </div>    

</div>

<div class="box">
    <div class="title"><h2>Historial de Sueldo</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:30%">Fecha Inicio</th>                    
                    <th style="width:30%">Fecha Final</th>                                        
                    <th style="width:25%">Sueldo Base</th>                                        
                    <th style="width:15%; text-align: center" class="actions"><?php __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($historiales as $historia):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo fechaElegible($historia['Historial']['FECHA_INI']); ?></td>                        
                        <td><?php if($historia['Historial']['FECHA_FIN']==NULL){
                                    echo "Actual";
                                  }else{
                                    echo fechaElegible($historia['Historial']['FECHA_FIN']);  
                                  }?></td>                                                
                        <td><?php echo $historia['Historial']['SUELDO_BASE']; ?></td>                        
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $historia['Historial']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="box">
    <div class="title"><h2>Nuevo Sueldo</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <?php
        echo $this->Form->create('Historial');
        echo $this->Form->input('cargo_id', array('value' => $cargo['Cargo']['id'], 'type' => 'hidden'));

        echo "<div class='row'>";
        echo "<div style='float:left;width:20%'>";
        echo $this->Form->label('Fecha Inicio');
        echo $this->Form->input('FECHA_INI', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";

        echo "<div style='float:left;width:20%'>";
        echo $this->Form->label('Fecha Fin');
        echo $this->Form->input('FECHA_FIN', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'datepicker dp-applied')) . "</br>";
        echo "</div>";                                

        echo "<div style='float:left;width:20%'>";
        echo $this->Form->label('Sueldo Base');
        echo $this->Form->input('SUELDO_BASE', array('div' => false, 'label' => false, 'class' => 'small'));
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
            <?php echo $this->Form->end(__('Nuevo', true)); ?>

        </div>
    </div>
</div>