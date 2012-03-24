<div class="box">
    <div class="title"><h2><?php __('Asignaciones'); ?></h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>                      
                    <th style="width:40%"><?php echo $this->Paginator->sort('Grupo', 'GRUPO'); ?></th>
                    <th style="width:60%"><?php echo $this->Paginator->sort('Descripcion', 'DESCRIPCION'); ?></th>                    
                    <th></th>                      
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($asignaciones as $asignacion):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $asignacion['Asignacion']['GRUPO']; ?></td>
                        <td><?php echo $asignacion['Asignacion']['DESCRIPCION']; ?></td>                        
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Actualmente existen %count% asignacion(es) en el sistema', true)));
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