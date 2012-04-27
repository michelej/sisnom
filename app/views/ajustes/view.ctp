<div class="box">
    <div class="title"><h2>Conceptos</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>                
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <caption>DEDUCCIONES</caption>
            <thead>                
                <tr>
                    <th></th>  
                    <th style="width:20%">Codigo</th>
                    <th style="width:70%">Descripcion</th>                    
                    <th style="width:10%">Porcentaje</th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($ajuste['Deduccion'] as $value):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }                                        
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $value['CODIGO']; ?></td>                        
                        <td><?php echo $value['DESCRIPCION']; ?></td>                        
                        <td><?php echo $value['PORCENTAJE']; ?></td>                                                
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
        <br />
        <table cellpadding="0" cellspacing="0">
            <caption>ASIGNACIONES</caption>
            <thead>
                <tr>
                    <th></th>                      
                    <th style="width:100%">Descripcion</th>                                        
                    <th></th>  
                </tr>
            </thead>
            <tbody>                
                <?php
                $i = 0;
                foreach ($ajuste['Asignacion'] as $value):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }                    
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>                        
                        <td><?php echo $value['DESCRIPCION']; ?></td>                                                                        
                        <td></td> 
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
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">        
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Regresar', array('action' => 'edit', $ajuste['Ajuste']['empleado_id'])); ?>
            </div>
        </div>
    </div>
</div>