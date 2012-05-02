<div class="box">
    <div class="title"><h2>Historial de la Unidad Tributaria</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content pages">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>                      
                    <th style="width:20%"><?php echo $this->Paginator->sort('Fecha Inicio', 'FECHA_INI') ?></th>                       
                    <th style="width:20%"><?php echo $this->Paginator->sort('Fecha Final', 'FECHA_FIN') ?></th>
                    <th style="width:45%"><?php echo $this->Paginator->sort('Unidad Tributaria', 'VALOR') ?></th>                                        
                    <th style="width:15%; text-align: center" class="actions"><?php __('Acciones'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($variables as $variable):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>                        
                        <td><?php echo fechaElegible($variable['Variable']['FECHA_INI']); ?></td>                         
                        <td><?php
                            if ($variable['Variable']['FECHA_FIN'] == NULL) {
                                echo "Actual";
                            } else {
                                echo fechaElegible($variable['Variable']['FECHA_FIN']);
                            }?>
                        </td>                                                
                        <td><?php echo $variable['Variable']['VALOR']; ?></td>                        
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete_unidad_tributaria', $variable['Variable']['id'])));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Este cargo tiene %count% historial(es)', true)));
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
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link('Nuevo valor de Unidad Tributaria', array('action' => 'add_unidad_tributaria')); ?>
            </div>              
        </div>        
    </div>
</div>