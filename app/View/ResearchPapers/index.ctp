<div class="researchPapers index">
	<h2><?php echo __('Research Papers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('author'); ?></th>
			<th><?php echo $this->Paginator->sort('publisher'); ?></th>
			<th><?php echo $this->Paginator->sort('pub_date'); ?></th>
			<th><?php echo $this->Paginator->sort('figure_number'); ?></th>
			<th><?php echo $this->Paginator->sort('technique_group'); ?></th>
			<th><?php echo $this->Paginator->sort('gene'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($researchPapers as $researchPaper): ?>
	<tr>
		<td><?php echo h($researchPaper['ResearchPaper']['id']); ?>&nbsp;</td>
		<td><?php echo h($researchPaper['ResearchPaper']['title']); ?>&nbsp;</td>
		<td><?php echo h($researchPaper['ResearchPaper']['author']); ?>&nbsp;</td>
		<td><?php echo h($researchPaper['ResearchPaper']['publisher']); ?>&nbsp;</td>
		<td><?php echo h($researchPaper['ResearchPaper']['pub_date']); ?>&nbsp;</td>
		<td><?php echo h($researchPaper['ResearchPaper']['figure_number']); ?>&nbsp;</td>
		<td><?php echo h($researchPaper['ResearchPaper']['technique_group']); ?>&nbsp;</td>
		<td><?php echo h($researchPaper['ResearchPaper']['gene']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $researchPaper['ResearchPaper']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $researchPaper['ResearchPaper']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $researchPaper['ResearchPaper']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $researchPaper['ResearchPaper']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Research Paper'), array('action' => 'add')); ?></li>
	</ul>
</div>
