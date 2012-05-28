<div class="box">
    <div class="title"><h2>Programas - Actividades / Proyectos</h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>                                          
                    <th style="width:10%"><?php echo $this->Paginator->sort('Programa', 'CODIGO'); ?></th>
                    <th style="width:45%"><?php echo $this->Paginator->sort('Nombre', 'NOMBRE'); ?></th>
                    <th style="width:20%"><?php echo $this->Paginator->sort('Tipo', 'TIPO'); ?></th>
                    <th style="width:10%"><?php echo $this->Paginator->sort('Numero', 'NUMERO'); ?></th>
                    <th style="width:15%;text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($programas as $programa):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>                                                
                        <td><?php echo $programa['Programa']['CODIGO']; ?></td>
                        <td><?php echo $programa['Programa']['NOMBRE']; ?></td>
                        <td><?php echo $programa['Programa']['TIPO']; ?></td>
                        <td><?php echo $programa['Programa']['NUMERO']; ?></td>
                        <td class="actions">
                            <?php                                                        
                            echo $this->Html->link($this->Html->image("file_delete.png", array('alt' => 'delete', 'height' => '18', 'width' => '18')), array('controller' => 'Programas', 'action' => 'delete',$programa['Programa']['id']), array('escape' => false),sprintf('Esta seguro que desea eliminar este Programa?'));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Actualmente existen %count% programa(s) en el sistema'));
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
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Nuevo Programa', array('action' => 'add')); ?>
            </div>
        </div>
    </div>
</div>