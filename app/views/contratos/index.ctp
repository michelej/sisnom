<div class="box">
    <div class="title"><h2><?php __('Empleados'); ?></h2></div>
    <div class="content pages">        
        <div class="row">
            <?php
            echo $this->Form->create(false, array('url' => '/contratos/index'));
            echo "<div>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('0' => 'Seleccione una opcion', '1' => 'Cedula', '2' => 'Nombre','3'=>'Apellido');
            echo $this->Form->label('Opción');                        
            echo $this->Form->input('Fopcion', array('div' => false, 'label' => false, 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "<div style='float:left;width:35%'>";
            echo $this->Form->label('Busqueda');            
            echo $this->Form->input('valor', array('div' => false, 'label' => false, 'class' => 'small'));
            echo "</div>";
            echo "<div style='float:left;width:25%;padding-top:16px'>";
            echo $this->Form->End('Buscar');
            echo "</div>";
            echo "</div>";
            ?>
        </div>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>  
                    <th style="width:10%"><?php echo $this->Paginator->sort('Cedula', 'CEDULA'); ?></th>
                    <th style="width:15%"><?php echo $this->Paginator->sort('Nombre', 'NOMBRE'); ?></th>                    
                    <th style="width:15%"><?php echo $this->Paginator->sort('Apellidos', 'APELLIDO'); ?></th>                    
                    <th style="width:10%"><?php echo $this->Paginator->sort('Fecha Ingreso', 'INGRESO'); ?></th>                    
                    <th style="width:20%"><?php echo $this->Paginator->sort('Cargo', 'Contrato.Cargo.NOMBRE'); ?></th>
                    <th style="width:20%"><?php echo $this->Paginator->sort('Departamento', 'Contrato.Departamento.NOMBRE'); ?></th>
                    <th style="width:20%"><?php echo $this->Paginator->sort('Modalidad', 'Contrato.MODALIDAD'); ?></th>
                    <th style="width:10%;text-align: center" class="actions"><?php __('Actions'); ?></th>
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
                        <td><?php echo $empleado['Empleado']['INGRESO']; ?></td>                                                
                        <td><?php if(!empty($empleado['Contrato']['0'])){
                                    echo $empleado['Contrato']['0']['Cargo']['NOMBRE'];
                                  }else{
                                    echo "Inactivo o sin Asignar";  
                                  }?>
                        </td>
                        <td><?php if(!empty($empleado['Contrato']['0'])){
                                    echo $empleado['Contrato']['0']['Departamento']['NOMBRE'];
                                  }else{
                                    echo "Inactivo o sin Asignar";  
                                  }?>
                        </td>
                        <td><?php if(!empty($empleado['Contrato']['0'])){
                                    echo $empleado['Contrato']['0']['MODALIDAD'];
                                  }else{
                                    echo "Inactivo o sin Asignar";  
                                  }?>
                        </td>
                        <td class="actions">
                            <?php                            
                            echo $this->Html->image("file_edit.png", array("alt" => "Contrato", 'title' => 'Contrato', 'width' => '18', 'heigth' => '18', 'url' => array('action' => 'edit', $empleado['Empleado']['id'])));                            
                            ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pages-bottom">
            <div class="actionbox">
                <?php
                echo $this->Paginator->counter(array('format' => __('Actualmente existen %count% empleado(s) en el sistema', true)));
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
