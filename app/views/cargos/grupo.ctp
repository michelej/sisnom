<div class="box">
    <div class="title"><h2>Sueldos</h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:15%">Sueldo Base</th>                    
                    <th style="width:70%">Beneficiarios</th>
                    <th style="width:15%;text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($cargos as $cargo):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo number_format($cargo['Sueldo'], 2, ',', '.'); ?></td>                        
                        <td><?php echo $cargo['cargos_nombres']; ?></td>                        
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("Money.png", array("alt" => "Sueldos", 'title' => 'Sueldos', 'width' => '18', 'heigth' => '18', 'url' => array('controller'=>'historiales','action' => 'add_group', implode(',',$cargo['cargos_id']))));                            
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>        
    </div>
</div>

<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'index')); ?>
            </div>            
        </div>
    </div>
</div>