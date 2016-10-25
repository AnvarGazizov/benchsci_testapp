<div class="researchPapers form">
<?php echo $this->Form->create('ResearchPaper'); ?>
	<fieldset>
		<legend><?php echo __('Edit Research Paper'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('author');
		echo $this->Form->input('publisher');
		echo $this->Form->input('pub_date');
		echo $this->Form->input('figure_number');
		echo $this->Form->input('technique_group');
		echo $this->Form->input('gene');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ResearchPaper.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('ResearchPaper.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Research Papers'), array('action' => 'index')); ?></li>
	</ul>
</div>
