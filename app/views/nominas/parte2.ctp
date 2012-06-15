<div class="box">
    <div class="title">	<h2>Generacion de la Nomina</h2></div>
    <div class="content form">         
        <div class="row">  
            <?php echo $this->Form->create(false, array('id' => 'ajaForm', 'url' => Router::normalize($this->here))); ?>
            <h2>Tabulador de Primas</h2>            
            <?php      
            debug($tabulador);
            /* foreach ($asignaciones as $asignacion) {
              echo "<div class='row'>";
              echo "<div style='float:left;width:30%;'>";
              echo $this->Form->input($asignacion, array('label' => $asignacion, 'div' => false, 'class' => 'small'));
              echo "</div>";
              echo "</div>";
              } */
            ?>

            <table  class="tabla" style="width: 400px">
                <thead>
                    <tr>
                        <th colspan="2"> Tabulador Empleados</th>                            
                    </tr>
                    <tr>
                        <th style="width:80%"> Nombre</th>
                        <th style="width:20%"> Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tabulador as $key => $tab) {
                        if (isset($tab['Empleado'])) {
                            echo '<tr>';
                            echo '<td>' . $tab['NOMBRE'] . '</td>';
                            if (!is_array($tab['Empleado'])) {
                                echo $this->Form->input($key.'.NOMBRE', array('value'=>$tab['NOMBRE'],'type'=>'hidden','label' => false, 'div' => false, 'class' => 'small'));
                                echo '<td>' .$this->Form->input($key.'.Empleado', array('value'=>$tab['Empleado'],'label' => false, 'div' => false, 'class' => 'small')) . '</td>';
                            } else {
                                echo '<td>  </td>';
                                echo '</tr>';
                                foreach ($tab['Empleado'] as $kb=>$tb) {
                                    echo '<tr>';
                                    echo '<td>' . $kb . '</td>';
                                    echo '<td>' .$this->Form->input('Empleado.'.$kb, array('value'=>$tb,'label' => false, 'div' => false, 'class' => 'small')) . '</td>';
                                    echo '</tr>';
                                }
                            }
                            echo '</tr>';
                        }
                    }
                    ?> 
                </tbody>
            </table>



            <div class="row"></div>
            <div class="submit">
                <?php echo $this->Form->submit('Finalizar', array('div' => false)); ?>                
                <?php echo $this->Form->submit('Cancelar', array('name' => 'Cancel', 'div' => false)); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>