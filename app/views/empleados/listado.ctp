<div class="box">
    <div class="title"><h2>Empleados</h2></div>
    <div class="content pages">
        <div class="row">
            <?php
            echo $this->Form->create(false);
            echo "<div>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('0' => 'Seleccione una opcion', '1' => 'Cedula/Rif', '2' => 'Nombre', '3' => 'Apellido');
            echo $this->Form->input('Fopcion', array('div' => false, 'label' => 'Opción', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "<div style='float:left;width:20%'>";
            echo $this->Form->input('valor', array('div' => false, 'label' => 'Busqueda', 'class' => 'small'));
            echo "</div>";
            echo "<div style='float:left;width:15%;padding-top:20px'>";
            echo $this->Form->End('Buscar');
            echo "</div>";
            echo "</div>";
            ?>
        </div>
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
                    <th style="width:5%;text-align: center"><?php echo $this->Paginator->sort('Cedula / Rif', 'CEDULA'); ?></th>                    
                    <th style="width:28%;"><?php echo $this->Paginator->sort('Apellido(s) y Nombre(s)', 'NOMBRE'); ?></th>                                        
                    <th style="width:8%; text-align: left">Grupo</th>
                    <th style="width:30%; text-align: left">Cargo</th>
                    <th style="width:12%; text-align: center" class="actions">Asignaciones</th>
                    <th style="width:15%; text-align: center" class="actions">Deducciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($empleados as $empleado):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
                    if (!empty($empleado['Contrato']['0'])) {
                        if ($empleado['Contrato']['0']['MODALIDAD'] == 'Contratado') {
                            $carg = "CONTRATADO";
                        } else {
                            $carg = $empleado['Contrato']['0']['Cargo']['NOMBRE'];
                        }
                        $hoy = date("d-m-Y");
                        $fecha = $empleado['Contrato']['0']['FECHA_FIN'];                        
                        if ($fecha != null) {
                            if (compara_fechas($hoy, $fecha) > 0) {
                                $carg = "Despedido / Renuncia";
                            } else {
                                $carg = $empleado['Contrato']['0']['Cargo']['NOMBRE'];
                            }
                        } 
                    } else {
                        $carg = "Sin Contrato";
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>                        
                        <td style="text-align: right"><?php echo $empleado['Empleado']['CEDULA']; ?></td>
                        <td><?php echo normalizarPalabra($empleado['Empleado']['APELLIDO'] . " " . $empleado['Empleado']['NOMBRE']); ?></td>                        
                        <td style="text-align: left"><?php echo $empleado['Grupo']['NOMBRE']; ?></td>
                        <td style="text-align: left"><?php echo normalizarPalabra($carg); ?></td>                                                                        
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("News Add.png", array("alt" => "Experiencia", 'width' => '18', 'heigth' => '18', 'title' => 'Experiencia Previa', 'url' => array('controller' => 'experiencias', 'action' => 'edit', $empleado['Empleado']['id'])));
                            echo $this->Html->image("Bookmarks.png", array("alt" => "Nivel Educativo", 'width' => '18', 'heigth' => '18', 'title' => 'Nivel Educativo', 'url' => array('controller' => 'titulos', 'action' => 'edit', $empleado['Empleado']['id'])));
                            echo $this->Html->image("familia.png", array("alt" => "Familiares", 'width' => '18', 'heigth' => '18', 'title' => 'Familiares', 'url' => array('controller' => 'familiares', 'action' => 'edit', $empleado['Empleado']['id'])));                            
                            ?>
                        </td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("Money Bundle.png", array("alt" => " ", 'width' => '18', 'heigth' => '18', 'title' => 'Prestamos de Caja de Ahorro', 'url' => array('controller' => 'prestamos', 'action' => 'edit', $empleado['Empleado']['id'])));
                            echo $this->Html->image("Credit Card.png", array("alt" => " ", 'width' => '18', 'heigth' => '18', 'title' => 'Deduccion por Creditos Comerciales', 'url' => array('controller' => 'comerciales', 'action' => 'edit', $empleado['Empleado']['id'])));
                            echo $this->Html->image("Briefcase.png", array("alt" => " ", 'width' => '18', 'heigth' => '18', 'title' => 'Deduccion por Tribunales', 'url' => array('controller' => 'tribunales', 'action' => 'edit', $empleado['Empleado']['id'])));
                            echo $this->Html->image("islr.png", array("alt" => " ", 'width' => '18', 'heigth' => '18', 'title' => 'Retencion Impuesto sobre la Renta', 'url' => array('controller' => 'islrs', 'action' => 'edit', $empleado['Empleado']['id'])));
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
