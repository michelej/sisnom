<div class="box">
    <div class="title"><h2>Nominas</h2></div>
    <div class="content pages">
        <div class="row">
            <?php
            echo $this->Form->create(false);
            echo "<div>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril','5' => 'Mayo','6' => 'Junio','7' => 'Julio'
                ,'8' => 'Agosto','9' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');
            echo $this->Form->label('Mes');
            echo $this->Form->input('Fopcion', array('div' => false, 'label' => false, 'class' => 'small', 'type' => 'select', 'options' => $options,'empty'=>'Seleccione una Opcion'));
            echo "</div>";
            echo "<div style='float:left;width:20%'>";
            echo $this->Form->label('Año');
            echo $this->Form->input('AÑO', array('div' => false, 'label' => false, 'class' => 'small'));
            echo "</div>";
            echo "<div style='float:left;width:25%;padding-top:16px'>";
            echo $this->Form->End('Buscar');
            echo "</div>";
            echo "</div>";
            ?>
        </div>
        <div class="box"></div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:5%;"><?php echo $this->Paginator->sort('Mes', 'FECHA_INI'); ?></th>
                    <th style="width:5%;">Año</th>
                    <th style="width:15%;">Quincena</th>
                    <th style="width:15%;"><?php echo $this->Paginator->sort('Fecha Inicio', 'FECHA_INI'); ?></th>
                    <th style="width:15%;"><?php echo $this->Paginator->sort('Fecha Fin', 'FECHA_FIN'); ?></th>
                    <th style="width:20%;"><?php echo $this->Paginator->sort('Codigo', 'CODIGO'); ?></th>                                        
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
                        <td><?php echo $nomina['Nomina']['MES']; ?></td>
                        <td><?php echo $nomina['Nomina']['AÑO']; ?></td>
                        <td><?php echo $nomina['Nomina']['QUINCENA']; ?></td>
                        <td><?php echo fechaElegible($nomina['Nomina']['FECHA_INI']); ?></td>
                        <td><?php echo fechaElegible($nomina['Nomina']['FECHA_FIN']); ?></td>                        
                        <td><?php echo $nomina['Nomina']['CODIGO']; ?></td>                        
                        <td><?php echo fechaElegible($nomina['Nomina']['FECHA_ELA']); ?></td>                        
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_edit.png", array("alt" => "modificar", 'width' => '18', 'heigth' => '18', 'title' => 'Modificar', 'url' => array('action' => 'edit', $nomina['Nomina']['id'])));                            
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