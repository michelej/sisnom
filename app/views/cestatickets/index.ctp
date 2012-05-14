<div class="box">
    <div class="title"><h2>Cestaticket</h2></div>
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
                    <th style="width:15%;"><?php echo $this->Paginator->sort('Mes', 'FECHA_INI'); ?></th>
                    <th style="width:15%;">Año</th>                    
                    <th style="width:20%;"><?php echo $this->Paginator->sort('Fecha Inicio', 'FECHA_INI'); ?></th>
                    <th style="width:20%;"><?php echo $this->Paginator->sort('Fecha Fin', 'FECHA_FIN'); ?></th>                    
                    <th style="width:15%;"><?php echo $this->Paginator->sort('Fecha de Elaboracion', 'FECHA_ELE'); ?></th>                    
                    <th style="width:15%; text-align: center"class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($cestatickets as $cestaticket):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $cestaticket['Cestaticket']['MES']; ?></td>
                        <td><?php echo $cestaticket['Cestaticket']['AÑO']; ?></td>                        
                        <td><?php echo fechaElegible($cestaticket['Cestaticket']['FECHA_INI']); ?></td>
                        <td><?php echo fechaElegible($cestaticket['Cestaticket']['FECHA_FIN']); ?></td>                                                
                        <td><?php echo fechaElegible($cestaticket['Cestaticket']['FECHA_ELA']); ?></td>                        
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("Button White Info.png", array("alt" => "modificar", 'width' => '18', 'heigth' => '18', 'title' => 'Cestaticket', 'url' => array('action' => 'edit', $cestaticket['Cestaticket']['id'])));                            
                            echo $this->Html->link($this->Html->image("file_delete.png", array('alt' => 'delete', 'height' => '18', 'width' => '18')), array('controller' => 'cestatickets', 'action' => 'delete',$cestaticket['Cestaticket']['id']), array('escape' => false),sprintf('Esta seguro que desea eliminar esta Cestaticket?'));
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>            
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => 'Mostrando %current% Cestaticket(s), de un total de  %count% Cestatickets'));
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
                <?php echo $this->Html->link('Nueva Nomina de Cestatickets', array('action' => 'add')); ?>
            </div>
        </div>
    </div>
</div>