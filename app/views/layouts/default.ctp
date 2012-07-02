<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es"> 
    <head> 
        <title>RECURSOS HUMANOS</title> 
        <?php echo $html->charset('utf-8'); ?> 
        <?php echo $this->Html->css('style.css'); ?>
        <?php echo $this->Html->css('style_text.css'); ?>
        <?php echo $this->Html->css('c-grey.css'); ?>
        <?php echo $this->Html->css('tabs.css'); ?>
        <?php echo $this->Html->css('datepicker.css'); ?>
        <?php echo $this->Html->css('form.css'); ?>
        <?php echo $this->Html->css('menu.css'); ?>
        <?php echo $this->Html->css('messages.css'); ?>
        <?php echo $this->Html->css('jquery-ui-1.8.4.custom.css'); ?>        
        <?php echo $this->Html->script('jquery-1.6.1.min.js'); ?> 
        <?php echo $this->Html->script('jquery-ui-1.8.14.custom.min.js'); ?>         
    </head> 
    <body>         
        <div class="wrapper">             
            <div class="container">                 
                <div class="top">                     
                    <div class="split"></div> 
                    <div class="split">                         
                        <div class="logout">
                            <?php echo '( ' . Authsome::get('USERNAME') . ') ' . Authsome::get('NOMBRE') . ' ' . Authsome::get('APELLIDO') ?>
                            <?php echo $this->Html->image('icon-logout.gif'); ?>                            
                            <?php echo $html->link('Salir', array('controller' => 'users', 'action' => 'logout')); ?> 
                        </div> 
                    </div> 
                </div>                                 
                <div class="menu">  
                    <ul> 
                        <li class="current" style="height:32px">
                            <?php echo $this->Html->link($this->Html->image("home1.png", array('alt' => 'Inicio', 'height' => '18', 'width' => '18')) . " Inicio", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>
                        </li> 
                        <li class="break"></li> 
                        <li><?php echo $this->Html->link($this->Html->image("file1.png", array('alt' => 'Definiciones', 'height' => '18', 'width' => '18')) . " Definiciones", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>    
                            <ul>
                                <li><?php echo $this->Html->link($this->Html->image("Finder.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Personal", array('controller' => 'empleados', 'action' => 'index'), array('escape' => false)); ?></li>                                 
                                <li><?php echo $this->Html->link($this->Html->image("Globe Active.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Localizacion Fisica", array('controller' => 'localizaciones', 'action' => 'index'), array('escape' => false)); ?></li>                                                                  
                                <li><?php echo $this->Html->link($this->Html->image("User.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Cargos", array('controller' => 'cargos', 'action' => 'index'), array('escape' => false)); ?></li>                                                                  
                                <li><?php echo $this->Html->link($this->Html->image("Cog.png", array('alt' => 'Departamentos', 'height' => '18', 'width' => '18')) . "   Departamentos", array('controller' => 'departamentos', 'action' => 'index'), array('escape' => false)); ?>
                                    <ul>
                                        <li><?php echo $this->Html->link($this->Html->image("Disc Blu Ray.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Programas", array('controller' => 'programas', 'action' => 'index'), array('escape' => false)); ?></li>                                 
                                    </ul>
                                </li>

                                <li><?php echo $this->Html->link($this->Html->image("Contacts.png", array('alt' => 'Basicas', 'height' => '18', 'width' => '18')) . " Basicas", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>
                                    <ul>                                        
                                        <li><?php echo $this->Html->link($this->Html->image("calendar_today.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Dias Feriados", array('controller' => 'feriados', 'action' => 'index'), array('escape' => false)); ?></li>                                        
                                    </ul>
                                </li>                                
                            </ul>
                        </li>
                        <li>
                            <?php echo $this->Html->link($this->Html->image("disc.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Procesos", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?> 
                            <ul>                             
                                <li><?php echo $this->Html->link($this->Html->image("Drawer Closed.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Administrar Conceptos", array('controller' => 'ajustes', 'action' => 'index'), array('escape' => false)); ?></li>                                                                    
                                <li><?php echo $this->Html->link($this->Html->image("Button Remove.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Ausencias", array('controller' => 'ausencias', 'action' => 'index'), array('escape' => false)); ?></li>         
                                <li><?php echo $this->Html->link($this->Html->image("Button White Add.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Horas Extras", array('controller' => 'horas_extras', 'action' => 'index'), array('escape' => false)); ?></li>                                                                  
                                <li><?php echo $this->Html->link($this->Html->image("News.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "  Nominas", array('controller' => 'nominas', 'action' => 'index'), array('escape' => false)); ?>
                                    <ul>                                        
                                        <li><?php echo $this->Html->link($this->Html->image("Document Checklist.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Parametros", array('controller' => 'empleados', 'action' => 'listado'), array('escape' => false)); ?></li>                                  
                                        <li><?php echo $this->Html->link($this->Html->image("calendar_today.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Eventualidades", array('controller' => 'eventualidades', 'action' => 'index'), array('escape' => false)); ?></li>                                  
                                    </ul>
                                </li>
                                <li><?php echo $this->Html->link($this->Html->image("cestaticket.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Cestaticket", array('controller' => 'cestatickets', 'action' => 'index'), array('escape' => false)); ?></li>
                            </ul>    
                        </li>                     
                        <li>     
                            <?php echo $this->Html->link($this->Html->image("Cog.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Conceptos", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>     
                            <ul>          
                                <li><?php echo $this->Html->link($this->Html->image("News Add.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Asignaciones", array('controller' => 'asignaciones', 'action' => 'index'), array('escape' => false)); ?></li>
                                <li><?php echo $this->Html->link($this->Html->image("News Remove.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Deducciones", array('controller' => 'deducciones', 'action' => 'index'), array('escape' => false)); ?></li>                            
                            </ul> 
                        </li>
                        <li>     
                            <?php echo $this->Html->link($this->Html->image("Chart Bar.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Reportes", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>         
                            <ul>                                                                 
                                <li><?php echo $this->Html->link($this->Html->image("Document Checklist.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "Generar Reportes", array('controller' => 'reportes', 'action' => 'generar_reportes'), array('escape' => false)); ?></li>                                
                            </ul> 
                        </li>
                        <li style="float:right">
                            <?php echo $this->Html->link($this->Html->image("User.png", array('alt' => 'Usuario', 'height' => '18', 'width' => '18')) . " Usuarios", array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?>
                            <ul>                                                                 
                                <li><?php echo $this->Html->link($this->Html->image("icon-logout.gif", array('alt' => '', 'height' => '18', 'width' => '18')) . "Cambiar Contraseña", array('controller' => 'users', 'action' => 'cambiar_password'), array('escape' => false)); ?></li>                            
                            </ul> 
                        </li> 
                    </ul> 
                </div>                
                <div class="holder">                    
                    <?php echo $content_for_layout; ?>
                </div>               
                <div class="footer">
                </div> 
            </div>             
        </div>        
        <?php echo $this->Html->script('jquery.pngFix.js'); ?>
        <?php echo $this->Html->script('hoverIntent.js'); ?>
        <?php echo $this->Html->script('superfish.js'); ?>
        <?php echo $this->Html->script('supersubs.js'); ?>
        <?php echo $this->Html->script('date.js'); ?>
        <?php echo $this->Html->script('jquery.sparkbox-select.js'); ?>
        <?php echo $this->Html->script('jquery.datepicker.js'); ?>
        <?php echo $this->Html->script('jquery.filestyle.mini.js'); ?>
        <?php echo $this->Html->script('jquery.price_format.1.5'); ?>
        <?php echo $this->Html->script('inline1.js'); ?>        
    </body> 
</html> 