<div class="box">
    <div class="title">	<h2>Generacion de la Nomina</h2></div>
    <div class="content form">         
        <div class="row">
            <?php echo $this->Form->create(false, array('id' => 'primeraForm', 'url' => Router::normalize($this->here))); ?>            
            <h2> Datos Basicos</h2>
            <?php
            echo "<div class='row'>";
            echo "<div style='float:left;width:30%;'>";
            echo $this->Form->input('SUELDO_MINIMO', array('label' => 'Sueldo Minimo', 'div' => false, 'class' => 'small'));
            echo "</div>";
            echo "</div>";
            ?>
            <div class="row">
            </div>
            <div class="submit">
                <?php echo $this->Form->submit('Siguiente', array('div' => false)); ?>
                <?php echo $this->Form->submit('Cancelar', array('name' => 'Cancel', 'div' => false)); ?>
            </div>            
            <?php echo $this->Form->end(); ?>
        </div>

    </div>
</div>