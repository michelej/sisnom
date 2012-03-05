<div class="box">
    <div class="title"></div>
    <div class="content pages">
        <div class="row">
            <?php
            echo $this->Form->create('Empleado');
            echo "<div>";
            echo "<div style='float:left;width:20%;'>";
            $opciones = array('1' => 'Cedula', '2' => 'Nombre', '3' => 'Apellido', '4' => 'Condicion', '0' => 'Estado');
            echo $this->Form->label('Opción');
            echo $this->Form->select('Fopcion', array($opciones), null, array('empty' => "Seleccione una opción"));
            echo "</div>";
            echo "<div style='float:left;width:32%'>";
            echo $this->Form->label('Descripción');
            echo $this->Form->Input('valor', array('class' => 'small', 'label' => false, 'value' => ''));
            echo "</div>";
            echo "<div style='float:left;width:25%;padding-top:16px'>";
            echo $this->Form->End('Buscarr');
            echo "</div>";
            echo "</div>";
            ?>
        </div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr  class="even">
                    <th></th>  
                    <th style="width:5%"><?php echo $this->Paginator->sort('Cedula', 'CEDULA'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Nombre(s)', 'NOMBRE'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Apellido(s)', 'APELLIDO'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Condición Laboral', 'MODALIDAD'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('cargos_id'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('dependencias_id'); ?></th>
                    <th style="width:25%"class="actions"><?php __('Acciones'); ?></th>
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
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>
                        <td><?php echo $empleado['Empleado']['CEDULA']; ?></td>
                        <td><?php echo $empleado['Empleado']['NOMBRE']; ?></td>
                        <td><?php echo $empleado['Empleado']['APELLIDO']; ?></td>
                        <td><?php //echo strtoupper($empleado['Condicion']['CON_NOMBRE']); ?></td>
                        <td><?php //echo strtoupper($empleado['Cargo']['CAR_DESCRIPCION']);  ?></td>
                        <td><?php //echo strtoupper($empleado['Dependencia']['DEP_NOMBRE']);  ?></td>
                        <td class="actions">
                            <?php
                            echo $this->Html->image("file_search.png", array("alt" => "consultar", 'width' => '18', 'heigth' => '18', 'title' => 'Consultar', 'url' => array('action' => 'view', $empleado['Empleado']['id'])));
                            echo $this->Html->image("file_edit.png", array("alt" => "Modificar", 'title' => 'Modificar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $empleado['Empleado']['id'])));
                            echo $this->Html->image("file_delete.png", array("alt" => "Borrar", 'title' => 'Eliminar', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'delete', $empleado['Empleado']['id'])));
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>            
                </tr>
            </tfoot>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Pagina %page% de %pages%, mostrando %current% registro(s) de  %count% en total, comenzando en  %start%, Finalizando en %end%', true)));
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
    <div class="title">	<h2><?php __('Acciones'); ?></h2></div>
    <div class="content form">
        <div class="row boton">
            <div class="boton">
                <?php echo $this->Html->link(__('Nuevo Empleado', true), array('action' => 'add')); ?>

            </div>
        </div>
    </div>
</div>

