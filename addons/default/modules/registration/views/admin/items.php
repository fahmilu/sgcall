<link rel="stylesheet" href="<?= site_url() ?>bootstrap/css/bootstrap.css"/>
<section class="title">
	<h4><?php echo lang('item_list'); ?></h4>
</section>

<section class="item">
	<div class="content">
	<?php echo form_open('admin/impact/delete');?>
	
	<?php if (!empty($items)): ?>
		
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>Id.</th>
					<th width="600"><?php echo lang('title'); ?></th>
					<th><?php echo lang('created_updated'); ?></th>
					<th class="text-right"><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				foreach( $items as $item ): ?>
				<tr>
					<td><?= $no; ?></td>
					<td><?= $item->id; ?></td>
					<td>
					<strong><?php echo $item->title; ?></strong><br/>
					<small><?php echo $item->subtitle; ?></small>
					<td>
					<div class="form-group">
						<i class="fa fa-calendar"></i> | <?= date('D, d/m/Y',strtotime($item->created_at)) ?>
					</div>
						<i class="fa fa-calendar"></i> | <?= date('D, d/m/Y',strtotime($item->updated_at)) ?>	
					</td>
					</td>
					<td class="actions">
						<?php echo anchor('admin/intro/edit/'.$item->id,'<i class="fa fa-pencil"></i>', 'class="button btn gray small"');?>
					</td>
				</tr>
				<?php $no++; endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="9">
						<div class="inner"> 
						<?php $this->load->view('admin/partials/pagination') ?>
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
	</div>
</section>
<script type="text/javascript" src="<?= site_url() ?>bootstrap/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>