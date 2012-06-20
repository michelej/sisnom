<div class="box">
    <div class="title"><h2>Conceptos</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>                
    </div>
    <div class="content pages">

        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center;width: 50%">Asignaciones</th>
                    <th style="text-align: center;width: 50%">Deducciones</th>
                </tr>                
            </thead>
            <tbody>                
                <?php
                $ta = count($ajuste['Asignacion']);
                $td = count($ajuste['Deduccion']);
                if($ta>$td){
                    $total=$ta;
                }else{
                    $total=$td;
                }
                
                $i = 0;
                for ($ct = 0; $ct < $total; $ct++):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <?php 
                         if($ct<$ta){
                             echo "<td>". $ajuste['Asignacion'][$ct]['DESCRIPCION']."</td>";
                         }else{
                             echo "<td>  </td>";
                         }
                         
                         if($ct<$td){                             
                             echo "<td>". $ajuste['Deduccion'][$ct]['DESCRIPCION']."</td>";                             
                         }else{
                             echo "<td>  </td>";
                             echo "<td>  </td>";
                             echo "<td>  </td>";
                         }
                        ?>                                                
                    <?php endfor; ?> 
                </tr>                
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