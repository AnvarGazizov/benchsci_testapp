<div class="blogPosts view">
<h2><?php echo __('Blog Post'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($blogPost['BlogPost']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($blogPost['BlogPost']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author'); ?></dt>
		<dd>
			<?php echo h($blogPost['BlogPost']['author']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Headline'); ?></dt>
		<dd>
			<?php echo h($blogPost['BlogPost']['headline']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($blogPost['BlogPost']['content']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Blog Post'), array('action' => 'edit', $blogPost['BlogPost']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Blog Post'), array('action' => 'delete', $blogPost['BlogPost']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $blogPost['BlogPost']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Blog Posts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Post'), array('action' => 'add')); ?> </li>
	</ul>
</div>
