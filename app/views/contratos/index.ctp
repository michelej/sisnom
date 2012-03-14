<div class="box">
    <div class="title"><h2><?php __('Empleados'); ?></h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:30%"><?php echo $this->Paginator->sort('Cedula', 'CEDULA'); ?></th>
                    <th style="width:30%"><?php echo $this->Paginator->sort('Nombre', 'NOMBRE'); ?></th>                    
                    <th style="width:40%"><?php echo $this->Paginator->sort('Apellidos', 'APELLIDO'); ?></th>                    
                    <th style="width:15%;text-align: center" class="actions"><?php __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($empleados as $empleado):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $empleado['Empleado']['CEDULA']; ?></td>                        
                        <td><?php echo $empleado['Empleado']['NOMBRE']; ?></td>                        
                        <td><?php echo $empleado['Empleado']['APELLIDO']; ?></td>                                                
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("file_edit.png", array("alt" => "Contrato", 'title' => 'Contrato', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $empleado['Empleado']['id'])));                            
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Actualmente existen %count% empleado(s) en el sistema', true)));
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
