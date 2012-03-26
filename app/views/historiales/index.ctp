<div class="box">
    <div class="title"><h2>Historial de Sueldos</h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:30%"><?php echo $this->Paginator->sort('Nombre', 'NOMBRE'); ?></th>                    
                    <th style="width:35%"><?php echo $this->Paginator->sort('Descripcion', 'DESCRIPCION'); ?></th>
                    <th style="width:30%"><?php echo $this->Paginator->sort('Sueldo Actual', 'Historial.SUELDO_BASE'); ?></th>
                    <th style="width:5%;text-align: center" class="actions">Sueldos</th>
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
                        <td><?php echo $cargo['Cargo']['NOMBRE']; ?></td>
                        <td><?php echo $cargo['Cargo']['DESCRIPCION']; ?></td>
                        <td><?php if(!empty($cargo['Historial']['0'])){
                                    echo $cargo['Historial']['0']['SUELDO_BASE'];
                                  }else{
                                    echo "Inactivo";  
                                  }
                            ?></td>
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("Button Add.png", array("alt" => "Agregar", 'title' => 'Agregar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $cargo['Cargo']['id'])));                            
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Actualmente existen %count% cargo(s) en el sistema'));
                ?>
            </div>
            <div class="pagination">
                <?php echo $this->Paginator->prev(null, array(), null, array('class' => 'disabled')); ?>
                <?php echo $this->Paginator->numbers(array('class' => 'disabled', 'separator' => '')); ?>
                <?php echo $this->Paginator->next(null, array(), null, array('class' => 'disabled')); ?>
            </div>
        </div>        
    </div>
</div>
