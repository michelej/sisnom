<script type="text/javascript">
    function submitform () {
        var frm = document.getElementById("dosForm");
        frm.submit();
    }
    window.onload = submitform;
</script>

<div class="box">
    <div class="title">	<h2></h2></div>
    <div class="content form">                 
        <div class="row">
            <p style="text-align: center"><strong>Generando Nomina</strong></p> 
            <p style="text-align: center">Por favor espere....</p>            
            <div style="position: fixed;left: 50%;margin-left: -64px;"> 
             <?php echo $this->Html->image('loading3.gif'); ?>
            </div>
            <p style="text-align: justify">Actualmente se esta generando la informacion correspondiente a esta nomina esta accion puede tardar hasta 1 minuto no cierre el navegador mientras se esta ejecutando o tendra que volver a realizar esta operacion</p>            
        </div>
        <div class="row">
            
            <?php echo $this->Form->create(false, array('id' => 'dosForm', 'url' => Router::normalize($this->here))); ?>
            <?php echo $this->Form->input('FINAL', array('value' => 'chimbo', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'small')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>  
</div>  