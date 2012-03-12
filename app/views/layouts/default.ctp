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
                            <?php echo $this->Html->image('icon-logout.gif'); ?>
                            <?php echo $html->link('Salir', array('controller' => 'Users', 'action' => 'logout')); ?> 
                        </div> 

                    </div> 
                </div> 
                <!-- FIN TOP -->  
                <!-- INICIO MENU -->  
                <div class="menu">  
                    <ul> 
                        <li class="current" style="height:32px">
                            <?php echo $this->Html->link($this->Html->image("home1.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Inicio", array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>
                        </li> 
                        <li class="break"></li> 
                        <li><a href="#"><?php echo $this->Html->image('file1.png', array("alt" => "Definiciones", 'width' => '18', 'heigth' => '18', 'title' => 'Definiciones')); ?>Definiciones</a>     
                            <ul>
                                <li><?php echo $this->Html->link($this->Html->image("Finder.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Personal", array('controller' => 'empleados', 'action' => 'index'), array('escape' => false)); ?></li> 
                                <li><?php echo $this->Html->link($this->Html->image("User.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Cargos", array('controller' => 'cargos', 'action' => 'index'), array('escape' => false)); ?></li>                                                                  
                                <li><?php echo $this->Html->link($this->Html->image("Cog.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Departamentos", array('controller' => 'departamentos', 'action' => 'index'), array('escape' => false)); ?></li>                                
                                <li><?php echo $this->Html->link($this->Html->image("Money.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Historial de Sueldos", array('controller' => 'historiales', 'action' => 'index'), array('escape' => false)); ?></li>                                
                                <li><?php echo $this->Html->link($this->Html->image("Link.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Basicas", array('controller' => 'dependencias', 'action' => 'index'), array('escape' => false)); ?>
                                    <ul> 
                                        <li><?php echo $this->Html->link($this->Html->image("file1.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Familiares", array('controller' => 'familiares', 'action' => 'index'), array('escape' => false)); ?></li>
                                        <li><?php echo $this->Html->link($this->Html->image("file1.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Nivel Educativo", array('controller' => 'titulos', 'action' => 'index'), array('escape' => false)); ?></li>
                                        <li><?php echo $this->Html->link($this->Html->image("file1.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Islr", array('controller' => 'islrs', 'action' => 'index'), array('escape' => false)); ?></li>
                                        <li><?php echo $this->Html->link($this->Html->image("file1.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Desc Tribunales", array('controller' => 'tribunales', 'action' => 'index'), array('escape' => false)); ?></li>
                                        <li><?php echo $this->Html->link($this->Html->image("file1.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Dias Feriados", array('controller' => 'feriados', 'action' => 'index'), array('escape' => false)); ?></li>
                                    </ul>
                                </li>                                
                            </ul>
                        </li>
                        <li>
                            <a href="#"><?php echo $this->Html->image('disc.png', array("alt" => "consultar", 'width' => '18', 'heigth' => '18', 'title' => 'Inicio')); ?>   Procesos</a> 
                            <ul>                             
                                <li><?php echo $this->Html->link($this->Html->image("Drawer Closed.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Administrar Conceptos", array('controller' => 'administrarconceptos', 'action' => 'index'), array('escape' => false)); ?></li>     
                                <li><?php echo $this->Html->link($this->Html->image("Finder.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Fechas Nomina", array('controller' => 'fechanominas', 'action' => 'index'), array('escape' => false)); ?></li>
                                <li><?php echo $this->Html->link($this->Html->image("Button Remove.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Cargar Inasistencias", array('controller' => 'ausencias', 'action' => 'index'), array('escape' => false)); ?></li>         
                                <li><?php echo $this->Html->link($this->Html->image("Button White Add.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Cargar Horas Extras", array('controller' => 'extras', 'action' => 'index'), array('escape' => false)); ?></li>  
                                <li><?php echo $this->Html->link($this->Html->image("Drawer Closed.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "   Calculo de Nomina", array('controller' => 'nominas', 'action' => 'calcularNomina'), array('escape' => false)); ?></li>                 
                        </li> 
                    </ul>             
                    <li>     
                        <a href="#"><?php echo $this->Html->image('Cog.png', array("alt" => "consultar", 'width' => '18', 'heigth' => '18', 'title' => 'Conceptos')); ?>Conceptos</a>     
                        <ul>          
                            <li><?php echo $this->Html->link($this->Html->image("News Add.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Asignaciones de Ley", array('controller' => 'asignaciones', 'action' => 'view'), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link($this->Html->image("News Remove.png", array('alt' => '', 'height' => '18', 'width' => '18')) . " Deducciones de Ley", array('controller' => 'deducciones', 'action' => 'view'), array('escape' => false)); ?></li>
                        </ul> 
                    </li>
                    <li>     
                        <a href="#"><?php echo $this->Html->image('Chart Bar.png', array("alt" => "Reportes", 'width' => '18', 'heigth' => '18', 'title' => 'Reportes')); ?> Reportes</a>     
                        <ul>          
                            <li><?php echo $this->Html->link($this->Html->image("Camembert.png", array('alt' => '', 'height' => '18', 'width' => '18')) . "Personal Fijo", array('controller' => 'contratos', 'action' => 'index'), array('escape' => false)); ?></li>
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
                    <?php
                    if ($this->Session->check('Message.auth'))
                        echo //$this->Session->flash('auth'); // Ojo flash auth idk
                        print_r($this->Session->read());
                    ?>
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
    </body> 
</html> 