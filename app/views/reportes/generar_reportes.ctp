<div class="box">
    <div class="title"><h2>Reportes</h2></div>
    <div class="content pages">
        <div class="row">
            <?php
            echo $this->Form->create(false);
            echo "<div>";
            echo "<div style='float:left;width:35%;'>";
            $options = array('0' => 'Seleccione una opcion', 'Masculino' => 'Masculino', 'Femenino' => 'Femenino');
            echo $this->Form->input('SEXO', array('div' => false, 'label' => 'Sexo', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "<div style='float:left;width:35%;'>";
            $options = array('0' => 'Seleccione una opcion', 'Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado', 'Concubinato' => 'Concubinato');
            echo $this->Form->input('EDOCIVIL', array('div' => false, 'label' => 'Estado Civil', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('0' => 'Seleccione una opcion', '1' => 'Si Tiene', '2' => 'No Tiene');
            echo $this->Form->input('HIJOS', array('div' => false, 'label' => 'Tiene Hijos', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";

            echo "<div class='row'>";
            echo "</div>";


            echo "<div class='row'>";
            echo "<div style='float:left;width:5%;'>";
            $options = array('0' => '==', '1' => '>=', '2' => '<=');
            echo $this->Form->input('EDAD_SIGNO', array('div' => false, 'label' => 'Signo', 'class' => 'small2', 'type' => 'select', 'options' => $options));
            echo "</div>";
            echo "<div style='float:left;width:30%;'>";
            echo $this->Form->input('EDAD', array('div' => false, 'label' => 'Edad', 'class' => 'small'));
            echo "</div>";
            echo "<div style='float:left;width:35%;'>";
            $options = $cargos;
            echo $this->Form->input('CARGO', array('div' => false, 'label' => 'Cargo', 'class' => 'small', 'type' => 'select', 'default' => '0', 'options' => $options, 'empty' => 'Seleccione una opcion'));
            echo "</div>";
            echo "<div style='float:left;width:30%;'>";
            $options = $departamentos;
            echo $this->Form->input('DEPARTAMENTO', array('div' => false, 'label' => 'Departamento', 'class' => 'small', 'type' => 'select', 'default' => '0', 'options' => $options, 'empty' => 'Seleccione una opcion'));
            echo "</div>";
            echo "</div>";

            echo "<div class='row'>";
            echo "</div>";

            
            echo "<div class='row'>";
            echo "<div style='float:left;width:35%;'>";
            $options = $departamentos;
            echo $this->Form->input('FISICO', array('div' => false, 'label' => 'Localizacion Fisica', 'class' => 'small', 'type' => 'select', 'default' => '0', 'options' => $options, 'empty' => 'Seleccione una opcion'));
            echo "</div>";
            echo "<div style='float:left;width:35%;'>";
            $options = array('0'=>'Seleccione una opcion','Fijo'=>'Personal Fijo','Contratado'=>'Personal Contratado');
            echo $this->Form->input('MODALIDAD', array('div' => false, 'label' => 'Modalidad Contrato', 'class' => 'small', 'type' => 'select','options' => $options));
            echo "</div>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('0'=>'Seleccione una opcion','Empleado'=>'Empleado','Obrero'=>'Obrero');
            echo $this->Form->input('GRUPO', array('div' => false, 'label' => 'Grupo', 'class' => 'small', 'type' => 'select','options' => $options));
            echo "</div>";            
            echo "</div>";
            
            echo "<div class='row'>";
            echo "</div>";

            echo "<div class='row'>";
            echo "<div style='float:left;width:50%;'>";
            $options = $deducciones;
            echo $this->Form->input('DEDUCCIONES', array('div' => false, 'label' => 'Deducciones', 'class' => 'medium', 'type' => 'select','options' => $options,'empty'=>'Seleccione una opcion','default'=>0));
            echo "</div>";                        
            echo "</div>";           
            
            echo "<div class='row'>";
            echo "</div>";
                       
            echo "<div class='row'>";
            echo "<div style='float:left;width:50%;'>";
            $options = array('T.S.U' => 'T.S.U', 'Profesional Universitario' => 'Profesional Universitario', 'Post-Grado' => 'Post-Grado', 'Maestria' => 'Maestria', 'Doctorado' => 'Doctorado');
            echo $this->Form->input('TITULO', array('div' => false, 'label' => 'Titulos Profesionales', 'class' => 'small', 'type' => 'select','options' => $options,'empty'=>'Seleccione una opcion','default'=>0));
            echo "</div>";                        
            echo "</div>";
            
            echo "<div class='row'>";
            echo "</div>";
            
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%;'>";
            $options = array('1' => 'Activo', '2' => 'Inactivo');
            echo $this->Form->input('ACTIVO', array('div' => false, 'label' => 'Personal Activo', 'class' => 'small', 'type' => 'select', 'options' => $options));
            echo "</div>";
            
            echo "<div class='row'>";
            echo "<div style='float:left;width:15%;padding-top:20px'>";
            echo $this->Form->End('Generar');
            echo "</div>";
            echo "</div>";
            ?>
        </div>
    </div>
</div>