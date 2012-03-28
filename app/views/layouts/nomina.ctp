<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es"> 
    <head>
        <title>RECURSOS HUMANOS</title>
        <?php echo $html->charset('utf-8'); ?> 
        <?php echo $this->Html->css('style.css'); ?>
        <?php echo $this->Html->css('style_text.css'); ?>
        <?php echo $this->Html->css('c-grey.css'); ?>
        <?php echo $this->Html->css('datepicker.css'); ?>
        <?php echo $this->Html->css('form.css'); ?>
        <?php echo $this->Html->css('menu.css'); ?>
        <?php echo $this->Html->css('messages.css'); ?>
        <?php echo $this->Html->script('jquery-1.6.1.min.js'); ?>        
    </head>
    <body >

        <?php echo $content_for_layout; ?>

        <?php echo $this->Html->script('jquery.pngFix.js'); ?>
        <?php echo $this->Html->script('inlog.js'); ?>
    </body>
</html>


