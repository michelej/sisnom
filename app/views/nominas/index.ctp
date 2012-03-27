<div class="box">
    <div class="title"><h2>Nominas</h2></div>
    <div class="content pages">                
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:20%;"><?php echo $this->Paginator->sort('Codigo', 'CODIGO'); ?></th>
                    <th style="width:5%;">Mes</th>
                    <th style="width:5%;">Año</th>
                    <th style="width:15%;"><?php echo $this->Paginator->sort('Fecha Inicio', 'FECHA_INI'); ?></th>
                    <th style="width:15%;"><?php echo $this->Paginator->sort('Fecha Fin', 'FECHA_FIN'); ?></th>                    
                    <th style="width:15%;"><?php echo $this->Paginator->sort('Quincena', 'QUINCENA'); ?></th>                    
                    <th style="width:10%;"><?php echo $this->Paginator->sort('Fecha de Elaboracion', 'FECHA_ELE'); ?></th>                    
                    <th style="width:15%; text-align: center"class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($nominas as $nomina):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $nomina['Nomina']['CODIGO']; ?></td>
                        <td><?php echo $nomina['Nomina']['MES']; ?></td>
                        <td><?php echo $nomina['Nomina']['AÑO']; ?></td>
                        <td><?php echo fechaElegible($nomina['Nomina']['FECHA_INI']); ?></td>
                        <td><?php echo fechaElegible($nomina['Nomina']['FECHA_FIN']); ?></td>                        
                        <td><?php echo $nomina['Nomina']['QUINCENA']; ?></td>                                                
                        <td><?php echo fechaElegible($nomina['Nomina']['FECHA_ELA']); ?></td>                        
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_search.png", array("alt" => "consultar", 'width' => '18', 'heigth' => '18', 'title' => 'Consultar', 'url' => array('action' => 'view', $nomina['Nomina']['id'])));
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $nomina['Nomina']['id'])));
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $nomina['Nomina']['id'])));
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>            
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Mostrando %current% Nomina(s), de un total de  %count% Nominas'));
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
                <?php echo $this->Html->link('Nueva Nomina', array('action' => 'add')); ?>
            </div>
        </div>
    </div>
</div>