<div class="bookMarkedPapers form">
<?php echo $this->Form->create('BookMarkedPaper'); ?>
	<fieldset>
		<legend><?php echo __('Edit Book Marked Paper'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('paper_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('BookMarkedPaper.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('BookMarkedPaper.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Book Marked Papers'), array('action' => 'index')); ?></li>
	</ul>
</div>
