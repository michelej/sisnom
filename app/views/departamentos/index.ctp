<div class="box">
    <div class="title"><h2><?php __('Departamentos'); ?></h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>                      
                    <th style="width:10%"><?php echo $this->Paginator->sort('Codigo', 'CODIGO'); ?></th>                    
                    <th style="width:75%"><?php echo $this->Paginator->sort('Nombre', 'NOMBRE'); ?></th>                    
                    <th style="width:15%;text-align: center" class="actions"><?php __('Acciones'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($departamentos as $departamento):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>                        
                        <td><?php echo $departamento['Departamento']['CODIGO']; ?></td>
                        <td><?php echo $departamento['Departamento']['NOMBRE']; ?></td>                        
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $departamento['Departamento']['id'])));
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $departamento['Departamento']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Actualmente existen %count% departamento(s) en el sistema', true)));
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
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2><?php __('Acciones'); ?></h2></div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link(__('Nuevo Departamento', true), array('action' => 'add')); ?>

            </div>
        </div>
    </div>
</div>