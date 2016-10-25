<div class="blogPosts index">
	<h2><?php echo __('Blog Posts'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th><?php echo $this->Paginator->sort('author'); ?></th>
			<th><?php echo $this->Paginator->sort('headline'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($blogPosts as $blogPost): ?>
	<tr>
		<td><?php echo h($blogPost['BlogPost']['id']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['date']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['author']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['headline']); ?>&nbsp;</td>
		<td><?php echo h($blogPost['BlogPost']['content']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $blogPost['BlogPost']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $blogPost['BlogPost']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $blogPost['BlogPost']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $blogPost['BlogPost']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Blog Post'), array('action' => 'add')); ?></li>
	</ul>
</div>
