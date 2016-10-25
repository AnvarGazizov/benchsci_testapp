<div class="bookMarkedPapers view">
<h2><?php echo __('Book Marked Paper'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($bookMarkedPaper['BookMarkedPaper']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paper Id'); ?></dt>
		<dd>
			<?php echo h($bookMarkedPaper['BookMarkedPaper']['paper_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($bookMarkedPaper['BookMarkedPaper']['user_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Book Marked Paper'), array('action' => 'edit', $bookMarkedPaper['BookMarkedPaper']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Book Marked Paper'), array('action' => 'delete', $bookMarkedPaper['BookMarkedPaper']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $bookMarkedPaper['BookMarkedPaper']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Book Marked Papers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Book Marked Paper'), array('action' => 'add')); ?> </li>
	</ul>
</div>
