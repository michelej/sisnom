<div class="box">
    <div class="title"><h2>Departamentos</h2></div>
    <div class="content pages">
        <div class="row"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>                                          
                    <th style="width:40%"><?php echo $this->Paginator->sort('Nombre', 'NOMBRE'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Programa', 'programa_id'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Tipo', 'programa_id'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Numero', 'programa_id'); ?></th>
                    <th style="width:15%;text-align: center" class="actions">Acciones</th>
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
                        <td><?php echo $departamento['Departamento']['NOMBRE']; ?></td>
                        <td><?php echo $departamento['Programa']['CODIGO']; ?></td>
                        <td><?php echo $departamento['Programa']['TIPO']; ?></td>
                        <td><?php echo $departamento['Programa']['NUMERO']; ?></td>
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("Disc Blu Ray.png", array("alt" => "Asignar", 'title' => 'Asignar Programa', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'asignar', $departamento['Departamento']['id'])));                            
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $departamento['Departamento']['id'])));                            
                            echo $this->Html->link($this->Html->image("file_delete.png", array('alt' => 'delete', 'height' => '18', 'width' => '18')), array('controller' => 'Departamentos', 'action' => 'delete',$departamento['Departamento']['id']), array('escape' => false),sprintf('Esta seguro que desea eliminar este Departamento?'));
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Actualmente existen %count% departamento(s) en el sistema'));
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
                <?php echo $this->Html->link('Nuevo Departamento', array('action' => 'add')); ?>
            </div>
        </div>
    </div>
</div>