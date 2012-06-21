<div class="box">
    <div class="title"><h2>Listados</h2></div>
    <div class="content pages">
        <div class="row">
            <?php
            echo $this->Form->create(false);
            echo "<div>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('0' => 'Seleccione una opcion', '1' => 'Empleados Fijos', '2' => 'Obreros Fijos', '3' => 'Contratados');
            echo $this->Form->input('TIPO', array('div' => false, 'label' => 'Tipo de Listado', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";            
            echo "<div style='float:left;width:30%;'>";
            $options = array('0' => 'Seleccione una opcion', '1' => 'Pantalla', '2' => 'Archivo');
            echo $this->Form->input('MODO', array('div' => false, 'label' => 'Visualizar', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";            
            echo "<div style='float:left;width:15%;padding-top:20px'>";
            echo $this->Form->End('Generar');
            echo "</div>";
            echo "</div>";
            ?>
        </div>
    </div>
</div>