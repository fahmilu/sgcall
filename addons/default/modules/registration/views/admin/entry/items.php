<link rel="stylesheet" href="<?= site_url() ?>bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"/>
<style type="text/css">
	.mfp-bg{
		z-index: 11111;
	}
	.mfp-wrap{
		z-index: 111111;
	}
</style>
<section class="title">
	<h4>Data Entry</h4>
</section>
<section class="item">
	<div class="content">
		<?php //echo form_open('admin/registration/delete');?>
		<?php if (!empty($items)): ?>
			<!-- <div class="table_action_buttons form-group">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
			</div> -->
			<div role="tabpanel">
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="tab1">
						<?php echo form_open('admin/registration/action', 'class="crud"') ?>
						<table class="table table-striped table-bordered" id="data-table">
							<thead>
								<tr>
									<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
									<th style="width: 150px">Name</th>
									<th style="width: 100px">Gender</th>
									<th style="width: 100px">Email</th>
									<th style="width: 100px">Birtday</th>
									<th style="width: 100px">Province</th>
									<th style="width: 100px">Have ever been to Singapore?</th>
									<th style="width: 100px">How many time have been to Singapore?</th>
									<th>Created</th>
									<th class="text-right"><?php echo lang('action'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								foreach( $items as $item ): ?>
								<tr>
									<td><?php echo form_checkbox('action_to[]', $item->id) ?></td>
									<td><?php echo $item->name; ?></td>
									<td><?php echo $item->gender; ?></td>
									<td><?php echo $item->email; ?></td>
									<td><?php echo $item->birtday; ?></td>
									<td><?php echo $item->province; ?></td>
									<td><?php echo $item->visited_sg; ?></td>
									<td><?php echo $item->visited_sg_count; ?></td>
									<td><i class="fa fa-calendar"></i><?= date('D, d/m/Y',strtotime($item->created_at)) ?></td>
									<td class="actions">
                           				<?php echo anchor('admin/registration/delete/' . $item->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
									</td>
								</tr>
								<?php $no++; endforeach; ?>
							</tbody>
						</table>
						<div class="table_action_buttons">
			                <?php $this->load->view('admin/partials/buttons', array('buttons' => array('approve', 'delete'))); ?>
			            </div>
			            <?php echo form_close(); ?>
					</div>
				</div>
			</div>


		<?php else: ?>
			<div class="no_data"><?php echo lang('no_items'); ?></div>
		<?php endif;?>
		<?php //echo form_close(); ?>
	</div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="<?= site_url() ?>bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= site_url() ?>bootstrap/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.image-link').magnificPopup({type:'image'});
	});
</script>