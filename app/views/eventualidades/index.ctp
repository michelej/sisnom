<div class="box">
    <div class="title"><h2>Eventualidades</h2></div>
    <div class="content pages">
        <div class="box"></div>
        <div class="pagination">
            <?php echo $this->Paginator->prev(null, array(), null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(array('class' => 'disabled', 'separator' => '')); ?>
            <?php echo $this->Paginator->next(null, array(), null, array('class' => 'disabled')); ?>
        </div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:60%;text-align: left"><?php echo $this->Paginator->sort('Eventualidad', 'NOMBRE'); ?></th>         
                    <th style="width:20%;text-align: center"><?php echo $this->Paginator->sort('Tipo', 'TIPO'); ?></th>         
                    <th style="width:20%; text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($eventualidades as $eventualidad):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }?>
                    <tr<?php echo $class; ?>>
                        <td></td>                        
                        <td style="text-align: left"><?php echo $eventualidad['Eventualidad']['NOMBRE']; ?></td>                                                
                        <td style="text-align: center"><?php echo $eventualidad['Eventualidad']['TIPO']; ?></td>                                                
                        <td class="actions">
                            <?php                                                        
                            echo $this->Html->link($this->Html->image("Button White Add.png", array('alt' => 'Eventualidad','title'=>'Eventualidad', 'height' => '18', 'width' => '18')), array('controller' => 'eventualidades', 'action' => 'listado', $eventualidad['Eventualidad']['id']), array('escape' => false));
                            echo $this->Html->link($this->Html->image("file_delete.png", array('alt' => 'delete', 'height' => '18', 'width' => '18')), array('controller' => 'eventualidades', 'action' => 'delete', $eventualidad['Eventualidad']['id']), array('escape' => false), sprintf('Esta seguro que desea eliminar esta Eventualidad?'));
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>            
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Mostrando %current% Empleado(s), de un total de  %count% Empleados'));
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
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">
        <div class="row">
            <div class="boton">
                <?php echo $this->Html->link('Nueva Eventualidad', array('action' => 'add')); ?>
            </div>            
        </div>
    </div>
</div>