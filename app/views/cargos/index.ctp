<div class="box">
    <div class="title"><h2>Cargos</h2></div>
    <div class="content pages">
        <div class="row"></div>
        <div class="pagination">
            <?php echo $this->Paginator->prev(null, array(), null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(array('class' => 'disabled', 'separator' => '')); ?>
            <?php echo $this->Paginator->next(null, array(), null, array('class' => 'disabled')); ?>
        </div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:40%"><?php echo $this->Paginator->sort('Nombre', 'NOMBRE'); ?></th>                    
                    <th style="width:25%"><?php echo $this->Paginator->sort('Descripcion', 'DESCRIPCION'); ?></th>
                    <th style="width:10%; text-align:center">Desde</th>
                    <th style="width:10%">Sueldo Base</th>
                    <th style="width:15%;text-align: center" class="actions">Acciones</th>
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
                        <td><?php
                if (!empty($cargo['Historial']['0'])) {
                    echo fechaElegible($cargo['Historial']['0']['FECHA_INI']);
                } else {
                    echo "";
                }
                ?>
                        </td>
                        <td><?php
                if (!empty($cargo['Historial']['0'])) {
                    echo number_format($cargo['Historial']['0']['SUELDO_BASE'], 2, ',', '.');
                } else {
                    echo "";
                }
                    ?>
                        </td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("Money.png", array("alt" => "Sueldos", 'title' => 'Sueldos', 'width' => '18', 'heigth' => '18', 'url' => array('controller' => 'historiales', 'action' => 'edit', $cargo['Cargo']['id'])));
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $cargo['Cargo']['id'])));
                            echo $this->Html->link($this->Html->image("file_delete.png", array('alt' => 'delete', 'height' => '18', 'width' => '18')), array('controller' => 'Cargos', 'action' => 'delete', $cargo['Cargo']['id']), array('escape' => false), sprintf('Esta seguro que desea eliminar este Cargo?'));
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

<div class="box">
<?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
<?php echo $this->Html->link('Nuevo Cargo', array('action' => 'add')); ?>
            </div>
            <div class="boton">
<?php echo $this->Html->link('Mostrar por Grupos', array('action' => 'grupo')); ?>
            </div>
        </div>
    </div>
</div>