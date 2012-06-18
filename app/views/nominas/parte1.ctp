<div class="box">
    <div class="title">	<h2>Generacion de la Nomina</h2></div>
    <div class="content form">         
        <div class="row">
            <?php echo $this->Form->create(false, array('id' => 'primeraForm', 'url' => Router::normalize($this->here))); ?>                        
            <?php            
            echo "<div style='float:left;width:30%;'>";
            echo $this->Form->input('SUELDO_MINIMO', array('label' => 'Sueldo Minimo', 'div' => false, 'class' => 'small'));
            echo "</div>";            
            ?>                                    
        </div>
    </div>
</div>

<div class="box">
    <div class="title">	<h2></h2></div>
    <div class="content form">         
        <div class="row">
            <div class="submit">
                <?php echo $this->Form->submit('Siguiente', array('div' => false)); ?>
                <?php echo $this->Form->submit('Cancelar', array('name' => 'Cancel', 'div' => false)); ?>
                <?php echo $this->Form->end(); ?>
            </div>            
        </div>
    </div>
</div>