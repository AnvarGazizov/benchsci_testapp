<div class="researchPapers view">
<h2><?php echo __('Research Paper'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['author']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Publisher'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['publisher']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pub Date'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['pub_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Figure Number'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['figure_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Technique Group'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['technique_group']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gene'); ?></dt>
		<dd>
			<?php echo h($researchPaper['ResearchPaper']['gene']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Research Paper'), array('action' => 'edit', $researchPaper['ResearchPaper']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Research Paper'), array('action' => 'delete', $researchPaper['ResearchPaper']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $researchPaper['ResearchPaper']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Research Papers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Research Paper'), array('action' => 'add')); ?> </li>
	</ul>
</div>
