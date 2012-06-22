<div class="box">
    <div class="title"><h2>Reportes</h2></div>
    <div class="content pages">
        <div class="row">
            <?php
            echo $this->Form->create(false);
            echo "<div>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('0' => 'Seleccione una opcion', 'Masculino' => 'Masculino', 'Femenino' => 'Femenino');
            echo $this->Form->input('SEXO', array('div' => false, 'label' => 'Sexo', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";            
            echo "<div style='float:left;width:30%;'>";
            $options = array('0'=>'Seleccione una opcion','Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado', 'Concubinato' => 'Concubinato');
            echo $this->Form->input('EDOCIVIL', array('div' => false, 'label' => 'Estado Civil', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";            
            echo "<div style='float:left;width:30%;'>";
            $options = array('0'=>'Seleccione una opcion','1' => 'Si Tiene', '2' => 'No Tiene');
            echo $this->Form->input('HIJOS', array('div' => false, 'label' => 'Tiene Hijos', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";            
            
            echo "<div style='float:left;width:15%;padding-top:20px'>";
            echo $this->Form->End('Generar');
            echo "</div>";
            echo "</div>";
            ?>
        </div>
    </div>
</div>