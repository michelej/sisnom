<div class="box">
    <?php echo $this->Session->flash(); ?>    
</div>
<div class="box">
    <div class="title">	<h2>Tabulador de Primas</h2></div>
    <div class="content form">         
        <div class="row">  
            <?php echo $this->Form->create(false, array('id' => 'ajaForm', 'url' => Router::normalize($this->here))); ?>                             
            <div style="float: left">
                <table  class="tabla" cellpadding="0" cellspacing="0" style="width: 400px; ">
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
                                echo '<td height="1">' . $tab['NOMBRE'] . '</td>';
                                if (!is_array($tab['Empleado'])) {
                                    echo $this->Form->input('PRIMAS.' . $key . '.NOMBRE', array('value' => $tab['NOMBRE'], 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'smallwiz'));
                                    echo '<td>' . $this->Form->input('PRIMAS.' . $key . '.Empleado', array('value' => $tab['Empleado'], 'label' => false, 'div' => false, 'class' => 'smallwiz')) . '</td>';
                                } else {
                                    echo '<td>  </td>';
                                    echo '</tr>';
                                    foreach ($tab['Empleado'] as $kb => $tb) {
                                        echo '<tr>';
                                        echo '<td>' . $kb . '</td>';
                                        echo '<td>' . $this->Form->input('PRIMAS.' . $key . '.Empleado.' . $kb, array('value' => $tb, 'label' => false, 'div' => false, 'class' => 'smallwiz')) . '</td>';
                                        echo '</tr>';
                                    }
                                }
                                echo '</tr>';
                            }
                        }
                        ?> 
                    </tbody>
                </table>
            </div> 

            <div style="float: right">
                <table  class="tabla" cellpadding="0" cellspacing="0" style="width: 400px;">
                    <thead>
                        <tr>
                            <th colspan="2"> Tabulador Obreros</th>                            
                        </tr>
                        <tr>
                            <th style="width:80%"> Nombre</th>
                            <th style="width:20%"> Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tabulador as $key => $tab) {
                            if (isset($tab['Obrero'])) {
                                echo '<tr>';
                                echo '<td>' . $tab['NOMBRE'] . '</td>';
                                if (!is_array($tab['Obrero'])) {
                                    echo $this->Form->input('PRIMAS.' . $key . '.NOMBRE', array('value' => $tab['NOMBRE'], 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'smallwiz'));
                                    echo '<td>' . $this->Form->input('PRIMAS.' . $key . '.Obrero', array('value' => $tab['Obrero'], 'label' => false, 'div' => false, 'class' => 'smallwiz')) . '</td>';
                                } else {
                                    echo '<td>  </td>';
                                    echo '</tr>';
                                    foreach ($tab['Obrero'] as $kb => $tb) {
                                        echo '<tr>';
                                        echo '<td>' . $kb . '</td>';
                                        echo '<td>' . $this->Form->input('PRIMAS.' . $key . '.Obrero.' . $kb, array('value' => $tb, 'label' => false, 'div' => false, 'class' => 'smallwiz')) . '</td>';
                                        echo '</tr>';
                                    }
                                }
                                echo '</tr>';
                            }
                        }
                        ?> 
                    </tbody>
                </table>
            </div>                        
        </div>
    </div>
</div>

<div class="box">
    <div class="title">	<h2></h2></div>
    <div class="content form">         
        <div class="row">
            <div class="boton">               
                <?php echo $this->Form->submit('Finalizar', array('div' => false)); ?>
            </div>
            <div class="boton">               
                <?php echo $this->Form->submit('Cancelar', array('name' => 'Cancel', 'div' => false)); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>            
    </div>
</div>
</div>