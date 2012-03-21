<div class="box">
    <div class="title"><h2><?php __('Deducciones'); ?></h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>                      
                    <th style="width:30%"><?php echo $this->Paginator->sort('Codigo', 'CODIGO'); ?></th>
                    <th style="width:50%"><?php echo $this->Paginator->sort('Descripcion', 'DESCRIPCION'); ?></th>
                    <th style="width:20%; text-align: center"><?php echo $this->Paginator->sort('Porcentaje', 'PORCENTAJE'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($deducciones as $deduccion):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $deduccion['Deduccion']['CODIGO']; ?></td>
                        <td><?php echo $deduccion['Deduccion']['DESCRIPCION']; ?></td>
                        <td><?php echo $deduccion['Deduccion']['PORCENTAJE']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Actualmente existen %count% Deduccion(es) en el sistema', true)));
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