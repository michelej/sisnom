<?php 

class Eventualidad extends AppModel{
    
    var $name='Eventualidad';
    var $field='NOMBRE';
    
    var $hasMany=array('DetalleEventualidad');
    
       
     
      
}
?>