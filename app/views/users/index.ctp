<div class="box">
    <div class="title"><h2>Usuarios del Sistema</h2></div>
    <div class="content pages">        
        <div class="box"></div>        
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th></th>                                          
                    <th style="width:40%; text-align: left">Nombre Completo</th>                    
                    <th style="width:20%; text-align: left">Usuario</th>
                    <th style="width:20%; text-align: left">Grupo</th>
                    <th style="width:20%; text-align: center" class="actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($usuarios as $usuario):
                    $class = ' class="even"';
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }                    
                    ?>
                    <tr<?php echo $class; ?>>
                        <td></td>                                                                        
                        <td style="text-align: left"><?php  echo normalizarPalabra($usuario['User']['APELLIDO']." ".$usuario['User']['NOMBRE']); ?></td>                        
                        <td style="text-align: left"><?php  echo $usuario['User']['USERNAME']; ?></td>
                        <td style="text-align: left"><?php  echo $usuario['User']['GRUPO']; ?></td>
                        <td class="actions">
                            <?php                                                                                   
                            echo $this->Html->link($this->Html->image("file_delete.png", array('alt' => 'delete', 'title'=>'Eliminar Empleado','height' => '18', 'width' => '18')), array('controller' => 'users', 'action' => 'delete', $usuario['User']['id']), array('escape' => false), sprintf('Esta seguro que desea eliminar a este Usuario?'));
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>            
        </table>
    </div>
</div>

<div class="box">
    <?php echo $this->Session->flash(); ?>
</div>

<div class="box">
    <div class="title">	<h2>Acciones</h2></div>
    <div class="content form">
        <div class="row">
            <div class="boton">
                <?php echo $this->Html->link('Crear Usuario', array('action' => 'add')); ?>
            </div>
        </div>
    </div>
</div>