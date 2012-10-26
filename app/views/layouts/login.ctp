<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">     
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
        <title>
        </title>
        <?php echo $html->css('inlog.css'); ?>
        <?php echo $html->css('style_text.css'); ?>        
        <?php echo $html->css('c-grey.css'); ?>
        <?php echo $html->css('form.css'); ?>
        <?php echo $html->css('messages.css'); ?>
        <?php echo $this->Html->script('jquery-1.6.1.min.js'); ?>
        <title><?php echo $title_for_layout ?></title>
    </head>
    <body >
        <!-- INICIO DE WRAPPER -->
        <div class="wrapper">
            <!-- INICIO DE CONTENIDO -->
            <div class="container">   
                <?php echo $content_for_layout; ?>
            </div>            
            <!-- FIN DE CONTENIDO -->
        </div>
        <!-- FIN DE WRAPPER -->
        <?php //debug($_SESSION); ?>
        <?php echo $this->Html->script('jquery.pngFix.js'); ?>
        <?php echo $this->Html->script('inlog.js'); ?>
    </body>
</html>