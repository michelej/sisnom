<div class="box">
    <div class="title"><h2><?php __('Sueldos'); ?></h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:40%"><?php echo $this->Paginator->sort('Cargo', 'Cargo.NOMBRE'); ?></th>                    
                    <th style="width:35%">><?php echo $this->Paginator->sort('Sueldo Base', 'SUELDO BASE'); ?></th>                    
                    <th style="width:15%;text-align: center" class="actions"><?php __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($sueldos as $sueldo):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $sueldo['Cargo']['NOMBRE']; ?></td>                        
                        <td><?php echo $sueldo['Sueldo']['SUELDO_BASE']; ?></td>                                         
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_search.png", array("alt" => "consultar", 'width' => '18', 'heigth' => '18', 'title' => 'Consultar', 'url' => array('action' => 'view', $cargo['Cargo']['id'])));
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $cargo['Cargo']['id'])));
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $cargo['Cargo']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Actualmente existen %count% sueldo(s) en el sistema', true)));
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



<div class="box">
    <div class="title">	<h2><?php __('Acciones'); ?></h2></div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link(__('Nuevo Sueldo', true), array('action' => 'add')); ?>

            </div>
        </div>
    </div>
</div>