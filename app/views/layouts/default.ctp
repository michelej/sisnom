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
        <?php echo $this->Html->script('jquery-1.6.1.min.js'); ?>
    </head> 
    <body> 
        <!-- INICIO WRAPPER -->  
        <div class="wrapper"> 
            <!-- INICIO CONTAINER -->  
            <div class="container"> 
                <!-- INICIO TOP -->  
                <div class="top"> 
                    <div class="split"><h1>SISTEMA DE RECURSOS HUMANOS</h1></div> 
                    <div class="split"> 
                        <div class="logout">
                            <?php echo '( '.Authsome::get('USERNAME').') '.Authsome::get('NOMBRE').' '.Authsome::get('APELLIDO')?>
                            <?php echo $this->Html->image('icon-logout.gif'); ?>                            
                            <?php echo $html->link('Salir', array('controller' => 'users', 'action' => 'logout')); ?> 
                        </div> 

                    </div> 
                </div> 
                <!-- FIN TOP -->  
                <!-- INICIO MENU -->  
                <div class="menu">  
                    <ul> 
                        <li class="current" style="height:32px">
                            <?php echo $this->Html->link($this->Html->image("home1.png", array('alt' => 'Inicio', 'height' => '18', 'width' => '18')) . " Inicio", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>
                        </li> 
                        <li class="break"></li> 
                        <li><?php echo $this->Html->link($this->Html->image("file1.png", array('alt' => 'Definiciones', 'height' => '18', 'width' => '18')) . " Definiciones", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>    
                            <ul>
                                <li><?php echo $this->Html->link($this->Html->image("Finder.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Personal", array('controller' => 'empleados', 'action' => 'index'), array('escape' => false)); ?></li>                                 
                                <li><?php echo $this->Html->link($this->Html->image("User.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Cargos", array('controller' => 'cargos', 'action' => 'index'), array('escape' => false)); ?></li>                                                                  
                                <li><?php echo $this->Html->link($this->Html->image("Cog.png", array('alt' => 'Departamentos', 'height' => '18', 'width' => '18')) . "   Departamentos", array('controller' => 'departamentos', 'action' => 'index'), array('escape' => false)); ?></li>                                

                                <li><?php echo $this->Html->link($this->Html->image("Contacts.png", array('alt' => 'Basicas', 'height' => '18', 'width' => '18')) . " Basicas", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>
                                    <ul>                                        
                                        <li><?php echo $this->Html->link($this->Html->image("calendar_today.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Dias Feriados", array('controller' => 'feriados', 'action' => 'index'), array('escape' => false)); ?></li>
                                        <li><?php echo $this->Html->link($this->Html->image("Money.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Sueldo Minimo", array('controller' => 'variables', 'action' => 'sueldo_minimo'), array('escape' => false)); ?></li>
                                        <li><?php echo $this->Html->link($this->Html->image("Money Bundle.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Unidad Tributaria", array('controller' => 'variables', 'action' => 'unidad_tributaria'), array('escape' => false)); ?></li>
                                    </ul>
                                </li>                                
                            </ul>
                        </li>
                        <li>
                              <?php echo $this->Html->link($this->Html->image("disc.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Procesos", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?> 
                            <ul>                             
                                <li><?php echo $this->Html->link($this->Html->image("Drawer Closed.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Administrar Conceptos", array('controller' => 'ajustes', 'action' => 'index'), array('escape' => false)); ?></li>                                    
                                <li><?php echo $this->Html->link($this->Html->image("Database Add.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Cargar Deducciones", array('controller' => 'prestamos', 'action' => 'index'), array('escape' => false)); ?></li>                                  
                                <li><?php echo $this->Html->link($this->Html->image("Button Remove.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Cargar Ausencias", array('controller' => 'ausencias', 'action' => 'index'), array('escape' => false)); ?></li>         
                                <li><?php echo $this->Html->link($this->Html->image("Button White Add.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Cargar Horas Extras", array('controller' => 'horas_extras', 'action' => 'index'), array('escape' => false)); ?></li>                                                                  
                                <li><?php echo $this->Html->link($this->Html->image("News.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Administrar Nominas", array('controller' => 'nominas', 'action' => 'index'), array('escape' => false)); ?></li>                                
                        </li> 
                    </ul>             
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
                            <li>
                                <?php echo $this->Html->link($this->Html->image("Camembert.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "Personal", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>
                                <ul>
                                    <li><?php echo $this->Html->link(" Fijo", array('controller' => 'reportes', 'action' => 'empleados_fijos'), array('escape' => false)); ?></li>
                                    <li><?php echo $this->Html->link(" Contratado", array('controller' => 'reportes', 'action' => 'empleados_contratados'), array('escape' => false)); ?></li>
                                </ul>
                            </li>                            
                        </ul> 
                    </li> 
                    </ul> 
                </div> 
                <!-- END MENU -->  
                <!-- INICIO HOLDER -->  
                <div class="holder">                    
                    <?php echo $content_for_layout; ?>
                </div>
                <!-- FIN HOLDER -->  
                <div class="footer">
                    
                </div> 
            </div> 
            <!-- FIN CONTAINER -->   
        </div>
        <!-- FIN WRAPPER -->  
        <?php echo $this->Html->script('jquery-ui-1.8.12.js'); ?>
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
        <?php echo $this->Html->script('common.js'); ?>
    </body> 
</html> 