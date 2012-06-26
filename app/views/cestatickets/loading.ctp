<script type="text/javascript">
    function submitform () {
        var frm = document.getElementById("cestaForm");
        frm.submit();
    }
    window.onload = submitform;
</script>

<div class="box">
    <div class="title">	<h2></h2></div>
    <div class="content form">                 
        <div class="row">
            <p style="text-align: center"><strong>Generando Nomina Cestaticket</strong></p> 
            <p style="text-align: center">Por favor espere....</p>                                                             
        </div>
        <div class="row">
            
            <?php echo $this->Form->create(false, array('id' => 'cestaForm', 'url' => Router::normalize($this->here))); ?>
            <?php echo $this->Form->input('FINAL', array('value' => 'chimbo', 'type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'small')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>  
</div> 