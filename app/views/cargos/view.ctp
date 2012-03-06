<div class="box">
    <div class="title"><h2>Datos del Cargo</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content forms">
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Descripción del Cargo'); ?>
            <?php echo $cargo['Cargo']['DESCRIPCION']; ?>
            <?php echo "</div>"; ?>
        </div>
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Sueldo'); ?>
            <?php echo number_format($cargo['Cargo']['SUELDO'], 2, ',', '.'); ?>
            <?php echo "</div>"; ?>
        </div>
        <div class="row">
            <?php echo "<div style='float:left;width:25%'>"; ?>
            <?php echo $this->Form->label('Estado del Cargo'); ?>       
            <?php echo $cargo['Cargo']['ESTADO']; ?>
            <?php echo "</div>"; ?>
        </div>


    </div>
</div>

<div class="box">
    <div class="title"><h2>Acciones</h2>
        <?php echo $this->Html->image("title-hide.gif", array('class' => 'toggle')); ?>
    </div>
    <div class="content form">
        <div class="row buttons">
            <div class="boton">
                <?php echo $this->Html->link(__('Regresar ', true), array('controller' => 'cargos', 'action' => 'view'), array('escape' => false)); ?>

            </div>
        </div>
    </div>


    <?php
    /*
      <div class="cargos view">
      <h2><?php  __('Cargo');?></h2>
      <dl><?php $i = 0; $class = ' class="altrow"';?>
      <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
      <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php  echo $cargo['Cargo']['id']; ?>
      &nbsp;
      </dd>
      <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('CAR DESCRIPCION'); ?></dt>
      <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $cargo['Cargo']['CAR_DESCRIPCION']; ?>
      &nbsp;
      </dd>
      <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('CAR ESTADO'); ?></dt>
      <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $cargo['Cargo']['CAR_ESTADO']; ?>
      &nbsp;
      </dd>
      <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('CAR UBICACION'); ?></dt>
      <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $cargo['Cargo']['CAR_UBICACION']; ?>
      &nbsp;
      </dd>
      <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sueldos'); ?></dt>
      <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $this->Html->link($cargo['Sueldos']['id'], array('controller' => 'sueldos', 'action' => 'view', $cargo['Sueldos']['id'])); ?>
      &nbsp;
      </dd>
      </dl>
      </div>
      <div class="actions">
      <h3><?php __('Actions'); ?></h3>
      <ul>
      <li><?php echo $this->Html->link(__('Edit Cargo', true), array('action' => 'edit', $cargo['Cargo']['id'])); ?> </li>
      <li><?php echo $this->Html->link(__('Delete Cargo', true), array('action' => 'delete', $cargo['Cargo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cargo['Cargo']['id'])); ?> </li>
      <li><?php echo $this->Html->link(__('List Cargos', true), array('action' => 'index')); ?> </li>
      <li><?php echo $this->Html->link(__('New Cargo', true), array('action' => 'add')); ?> </li>
      <li><?php echo $this->Html->link(__('List Sueldos', true), array('controller' => 'sueldos', 'action' => 'index')); ?> </li>
      <li><?php echo $this->Html->link(__('New Sueldos', true), array('controller' => 'sueldos', 'action' => 'add')); ?> </li>
      </ul>
      </div>
     */
    ?>