<div class="bookMarkedPapers form">
<?php echo $this->Form->create('BookMarkedPaper'); ?>
	<fieldset>
		<legend><?php echo __('Add Book Marked Paper'); ?></legend>
	<?php
		echo $this->Form->input('paper_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Book Marked Papers'), array('action' => 'index')); ?></li>
	</ul>
</div>
